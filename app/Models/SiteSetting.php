<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    /** @use HasFactory<\Database\Factories\SiteSettingFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * The default contact settings.
     *
     * @var array<string, string>
     */
    public const CONTACT_DEFAULTS = [
        'contact_address_line1' => '123 Royal Avenue',
        'contact_address_line2' => 'Downtown District, NY 10001',
        'contact_phone' => '+1 (555) 123-4567',
        'contact_email' => 'info@pitaqueenhub.com',
        'contact_hours' => 'Mon - Sun: 11AM - 11PM',
    ];

    /**
     * The default chatbot settings.
     *
     * @var array<string, string>
     */
    public const CHATBOT_DEFAULTS = [
        'chatbot_enabled' => '1',
        'chatbot_name' => 'Pita Queen Assistant',
        'chatbot_welcome_message' => 'Hi! I can help with menu suggestions, store info, and quick answers about Pita Queen.',
        'chatbot_fab_icon' => 'chat-dots',
        'chatbot_model' => 'meta-llama/Llama-3.1-8B-Instruct:fastest',
        'chatbot_knowledge' => 'Pita Queen serves premium Mediterranean cuisine with shawarma, pita, and grilled favorites. For final order confirmation, always ask users to proceed to the menu or contact options.',
        'chatbot_restrictions' => 'Never provide medical, legal, or financial advice. Avoid harmful instructions. If unsure, politely say you are not certain and suggest contacting the restaurant directly.',
        'chatbot_temperature' => '0.4',
        'chatbot_max_tokens' => '180',
    ];

    /**
     * Chatbot FAB icon options.
     *
     * @var array<string, array{icon: string, label: string}>
     */
    public const CHATBOT_FAB_ICON_OPTIONS = [
        'chat-dots' => [
            'icon' => 'bi-chat-dots-fill',
            'label' => 'Chat Dots',
        ],
        'robot' => [
            'icon' => 'bi-robot',
            'label' => 'Robot',
        ],
        'sparkles' => [
            'icon' => 'bi-stars',
            'label' => 'Sparkles',
        ],
        'chat-heart' => [
            'icon' => 'bi-chat-heart-fill',
            'label' => 'Chat Heart',
        ],
        'chat-text' => [
            'icon' => 'bi-chat-text-fill',
            'label' => 'Chat Text',
        ],
        'lightbulb' => [
            'icon' => 'bi-lightbulb-fill',
            'label' => 'Lightbulb',
        ],
    ];

    /**
     * Get a setting value by key, with optional default.
     */
    public static function getValue(string $key, ?string $default = null): ?string
    {
        return Cache::remember("site_setting.{$key}", 3600, function () use ($key, $default): ?string {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    /**
     * Set a setting value by key.
     */
    public static function setValue(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);

        Cache::forget("site_setting.{$key}");
    }

    /**
     * Get all contact settings as an associative array.
     *
     * @return array<string, string|null>
     */
    public static function getContactSettings(): array
    {
        $settings = [];

        foreach (self::CONTACT_DEFAULTS as $key => $default) {
            $settings[$key] = self::getValue($key, $default);
        }

        return $settings;
    }

    /**
     * Get all chatbot settings as an associative array.
     *
     * @return array<string, string|null>
     */
    public static function getChatbotSettings(): array
    {
        $settings = [];

        foreach (self::CHATBOT_DEFAULTS as $key => $default) {
            $settings[$key] = self::getValue($key, $default);
        }

        return $settings;
    }

    /**
     * Clear all site setting caches.
     */
    public static function clearCache(): void
    {
        foreach (array_keys(self::CONTACT_DEFAULTS + self::CHATBOT_DEFAULTS) as $key) {
            Cache::forget("site_setting.{$key}");
        }
    }
}
