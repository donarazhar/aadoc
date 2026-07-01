<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = \App\Models\Document::with(['category', 'author'])->orderBy('id', 'desc')->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
        ]);

        \App\Models\Document::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title) . '-' . time(),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'is_published' => $request->has('is_published'),
            'created_by' => auth()->id(),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(\App\Models\Document $document)
    {
        $categories = \App\Models\Category::all();
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, \App\Models\Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
        ]);

        $document->update([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title) . '-' . time(),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'is_published' => $request->has('is_published'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(\App\Models\Document $document)
    {
        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
