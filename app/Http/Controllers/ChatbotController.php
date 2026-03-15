<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatbotMessageRequest;
use App\Models\SiteSetting;
use App\Services\HuggingFaceChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function __construct(private readonly HuggingFaceChatService $huggingFaceChatService) {}

    /**
     * Handle chatbot prompt from public site.
     */
    public function reply(StoreChatbotMessageRequest $request): JsonResponse
    {
        $settings = SiteSetting::getChatbotSettings();

        if (($settings['chatbot_enabled'] ?? '0') !== '1') {
            return response()->json([
                'message' => 'Assistant is currently disabled.',
            ], 403);
        }

        try {
            $reply = $this->huggingFaceChatService->generateResponse(
                (string) $request->validated('message'),
                $settings,
            );
        } catch (\Throwable $exception) {
            Log::warning('Chatbot response failed.', [
                'exception' => $exception::class,
            ]);

            $reply = 'I am having trouble answering right now. Please try again in a moment.';
        }

        return response()->json([
            'reply' => $reply,
            'assistant' => $settings['chatbot_name'] ?? 'Assistant',
        ]);
    }
}
