<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminSettingController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.index', [
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'website_name' => ['nullable', 'string', 'max:255'],
            'business_email' => ['nullable', 'email', 'max:255'],
            'business_phone' => ['nullable', 'string', 'max:255'],
            'business_address' => ['nullable', 'string'],
            'footer_text' => ['nullable', 'string'],
            'currency' => ['nullable', 'string', 'max:10'],
            'shipping_amount' => ['nullable', 'numeric', 'min:0'],
            'tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'minimum_order_amount' => ['nullable', 'numeric', 'min:0'],
            'home_hero_title' => ['nullable', 'string', 'max:255'],
            'home_hero_subtitle' => ['nullable', 'string'],
            'about_page_content' => ['nullable', 'string'],
            'contact_page_content' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('settings', 'public');
        }

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['group' => 'general', 'value' => $value, 'type' => 'string']);
        }

        return back()->with('success', 'Settings saved.');
    }
}
