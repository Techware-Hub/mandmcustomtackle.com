<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminGalleryController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery.index', ['items' => GalleryItem::latest()->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.gallery.create', ['item' => new GalleryItem(['status' => 'active'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        GalleryItem::create($this->validatedData($request));

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item created.');
    }

    public function edit(GalleryItem $gallery): View
    {
        return view('admin.gallery.edit', ['item' => $gallery]);
    }

    public function update(Request $request, GalleryItem $gallery): RedirectResponse
    {
        $gallery->update($this->validatedData($request, $gallery));

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(GalleryItem $gallery): RedirectResponse
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted.');
    }

    private function validatedData(Request $request, ?GalleryItem $item = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if ($request->hasFile('image')) {
            if ($item?->image) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        return $validated;
    }
}
