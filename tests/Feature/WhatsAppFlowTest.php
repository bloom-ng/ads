<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\BloomLead;
use Illuminate\Support\Facades\Config;

class WhatsAppFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_flow_to_phone_generates_correct_token_and_sends_request()
    {
        // Mock config
        Config::set('services.whatsapp.access_token', 'test_token');
        Config::set('services.whatsapp.phone_number_id', '123456789');
        Config::set('services.whatsapp.template_name', 'flow_template');
        Config::set('services.whatsapp.template_language', 'en_US');

        // Mock Http facade
        Http::fake([
            'graph.facebook.com/*' => Http::response(['messages' => [['id' => 'wamid.HBgL...']]], 200),
        ]);

        $phone = '2348012345678';

        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->postJson('/flows/send', [
            'phone' => $phone
        ]);

        $response->assertStatus(200);

        // Verify the lead was created with the correct token format
        $lead = BloomLead::where('phone_number', $phone)->first();
        $this->assertNotNull($lead, 'Lead was not created');
        $this->assertStringStartsWith('flows-builder-', $lead->flow_token);
        
        // Verify token is alphanumeric after prefix (alphanumeric check on suffix)
        $suffix = Str::replaceFirst('flows-builder-', '', $lead->flow_token);
        $this->assertTrue(ctype_alnum($suffix), "Token suffix '$suffix' is not alphanumeric");

        // Verify Http request was sent with the token
        Http::assertSent(function ($request) use ($lead) {
            $data = $request->data();
            
            // Navigate to the flow_token in the structure
            $flowTokenSent = $data['template']['components'][0]['parameters'][0]['action']['flow_token'] ?? null;
            
            return $flowTokenSent === $lead->flow_token;
        });
    }
}
