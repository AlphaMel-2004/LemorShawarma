<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLegalSettingsRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LegalSettingsController extends Controller
{
    /**
     * Show legal settings page.
     */
    public function edit(): View
    {
        $settings = SiteSetting::getLegalSettings();

        return view('admin.legal.edit', compact('settings'));
    }

    /**
     * Persist legal settings.
     */
    public function update(UpdateLegalSettingsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated as $key => $value) {
            SiteSetting::setValue($key, trim((string) $value));
        }

        return redirect()->route('admin.legal.edit')
            ->with('success', 'Legal pages updated successfully.');
    }
}
