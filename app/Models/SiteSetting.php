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
     * The default legal page settings.
     *
     * @var array<string, string>
     */
    public const LEGAL_DEFAULTS = [
        'legal_last_updated' => 'March 15, 2026',
        'legal_privacy_intro' => 'This page explains in simple terms how we handle your information.',
        'legal_privacy_summary' => "We collect only the details needed to run the website and process feedback.\nWe do not sell your personal data.\nYou can request access, correction, or deletion of your data where laws allow.",
        'legal_privacy_content' => "## 1. Scope\nThis policy explains how Pita Queen collects, uses, stores, and protects personal information through our website, including menu browsing and feedback forms.\n\n## 2. Information We Collect\nWe may collect contact and submission data such as name, email address, rating, and feedback message when you contact us or submit a testimonial. We may also collect technical data like IP address, device type, browser details, and page interactions for security and analytics.\n\n## 3. How We Use Information\nWe use personal data to operate the website, process feedback, improve food and service quality, monitor website performance, and maintain account, fraud, and abuse protections.\n\n## 4. Legal Basis and Consent\nWhere required by law, we process data based on consent, legitimate business interests, contractual necessity, or legal obligations. You may withdraw consent for optional processing where applicable.\n\n## 5. Data Sharing and Processors\nWe do not sell personal data. We may share limited information with trusted third-party providers for hosting, infrastructure, analytics, and operational support under appropriate safeguards.\n\n## 6. Retention\nWe retain personal information only for as long as needed for the purposes stated in this policy, then delete or anonymize it unless longer retention is required by law.\n\n## 7. Security\nWe maintain reasonable technical and organizational measures to protect information from unauthorized access, alteration, disclosure, or destruction.\n\n## 8. Your Rights\nDepending on your jurisdiction, you may request access, correction, deletion, portability, or restriction of your personal data. To make a request, contact us using our published contact channels.\n\n## 9. Children's Privacy\nOur website is not directed to children under the age required by local law for independent consent. If we learn that personal data of a child was collected unlawfully, we will take appropriate action.\n\n## 10. Policy Changes\nWe may update this policy from time to time. Changes become effective once posted on this page, and the updated date will be revised accordingly.\n\n## 11. Contact\nQuestions about this policy may be sent through our contact section.",
        'legal_terms_intro' => 'These are the rules for using our site and menu information.',
        'legal_terms_summary' => "Menu prices and availability can change without notice.\nPlease contact us directly about allergies before ordering.\nUsing the website means you agree to these terms.",
        'legal_terms_content' => "## 1. Acceptance\nBy accessing or using this website, you agree to these Terms of Service. If you do not agree, please discontinue use of the website.\n\n## 2. Permitted Use\nYou agree to use the site lawfully and not interfere with security, availability, or functionality. Automated scraping, abuse, and unauthorized access attempts are prohibited.\n\n## 3. Menu, Pricing, and Availability\nMenu items, images, descriptions, and prices are provided for information and may change without notice. Availability may vary by location, time, and supply conditions.\n\n## 4. Food Allergy and Dietary Notice\nOur food may contain or come into contact with common allergens. Ingredient and allergen information may change. Customers with allergies or dietary restrictions should contact us directly before ordering.\n\n## 5. Orders and Cancellations\nOrder handling, cancellation, and refund eligibility depend on preparation status, timing, and store policy. Contact the store promptly for order concerns.\n\n## 6. Third-Party Services\nSome features may rely on third-party services such as hosting or analytics. Their availability and terms may affect how parts of this website function.\n\n## 7. Intellectual Property\nAll branding, logos, text, photos, and website content are owned by Pita Queen or its licensors and may not be used without permission, except as allowed by law.\n\n## 8. Disclaimer and Liability Limits\nThe website is provided on an as-is and as-available basis. To the extent permitted by law, we disclaim warranties and are not liable for indirect, incidental, or consequential damages.\n\n## 9. Governing Law\nThese terms are governed by applicable local laws in the jurisdiction where Pita Queen operates, without prejudice to mandatory consumer rights.\n\n## 10. Changes to Terms\nWe may revise these terms at any time. Updated versions are effective when posted on this page with a revised date.\n\n## 11. Contact\nFor questions, use the contact information shown on our website.",
        'legal_cookies_intro' => 'This page explains what cookies we use and how you can control them.',
        'legal_cookies_summary' => "Essential cookies keep key website features working.\nAnalytics cookies help us improve performance and usability.\nYou can manage cookies in your browser settings anytime.",
        'legal_cookies_content' => "## 1. What Cookies Are\nCookies are small text files placed on your device when you visit a website. They help websites recognize returning visitors and keep essential features working.\n\n## 2. Cookies We Use\nWe may use essential cookies (security and site operation), analytics cookies (traffic and performance measurement), and preference cookies (remembering selected options).\n\n## 3. Third-Party Technologies\nTrusted third parties may set cookies or similar technologies to provide infrastructure, performance monitoring, and analytics support for our website.\n\n## 4. How to Manage Cookies\nYou can control or disable cookies via browser settings. Blocking some cookies may affect website performance or disable important features.\n\n## 5. Updates to This Policy\nWe may update this Cookie Policy periodically. Material updates will be reflected by changing the date on this page.\n\n## 6. Contact\nIf you have questions about cookies or tracking on this site, contact us through our website contact details.",
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
     * Get all legal settings as an associative array.
     *
     * @return array<string, string|null>
     */
    public static function getLegalSettings(): array
    {
        $settings = [];

        foreach (self::LEGAL_DEFAULTS as $key => $default) {
            $settings[$key] = self::getValue($key, $default);
        }

        return $settings;
    }

    /**
     * Clear all site setting caches.
     */
    public static function clearCache(): void
    {
        foreach (array_keys(self::CONTACT_DEFAULTS + self::CHATBOT_DEFAULTS + self::LEGAL_DEFAULTS) as $key) {
            Cache::forget("site_setting.{$key}");
        }
    }
}
