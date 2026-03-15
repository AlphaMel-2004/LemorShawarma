<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SiteSetting::CONTACT_DEFAULTS + SiteSetting::CHATBOT_DEFAULTS as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
    }
}
