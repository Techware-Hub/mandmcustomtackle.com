<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerAccountController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::user();

        return view('customer.account', [
            'metaTitle' => 'My Account | M&M Custom Tackle',
            'user' => $user,
            'orders' => $user->orders()->latest()->take(5)->get(),
        ]);
    }
}
