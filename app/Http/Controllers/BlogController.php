<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Support\SiteData;
use Illuminate\Database\QueryException;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('blog.index', [
            'metaTitle' => 'Fishing Blog | M&M Custom Tackle',
            'metaDescription' => 'Fishing tips, tackle guidance, and Sarasota saltwater insights from M&M Custom Tackle.',
            'posts' => $this->posts(),
        ]);
    }

    public function show(string $slug): View
    {
        $post = $this->posts()->firstWhere('slug', $slug) ?? abort(404);

        return view('blog.show', [
            'metaTitle' => $post->title.' | M&M Custom Tackle',
            'metaDescription' => $post->excerpt,
            'post' => $post,
        ]);
    }

    private function posts()
    {
        try {
            $items = BlogPost::query()->latest('published_at')->get();
            if ($items->isNotEmpty()) {
                return $items;
            }
        } catch (QueryException) {
        }

        return collect(SiteData::blogPosts())->map(fn ($item) => (object) $item);
    }
}
