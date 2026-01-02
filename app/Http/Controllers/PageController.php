<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Add this at the top if not already present

class PageController extends Controller
{
    public function index() {
        $pages = Page::all();
        return view('pages.index', compact('pages'));
    }

    public function create() {
        return view('pages.create');
    }

    public function store(Request $request) {
        \Log::info($request->all());
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages',
            'content' => 'required',
            'status' => 'required|in:draft,published', // Add status validation
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'content' => $request->content,
            'status' => $request->status, // Save status
        ]);

        return redirect()->route('pages.index')->with('success', 'Page created.');
    }

    public function edit(Page $page) {
        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page) {
        $page->update($request->all());
        return redirect()->route('pages.index')->with('success', 'Page updated.');
    }

    public function destroy(Page $page) {
        $page->delete();
        return back()->with('success', 'Page deleted.');
    }
}
