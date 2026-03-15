<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateChatbotSettingsRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ChatbotSettingsController extends Controller
{
    /**
     * Show chatbot settings page.
     */
    public function edit(): View
    {
        $settings = SiteSetting::getChatbotSettings();

        return view('admin.chatbot.edit', compact('settings'));
    }

    /**
     * Persist chatbot settings.
     */
    public function update(UpdateChatbotSettingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $normalized = [
            'chatbot_enabled' => $request->boolean('chatbot_enabled') ? '1' : '0',
            'chatbot_name' => trim((string) $validated['chatbot_name']),
            'chatbot_welcome_message' => trim((string) $validated['chatbot_welcome_message']),
            'chatbot_fab_icon' => trim((string) $validated['chatbot_fab_icon']),
            'chatbot_model' => trim((string) $validated['chatbot_model']),
            'chatbot_knowledge' => trim((string) ($validated['chatbot_knowledge'] ?? '')),
            'chatbot_restrictions' => trim((string) ($validated['chatbot_restrictions'] ?? '')),
            'chatbot_temperature' => (string) $validated['chatbot_temperature'],
            'chatbot_max_tokens' => (string) $validated['chatbot_max_tokens'],
        ];

        foreach ($normalized as $key => $value) {
            SiteSetting::setValue($key, $value);
        }

        return redirect()->route('admin.chatbot.edit')
            ->with('success', 'Chatbot settings updated successfully.');
    }
}
