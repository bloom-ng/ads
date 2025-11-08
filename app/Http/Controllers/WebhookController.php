<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetaFlowResponse;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle verification from Meta (Facebook)
     */
    public function verify(Request $request)
    {
        $verify_token = config('services.whatsapp.verify_token'); // Set this in your .env
        $mode = $request->get('hub_mode');
        $token = $request->get('hub_verify_token');
        $challenge = $request->get('hub_challenge');

        if ($mode === 'subscribe' && $token === $verify_token) {
            return response($challenge, 200);
        }

        return response('Forbidden', 403);
    }

    /**
     * Handle incoming webhook events from Meta Flow
     */
    public function handle(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('Meta Flow Webhook Data:', $data);

            $senderId = $data['entry'][0]['messaging'][0]['sender']['id'] ?? null;
            $recipientId = $data['entry'][0]['messaging'][0]['recipient']['id'] ?? null;

            MetaFlowResponse::create([
                'sender_id' => $senderId,
                'recipient_id' => $recipientId,
                'payload' => $data,
            ]);

            return response()->json(['status' => 'success'], 200);
        } catch (\Throwable $th) {
            Log::error('Meta Flow Webhook Error: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to process'], 500);
        }
    }
}
