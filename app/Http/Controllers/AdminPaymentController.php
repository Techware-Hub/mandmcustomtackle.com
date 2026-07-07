<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPaymentController extends Controller
{
    public function index(): View
    {
        return view('admin.payments.index', [
            'payments' => Payment::with('order')->latest()->paginate(20),
        ]);
    }

    public function integration(): View
    {
        return view('admin.payments.integration', [
            'settings' => Setting::where('group', 'payments')->pluck('value', 'key'),
        ]);
    }

    public function updateIntegration(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'stripe_public_key' => ['nullable', 'string'],
            'stripe_secret_key' => ['nullable', 'string'],
            'paypal_client_id' => ['nullable', 'string'],
            'paypal_secret' => ['nullable', 'string'],
            'enable_stripe' => ['nullable', 'boolean'],
            'enable_paypal' => ['nullable', 'boolean'],
        ]);

        foreach (['enable_stripe', 'enable_paypal'] as $toggle) {
            $validated[$toggle] = $request->boolean($toggle) ? '1' : '0';
        }

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['group' => 'payments', 'value' => $value, 'type' => 'string']);
        }

        return back()->with('success', 'Payment settings saved.');
    }
}
