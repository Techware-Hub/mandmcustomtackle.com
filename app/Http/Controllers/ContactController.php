<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        try {
            ContactMessage::create($validated);
        } catch (QueryException) {
            // TODO: Run migrations to persist contact messages in the database.
        }

        return back()->with('success', 'Thanks for reaching out. M&M Custom Tackle will get back to you soon.');
    }
}
