<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotSettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_chatbot_settings_page(): void
    {
        $response = $this->get($this->adminUrl('/chatbot'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_update_chatbot_settings(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->put($this->adminUrl('/chatbot'), [
            'chatbot_enabled' => '1',
            'chatbot_name' => 'Golden Assistant',
            'chatbot_welcome_message' => 'Welcome to Pita Queen support!',
            'chatbot_fab_icon' => 'robot',
            'chatbot_model' => 'google/flan-t5-base',
            'chatbot_knowledge' => 'We serve premium shawarma and pita meals.',
            'chatbot_restrictions' => 'Never provide harmful instructions.',
            'chatbot_temperature' => '0.4',
            'chatbot_max_tokens' => '160',
        ]);

        $response->assertRedirect(route('admin.chatbot.edit'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', [
            'key' => 'chatbot_name',
            'value' => 'Golden Assistant',
        ]);

        $this->assertDatabaseHas('site_settings', [
            'key' => 'chatbot_fab_icon',
            'value' => 'robot',
        ]);
    }

    public function test_admin_chatbot_settings_page_is_accessible(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get($this->adminUrl('/chatbot'));

        $response->assertOk();
        $response->assertViewIs('admin.chatbot.edit');
    }
}
