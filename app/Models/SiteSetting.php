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
     * The default branch location settings.
     *
     * @var array<string, string>
     */
    public const BRANCH_LOCATION_DEFAULTS = [
        'branch_location_name' => 'Downtown Flagship',
        'branch_location_address' => '123 Golden Avenue, Downtown District',
        'branch_location_phone' => '+1 (555) 123-4567',
        'branch_location_hours' => 'Mon-Sun: 11AM - 11PM',
        'branch_location_map_url' => 'https://maps.google.com/?q=123+Golden+Avenue,+Downtown+District',
        'branch_location_image_url' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400',
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
        return self::getSettings(self::CONTACT_DEFAULTS);
    }

    /**
     * Get all branch location settings as an associative array.
     *
     * @return array<string, string|null>
     */
    public static function getBranchLocationSettings(): array
    {
        return self::getSettings(self::BRANCH_LOCATION_DEFAULTS);
    }

    /**
     * Clear all site setting caches.
     */
    public static function clearCache(): void
    {
        foreach (self::getCacheableKeys() as $key) {
            Cache::forget("site_setting.{$key}");
        }
    }

    /**
     * Get settings using the provided defaults.
     *
     * @param  array<string, string>  $defaults
     * @return array<string, string|null>
     */
    private static function getSettings(array $defaults): array
    {
        $settings = [];

        foreach ($defaults as $key => $default) {
            $settings[$key] = self::getValue($key, $default);
        }

        return $settings;
    }

    /**
     * Get all site setting keys that should be cached.
     *
     * @return list<string>
     */
    private static function getCacheableKeys(): array
    {
        return array_keys(self::CONTACT_DEFAULTS + self::BRANCH_LOCATION_DEFAULTS);
    }
}
