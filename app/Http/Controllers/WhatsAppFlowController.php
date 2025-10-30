<?php

namespace App\Http\Controllers;

use App\Models\BloomLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\AES;

class WhatsAppFlowController extends Controller
{
    /**
     * Verify webhook for WhatsApp (GET request)
     */
    public function verifyWebhook(Request $request)
    {
        $verifyToken = config('services.whatsapp.verify_token');
        $mode = $request->get('hub_mode');
        $token = $request->get('hub_verify_token');
        $challenge = $request->get('hub_challenge');

        if ($mode && $token === $verifyToken) {
            Log::info('Webhook verified successfully');
            return response($challenge, 200)->header('Content-Type', 'text/plain');
        }

        Log::warning('Webhook verification failed');
        return response('Verification failed', 403);
    }

    /**
     * Handle WhatsApp Flow requests (POST)
     * Based on Meta Flow Endpoint documentation
     */
    public function handleFlow(Request $request)
    {
        try {
            // Log incoming request
            Log::info('WhatsApp Flow Request', [
                'body' => $request->all(),
                'signature' => $request->header('X-Hub-Signature-256')
            ]);

            // Verify signature
            if (!$this->verifySignature($request)) {
                Log::error('Signature verification failed');
                return $this->errorResponse('Invalid signature', 403);
            }

            // Decrypt the request
            $decryptedRequest = $this->decryptRequest($request->all());

            if (!$decryptedRequest) {
                Log::error('Decryption failed');
                return response()->json(['error' => 'Decryption failed'], 421);
            }

            // Extract action early to check if it's a ping
            $action = $decryptedRequest['action'] ?? null;

            // Validate structure based on action type
            if ($action === 'ping') {
                // Ping only requires version and action
                $validator = Validator::make($decryptedRequest, [
                    'version' => 'required|string',
                    'action' => 'required|string'
                ]);
            } else {
                // All other actions require flow_token
                $validator = Validator::make($decryptedRequest, [
                    'version' => 'required|string',
                    'action' => 'required|string',
                    'flow_token' => 'required|string'
                ]);
            }

            if ($validator->fails()) {
                Log::error('Validation failed', ['errors' => $validator->errors()]);
                return $this->errorResponse('Invalid request structure');
            }

            // Handle ping immediately without lead
            if ($action === 'ping') {
                $response = $this->handlePing();

                Log::info('Flow Response', [
                    'action' => 'ping',
                    'status' => 'success'
                ]);

                // Encrypt and return response
                $encryptedResponse = $this->encryptResponse($response, $request->all());
                return response($encryptedResponse, 200)->header('Content-Type', 'text/plain');
            }

            // For non-ping actions, extract flow_token and screen/data
            $flowToken = $decryptedRequest['flow_token'];
            $screen = $decryptedRequest['screen'] ?? null;
            $data = $decryptedRequest['data'] ?? [];

            // Get or create lead
            $lead = BloomLead::firstOrCreate(
                ['flow_token' => $flowToken],
                ['raw_data' => []]
            );

            // Route based on action
            $response = match ($action) {
                'INIT' => $this->handleInit($lead),
                'BACK' => $this->handleBack($lead, $screen, $data),
                'data_exchange' => $this->handleDataExchange($lead, $screen, $data),
                default => throw new \Exception('Unknown action: ' . $action)
            };

            Log::info('Flow Response', [
                'action' => $action,
                'screen' => $response->screen ?? null,
                'lead_id' => $lead->id
            ]);

            // Encrypt and return response
            $encryptedResponse = $this->encryptResponse($response, $request->all());
            return response($encryptedResponse, 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            Log::error('Flow Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse('Internal error: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Verify X-Hub-Signature-256 header
     */
    private function verifySignature(Request $request)
    {
        $signature = $request->header('X-Hub-Signature-256');
        $appSecret = config('services.whatsapp.app_secret');

        if (!$signature || !$appSecret) {
            return true; // Skip if not configured
        }

        $payload = $request->getContent();
        $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $appSecret);

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Decrypt incoming request payload
     * Based on Meta's encryption specification for data_api_version 3.0
     */
    private function decryptRequest(array $requestData)
    {
        try {
            // Validate required fields
            if (
                !isset($requestData['encrypted_flow_data']) ||
                !isset($requestData['encrypted_aes_key']) ||
                !isset($requestData['initial_vector'])
            ) {
                throw new \Exception('Missing required encryption fields');
            }

            // Extract and decode encrypted components
            $encryptedFlowData = base64_decode($requestData['encrypted_flow_data'], true);
            $encryptedAesKey = base64_decode($requestData['encrypted_aes_key'], true);
            $initialVector = base64_decode($requestData['initial_vector'], true);

            if ($encryptedFlowData === false || $encryptedAesKey === false || $initialVector === false) {
                throw new \Exception('Failed to decode base64 data');
            }

            Log::info('Decryption debug', [
                'encrypted_aes_key_length' => strlen($encryptedAesKey),
                'encrypted_flow_data_length' => strlen($encryptedFlowData),
                'initial_vector_length' => strlen($initialVector)
            ]);

            // Load private key
            $privateKeyContent = config('services.whatsapp.private_key_content');
            $passphrase = config('services.whatsapp.private_key_passphrase', '');

            if (empty($privateKeyContent)) {
                throw new \Exception('Private key content is empty');
            }

            // Step 1: Decrypt AES key using RSA with OAEP (SHA-256)
            // This matches Meta's example exactly
            try {
                $rsa = RSA::load($privateKeyContent, $passphrase)
                    ->withPadding(RSA::ENCRYPTION_OAEP)
                    ->withHash('sha256')
                    ->withMGFHash('sha256');

                $aesKey = $rsa->decrypt($encryptedAesKey);

                if (!$aesKey) {
                    throw new \Exception('RSA decryption returned empty result');
                }

                Log::info('AES key decrypted successfully', [
                    'aes_key_length' => strlen($aesKey)
                ]);
            } catch (\Exception $e) {
                throw new \Exception('Failed to decrypt AES key: ' . $e->getMessage());
            }

            // Step 2: Decrypt flow data using AES-128-GCM
            $tagLength = 16;

            if (strlen($encryptedFlowData) < $tagLength) {
                throw new \Exception('Encrypted flow data is too short');
            }

            $encryptedFlowDataBody = substr($encryptedFlowData, 0, -$tagLength);
            $authTag = substr($encryptedFlowData, -$tagLength);

            Log::info('Decrypting flow data', [
                'encrypted_body_length' => strlen($encryptedFlowDataBody),
                'auth_tag_length' => strlen($authTag),
                'iv_length' => strlen($initialVector)
            ]);

            try {
                // Use phpseclib3 for AES-GCM decryption
                $aes = new AES('gcm');
                $aes->setKey($aesKey);
                $aes->setNonce($initialVector);
                $aes->setTag($authTag);

                $decryptedData = $aes->decrypt($encryptedFlowDataBody);

                if (!$decryptedData) {
                    throw new \Exception('AES-GCM decryption returned empty result');
                }

                Log::info('Flow data decrypted successfully', [
                    'decrypted_length' => strlen($decryptedData)
                ]);
            } catch (\Exception $e) {
                throw new \Exception('Failed to decrypt flow data: ' . $e->getMessage());
            }

            // Store AES key and IV for response encryption
            $this->aesKey = $aesKey;
            $this->initialVector = $initialVector;

            // Parse JSON
            $decodedData = json_decode($decryptedData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Failed to parse decrypted JSON: ' . json_last_error_msg());
            }

            Log::info('Request decrypted and parsed successfully', [
                'action' => $decodedData['action'] ?? 'unknown'
            ]);

            return $decodedData;
        } catch (\Exception $e) {
            Log::error('Decryption error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Encrypt response payload
     * Based on Meta's encryption specification
     */
    private function encryptResponse(array $response, array $requestData)
    {
        try {
            // Use the same AES key and IV from request
            $aesKey = $this->aesKey;
            $initialVector = $this->initialVector;

            if (!$aesKey || !$initialVector) {
                throw new \Exception('AES key or IV not available for encryption');
            }

            // Flip the initialization vector (invert all bits)
            // Use bitwise NOT operator as in Meta's example
            $flippedIv = ~$initialVector;

            // Encode response as JSON
            $jsonResponse = json_encode($response);

            Log::info('Encrypting response', [
                'response_length' => strlen($jsonResponse),
                'iv_length' => strlen($flippedIv)
            ]);

            // Encrypt using AES-128-GCM with flipped IV
            $tag = '';
            $encryptedData = openssl_encrypt(
                $jsonResponse,
                'aes-128-gcm',
                $aesKey,
                OPENSSL_RAW_DATA,
                $flippedIv,
                $tag,
                '', // empty AAD (Additional Authentication Data)
                16  // 128-bit (16 byte) tag length
            );

            if ($encryptedData === false) {
                throw new \Exception('Failed to encrypt response: ' . openssl_error_string());
            }

            // Append authentication tag and encode as base64
            $encrypted = base64_encode($encryptedData . $tag);

            Log::info('Response encrypted successfully', [
                'encrypted_length' => strlen($encrypted)
            ]);

            return $encrypted;
        } catch (\Exception $e) {
            Log::error('Encryption error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Fallback: return plain JSON (not recommended for production)
            return json_encode($response);
        }
    }

    /**
     * Return error response
     */
    private function errorResponse(string $message, int $statusCode = 400)
    {
        return response()->json([
            'error_msg' => $message
        ], $statusCode);
    }

    /**
     * Handle ping (health check)
     */
    private function handlePing()
    {
        return [
            'version' => '3.0',
            'data' => (object) [
                'status' => 'active'
            ]
        ];
    }

    /**
     * Handle INIT action
     */
    private function handleInit(BloomLead $lead)
    {
        Log::info('Flow initialized', ['lead_id' => $lead->id]);

        return [
            'version' => '3.0',
            'screen' => 'WELCOME',
            'data' => (object) []
        ];
    }

    /**
     * Handle BACK action (when user presses back button)
     */
    private function handleBack(BloomLead $lead, ?string $screen, array $data)
    {
        Log::info('Back button pressed', [
            'lead_id' => $lead->id,
            'screen' => $screen
        ]);

        // Return same screen with current data
        return [
            'version' => '3.0',
            'screen' => $screen ?? 'WELCOME',
            'data' => (object) $data
        ];
    }

    /**
     * Handle data_exchange action
     */
    private function handleDataExchange(BloomLead $lead, ?string $currentScreen, array $data)
    {
        // Store raw screen data
        $rawData = $lead->raw_data ?? [];
        $rawData[$currentScreen] = $data;
        $lead->raw_data = $rawData;

        // Update lead fields
        $this->updateLeadFields($lead, $data);

        // Determine next screen
        $nextScreen = $this->getNextScreen($lead, $currentScreen, $data);

        // Check if flow should complete
        if ($nextScreen === 'SUCCESS') {
            $lead->save();
            return $this->finalResponse($lead);
        }

        // Prepare data for next screen
        $responseData = $this->prepareScreenData($lead, $nextScreen);

        // Save lead
        $lead->save();

        Log::info('Data Exchange', [
            'lead_id' => $lead->id,
            'current_screen' => $currentScreen,
            'next_screen' => $nextScreen
        ]);

        return [
            "version" => "3.0",
            "screen" => $nextScreen,
            "data" => $responseData
        ];
    }

    /**
     * Generate final response for flow completion
     */
    private function finalResponse(BloomLead $lead)
    {
        return (object) [
            'version' => '3.0',
            'screen' => 'SUCCESS',
            'data' => (object) [
                'extension_message_response' => (object) [
                    'params' => (object) [
                        'flow_token' => $lead->flow_token,
                        'lead_id' => $lead->id,
                        'client_name' => $lead->client_name,
                        'brand_name' => $lead->brand_name,
                        'status' => $lead->status
                    ]
                ]
            ]
        ];
    }

    /**
     * Update lead fields based on incoming data
     */
    private function updateLeadFields(BloomLead $lead, array $data)
    {
        $fieldMapping = [
            'client_name' => 'client_name',
            'brand_name' => 'brand_name',
            'industry' => 'industry',
            'services' => 'services',
            'budget' => 'budget',
            'goals' => 'goals',
            'timeline' => 'timeline',
            'contact_method' => 'contact_method'
        ];

        foreach ($fieldMapping as $dataKey => $modelField) {
            if (isset($data[$dataKey])) {
                if ($dataKey === 'services') {
                    $lead->$modelField = is_array($data[$dataKey]) ? $data[$dataKey] : [$data[$dataKey]];
                } else {
                    $lead->$modelField = $data[$dataKey];
                }
            }
        }
    }

    /**
     * Determine next screen with routing logic
     */
    private function getNextScreen(BloomLead $lead, ?string $currentScreen, array $data)
    {
        return match ($currentScreen) {
            'WELCOME' => $this->routeFromWelcome($data),
            'ABOUT_BLOOM' => $this->routeFromAboutBloom($lead, $data),
            'COLLECT_NAME' => 'COLLECT_BUSINESS',
            'COLLECT_BUSINESS' => 'COLLECT_INDUSTRY',
            'COLLECT_INDUSTRY' => 'SELECT_SERVICES',
            'SELECT_SERVICES' => 'SELECT_BUDGET',
            'SELECT_BUDGET' => 'BUDGET_ROUTER',
            'BUDGET_ROUTER' => $this->routeFromBudgetRouter($lead),
            'COLLECT_GOALS' => 'SELECT_TIMELINE',
            'SELECT_TIMELINE' => 'SELECT_CONTACT',
            'SELECT_CONTACT' => $this->routeToConfirmation($lead),
            'CONFIRMATION' => 'SUCCESS', // Flow completion
            default => 'WELCOME'
        };
    }

    private function routeFromWelcome(array $data)
    {
        if (isset($data['choice']) && $data['choice'] === 'learn_more') {
            return 'ABOUT_BLOOM';
        }
        return 'COLLECT_NAME';
    }

    private function routeFromAboutBloom(BloomLead $lead, array $data)
    {
        if (isset($data['ready']) && $data['ready'] === 'no') {
            $lead->status = 'not_ready';
            return 'NOT_READY_END';
        }
        return 'COLLECT_NAME';
    }

    private function routeFromBudgetRouter(BloomLead $lead)
    {
        if ($lead->budget === 'below_300k') {
            $lead->status = 'low_budget';
            $lead->tag = 'Nurture List';
            return 'LOW_BUDGET_END';
        }
        return 'COLLECT_GOALS';
    }

    private function routeToConfirmation(BloomLead $lead)
    {
        $lead->status = 'qualified';
        $lead->tag = 'Qualified Lead – Hot';
        $lead->completed_at = now();

        $this->notifyTeam($lead);

        return 'CONFIRMATION';
    }

    /**
     * Prepare data for next screen
     */
    private function prepareScreenData(BloomLead $lead, string $nextScreen)
    {
        $data = [];

        switch ($nextScreen) {
            case 'COLLECT_BUSINESS':
            case 'CONFIRMATION':
                $data['client_name'] = $lead->client_name ?? '';
                break;

            case 'COLLECT_INDUSTRY':
                $data['brand_name'] = $lead->brand_name ?? '';
                break;

            case 'BUDGET_ROUTER':
                $data['budget'] = $lead->budget ?? '';
                break;
        }

        // return $data;
        return (object) $data;
    }

    /**
     * Send notification to team via email
     */
    private function notifyTeam(BloomLead $lead)
    {
        try {
            // Get team emails from config
            $teamEmails = config('bloom.notification_emails', []);

            if (empty($teamEmails)) {
                Log::warning('No team emails configured for notifications');
                return;
            }

            // Prepare notification data
            $servicesText = is_array($lead->services)
                ? implode(', ', array_map(fn($s) => $this->formatServiceName($s), $lead->services))
                : $lead->services;

            $notificationData = [
                'lead' => $lead,
                'services_text' => $servicesText,
                'industry_name' => $lead->industry_name,
                'budget_range' => $lead->budget_range,
                'timeline' => $this->formatTimeline($lead->timeline),
                'contact_method' => $this->formatContactMethod($lead->contact_method)
            ];

            // Send email to each team member
            foreach ($teamEmails as $email) {
                Mail::send('emails.new-lead-notification', $notificationData, function ($message) use ($email, $lead) {
                    $message->to($email)
                        ->subject('🎉 New Qualified Lead - ' . $lead->client_name . ' (' . $lead->brand_name . ')');
                });
            }

            Log::info('Team notification emails sent', [
                'lead_id' => $lead->id,
                'recipients' => $teamEmails
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send team notification', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function formatServiceName(string $service)
    {
        $services = [
            'social_media' => 'Social Media Management & Advertising',
            'branding_strategy' => 'Branding & Strategy',
            'media_production' => 'Media Production',
            'web_app_dev' => 'Website/App Development',
            'it_solutions' => 'IT Solutions/Automation',
            'digital_ads' => 'Digital Ads',
            'public_relations' => 'Public Relations',
            'digital_campaign' => 'Digital Campaign',
            'branding_design' => 'Branding & Design',
            'brand_strategy' => 'Brand Strategy'
        ];
        return $services[$service] ?? $service;
    }

    private function formatTimeline(string $timeline)
    {
        $timelines = [
            'immediately' => 'Immediately',
            'within_1_month' => 'Within 1 Month',
            '2_3_months' => '2-3 Months',
            'just_exploring' => 'Just Exploring'
        ];
        return $timelines[$timeline] ?? $timeline;
    }

    private function formatContactMethod(string $method)
    {
        $methods = [
            'whatsapp' => 'WhatsApp Chat',
            'phone' => 'Phone Call',
            'email' => 'Email'
        ];
        return $methods[$method] ?? $method;
    }

    // Admin endpoints (same as before)
    public function getAllLeads(Request $request)
    {
        $query = BloomLead::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tag')) {
            $query->where('tag', $request->tag);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                    ->orWhere('brand_name', 'like', "%{$search}%");
            });
        }

        $leads = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 20));

        return response()->json(['success' => true, 'data' => $leads]);
    }

    public function getLead($id)
    {
        try {
            $lead = BloomLead::findOrFail($id);
            return response()->json(['success' => true, 'data' => $lead]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lead not found'], 404);
        }
    }

    // Properties to store encryption keys during request lifecycle
    private $aesKey;
    private $initialVector;
}
