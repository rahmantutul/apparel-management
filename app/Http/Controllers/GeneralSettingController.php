<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    public function edit()
    {
        $settings = GeneralSetting::settings();
        return view('admin.general_setting', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string',
            'company_tagline' => 'nullable|string|max:255',
            'company_types' => 'nullable|string|max:255',
            'subscription_type' => 'nullable|string|max:255',
            'subscription_price' => 'nullable|numeric',
            'company_com_holiday_emp1' => 'nullable|string|max:255',
            'company_com_holiday_emp2' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $settings = GeneralSetting::settings();

        if ($request->hasFile('company_logo')) {
            if ($settings->company_logo) {
                Storage::delete($settings->company_logo);
            }
            
            $path = $request->file('company_logo')->store('settings/logo', 'public');
            $data['company_logo'] = $path;
        }

        $settings->update($data);

        return redirect()->route('general_settings.edit')
            ->with('success', 'Settings updated successfully!');
    }
}
