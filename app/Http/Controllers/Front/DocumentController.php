<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['documents' => function($q) {
            $q->where('is_published', true);
        }])->orderBy('order')->get();
        
        return view('front.home', compact('categories'));
    }

    public function category($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $document = Document::where('category_id', $category->id)->where('is_published', true)->orderBy('order')->first();

        if ($document) {
            return redirect()->route('docs.show', [$categorySlug, $document->slug]);
        }

        $allCategories = Category::with(['documents' => function($q) {
            $q->where('is_published', true)->orderBy('order');
        }])->orderBy('order')->get();

        return view('front.show', compact('category', 'document', 'allCategories'));
    }

    public function show($categorySlug, $documentSlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $document = Document::where('category_id', $category->id)
                            ->where('slug', $documentSlug)
                            ->where('is_published', true)
                            ->firstOrFail();

        $allCategories = Category::with(['documents' => function($q) {
            $q->where('is_published', true)->orderBy('order');
        }])->orderBy('order')->get();

        return view('front.show', compact('category', 'document', 'allCategories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $documents = Document::where('is_published', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->with('category')
            ->get();

        return view('front.search', compact('documents', 'query'));
    }
}
