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
     * Clear all site setting caches.
     */
    public static function clearCache(): void
    {
        foreach (array_keys(self::CONTACT_DEFAULTS) as $key) {
            Cache::forget("site_setting.{$key}");
        }
    }
}
