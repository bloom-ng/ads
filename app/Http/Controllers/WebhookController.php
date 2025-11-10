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
     * Handle incoming webhook events from Meta / WhatsApp
     */
    public function handle(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('Meta/WhatsApp Webhook Data:', $data);

            // Persist raw payload and any IDs we can infer
            $senderId = $data['entry'][0]['messaging'][0]['sender']['id'] ?? null; // Messenger style
            $recipientId = $data['entry'][0]['messaging'][0]['recipient']['id'] ?? null;

            // WhatsApp style extraction (defensive)
            $waMessage   = $data['entry'][0]['changes'][0]['value']['messages'][0] ?? null;
            $waFrom      = $waMessage['from'] ?? null; // sender's phone number (string)
            $waType      = $waMessage['type'] ?? null;
            $waTextBody  = null;
            if ($waType === 'text') {
                $waTextBody = $waMessage['text']['body'] ?? null;
            } elseif (isset($waMessage['button']['text'])) {
                $waTextBody = $waMessage['button']['text'];
            } elseif (isset($waMessage['interactive']['button_reply']['title'])) {
                $waTextBody = $waMessage['interactive']['button_reply']['title'];
            }

            MetaFlowResponse::create([
                'sender_id' => $senderId ?? $waFrom,
                'recipient_id' => $recipientId,
                'payload' => $data,
            ]);

            // If we have a WhatsApp text message, check for greeting keywords (robust match)
            if ($waFrom && is_string($waTextBody)) {
                $text = strtolower(trim($waTextBody));
                // strip punctuation/emojis and collapse whitespace
                $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
                $text = preg_replace('/\s+/', ' ', $text);

                // Match greetings as whole words anywhere in the message
                if (preg_match('/\b(hi|hello|hey|good morning|good afternoonn)\b/u', $text)) {
                    $controller = app(WhatsAppFlowController::class);
                    $controller->sendFlowToPhone(new Request(['phone' => $waFrom]));
                    Log::info('Triggered sendFlowToPhone for number', ['phone' => $waFrom, 'matched_text' => $text]);
                }
            }

            return response()->json(['status' => 'success'], 200);
        } catch (\Throwable $th) {
            Log::error('Meta Flow Webhook Error: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to process'], 500);
        }
    }
}
