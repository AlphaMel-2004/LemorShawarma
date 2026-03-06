<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateContactRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the contact settings edit form.
     */
    public function edit(): View
    {
        $settings = SiteSetting::getContactSettings();

        return view('admin.contacts.edit', compact('settings'));
    }

    /**
     * Update the contact settings.
     */
    public function update(UpdateContactRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated as $key => $value) {
            SiteSetting::setValue($key, $value);
        }

        return redirect()->route('admin.contacts.edit')
            ->with('success', 'Contact information updated successfully.');
    }
}
