<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_chatbot_returns_403_when_disabled(): void
    {
        SiteSetting::setValue('chatbot_enabled', '0');

        $response = $this->post($this->siteUrl('/chatbot/message'), [
            'message' => 'What is your best seller?',
        ]);

        $response->assertStatus(403);
    }

    public function test_chatbot_returns_model_response_when_enabled(): void
    {
        SiteSetting::setValue('chatbot_enabled', '1');

        Http::fake([
            'router.huggingface.co/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Try our chicken shawarma and garlic fries combo.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        config()->set('services.huggingface.token', 'test-token');

        $response = $this->post($this->siteUrl('/chatbot/message'), [
            'message' => 'Any recommendation for dinner?',
        ]);

        $response->assertOk();
        $response->assertJsonPath('reply', 'Try our chicken shawarma and garlic fries combo.');
    }

    public function test_chatbot_sanitizes_generated_text(): void
    {
        SiteSetting::setValue('chatbot_enabled', '1');

        Http::fake([
            'router.huggingface.co/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => '<script>alert(1)</script>We are open daily.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        config()->set('services.huggingface.token', 'test-token');

        $response = $this->post($this->siteUrl('/chatbot/message'), [
            'message' => 'When are you open?',
        ]);

        $response->assertOk();
        $response->assertJsonPath('reply', 'We are open daily.');
    }

    public function test_chatbot_parses_object_generated_text_payload(): void
    {
        SiteSetting::setValue('chatbot_enabled', '1');

        Http::fake([
            'router.huggingface.co/*' => Http::response([
                'generated_text' => 'Pita Queen is a premium Mediterranean restaurant focused on shawarma and pita dishes.',
            ], 200),
        ]);

        config()->set('services.huggingface.token', 'test-token');

        $response = $this->post($this->siteUrl('/chatbot/message'), [
            'message' => 'Tell me about this business',
        ]);

        $response->assertOk();
        $response->assertJsonPath('reply', 'Pita Queen is a premium Mediterranean restaurant focused on shawarma and pita dishes.');
    }

    public function test_chatbot_parses_chat_completion_choices_payload(): void
    {
        SiteSetting::setValue('chatbot_enabled', '1');

        Http::fake([
            'router.huggingface.co/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Our newest items include chef-crafted wraps and signature bowls.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        config()->set('services.huggingface.token', 'test-token');

        $response = $this->post($this->siteUrl('/chatbot/message'), [
            'message' => 'What are your new products?',
        ]);

        $response->assertOk();
        $response->assertJsonPath('reply', 'Our newest items include chef-crafted wraps and signature bowls.');
    }

    public function test_chatbot_retries_with_default_chat_model_when_current_model_is_not_supported(): void
    {
        SiteSetting::setValue('chatbot_enabled', '1');
        SiteSetting::setValue('chatbot_model', 'google/flan-t5-base');

        Http::fake([
            'router.huggingface.co/*' => Http::sequence()
                ->push([
                    'error' => [
                        'message' => "The requested model 'google/flan-t5-base' is not a chat model.",
                    ],
                ], 400)
                ->push([
                    'choices' => [
                        [
                            'message' => [
                                'content' => 'Try our new falafel wrap with garlic sauce.',
                            ],
                        ],
                    ],
                ], 200),
        ]);

        config()->set('services.huggingface.token', 'test-token');
        config()->set('services.huggingface.model', 'google/flan-t5-base');

        $response = $this->post($this->siteUrl('/chatbot/message'), [
            'message' => 'What is your new product?',
        ]);

        $response->assertOk();
        $response->assertJsonPath('reply', 'Try our new falafel wrap with garlic sauce.');
    }

    public function test_chatbot_prompt_includes_live_contact_product_and_location_data(): void
    {
        SiteSetting::setValue('chatbot_enabled', '1');
        SiteSetting::setValue('contact_phone', '+1 800 777 1212');
        SiteSetting::setValue('contact_email', 'hello@pitaqueen.test');
        SiteSetting::setValue('contact_hours', 'Mon-Sun: 10AM-11PM');
        SiteSetting::setValue('contact_address_line1', '123 Royal Ave');
        SiteSetting::setValue('contact_address_line2', 'Downtown');

        Product::factory()->create([
            'name' => 'Smoky Chicken Wrap',
            'price' => 12.50,
            'is_active' => true,
        ]);

        Location::factory()->create([
            'name' => 'Downtown Branch',
            'address' => '100 Main St',
            'phone' => '+1 800 777 4444',
            'hours' => 'Mon-Sun: 10AM-11PM',
            'is_active' => true,
        ]);

        Http::fake([
            'router.huggingface.co/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Great choice. Try our smoky chicken wrap.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        config()->set('services.huggingface.token', 'test-token');

        $response = $this->post($this->siteUrl('/chatbot/message'), [
            'message' => 'What should I order?',
        ]);

        $response->assertOk();

        Http::assertSent(function ($request): bool {
            $payload = $request->data();
            $systemPrompt = (string) ($payload['messages'][0]['content'] ?? '');

            return str_contains($systemPrompt, 'Contacts:')
                && str_contains($systemPrompt, '+1 800 777 1212')
                && str_contains($systemPrompt, 'Smoky Chicken Wrap')
                && str_contains($systemPrompt, 'Downtown Branch');
        });
    }
}
