<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminBlogController extends Controller
{
    public function index(): View
    {
        return view('admin.blogs.index', ['blogs' => BlogPost::latest()->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.blogs.create', ['blog' => new BlogPost(['status' => 'draft'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        BlogPost::create($this->validatedData($request));

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created.');
    }

    public function edit(BlogPost $blog): View
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, BlogPost $blog): RedirectResponse
    {
        $blog->update($this->validatedData($request, $blog));

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated.');
    }

    public function destroy(BlogPost $blog): RedirectResponse
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted.');
    }

    private function validatedData(Request $request, ?BlogPost $blog = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_posts,slug,'.($blog?->id ?? 'NULL')],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'excerpt' => ['required', 'string'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['published_at'] = $validated['status'] === 'published'
            ? ($validated['published_at'] ?? now())
            : null;

        if ($request->hasFile('featured_image')) {
            if ($blog?->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        return $validated;
    }
}
