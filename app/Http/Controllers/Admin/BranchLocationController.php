<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateBranchLocationRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BranchLocationController extends Controller
{
    /**
     * Show the branch location settings edit form.
     */
    public function edit(): View
    {
        $settings = SiteSetting::getBranchLocationSettings();

        return view('admin.branch-locations.edit', compact('settings'));
    }

    /**
     * Update the branch location settings.
     */
    public function update(UpdateBranchLocationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        foreach ($validated as $key => $value) {
            SiteSetting::setValue($key, $value);
        }

        return redirect()->route('admin.branch-locations.edit')
            ->with('success', 'Branch location updated successfully.');
    }
}
