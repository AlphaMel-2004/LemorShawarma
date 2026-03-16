<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateDeliverySettingsRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DeliverySettingsController extends Controller
{
    /**
     * Show the delivery settings page.
     */
    public function edit(): View
    {
        $settings = SiteSetting::getDeliverySettings();
        $mobileMenuUrl = route('mobile.menu');
        $mobileFeedbackUrl = route('mobile.feedback.page');

        return view('admin.delivery.edit', compact('settings', 'mobileMenuUrl', 'mobileFeedbackUrl'));
    }

    /**
     * Persist delivery app settings.
     */
    public function update(UpdateDeliverySettingsRequest $request): RedirectResponse
    {
        foreach (array_keys(SiteSetting::DELIVERY_APP_META) as $key) {
            SiteSetting::setValue("delivery_{$key}_enabled", $request->boolean("delivery_{$key}_enabled") ? '1' : '0');
            SiteSetting::setValue("delivery_{$key}_name", trim((string) $request->input("delivery_{$key}_name")));
            SiteSetting::setValue("delivery_{$key}_url", trim((string) $request->input("delivery_{$key}_url")));
        }

        return redirect()->route('admin.delivery.edit')
            ->with('success', 'Delivery app settings updated successfully.');
    }
}
