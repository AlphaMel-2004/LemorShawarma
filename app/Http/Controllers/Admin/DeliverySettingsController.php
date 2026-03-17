<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateDeliverySettingsRequest;
use App\Models\Location;
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
        $websiteHomeUrl = route('home');
        $websiteLocationsUrl = $this->getWebsiteLocationsUrl();
        $mobileMenuUrl = route('mobile.menu');
        $mobileFeedbackUrl = route('mobile.feedback.page');

        return view('admin.delivery.edit', compact(
            'settings',
            'websiteHomeUrl',
            'websiteLocationsUrl',
            'mobileMenuUrl',
            'mobileFeedbackUrl',
        ));
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

    private function getWebsiteLocationsUrl(): string
    {
        $location = Location::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->first(['address', 'latitude', 'longitude']);

        if (! $location) {
            return route('home').'#locations';
        }

        $directionQuery = $location->latitude !== null && $location->longitude !== null
            ? $location->latitude.','.$location->longitude
            : urlencode((string) $location->address);

        return 'https://www.google.com/maps/search/?api=1&query='.$directionQuery;
    }
}
