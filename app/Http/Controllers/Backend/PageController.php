<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::latest()->paginate();

        return view('backend.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:pages',
            'slug' => 'required|unique:pages,slug',
            'content' => 'required',
        ]);

        $page = new Page;
        $page->name = $request->name;
        $page->type = 'custom';
        $page->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        $page->content = $request->content;
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->keywords = $request->keywords;
        $page->save();

        return to_route('pages.index')->with('success', 'Page has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Page::findOrFail($id);

        return view('backend.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', Rule::unique('pages')->ignore($id)],
            'slug' => ['required', Rule::unique('pages')->ignore($id)],
            'content' => 'required',
        ]);

        $page = Page::findOrFail($id);
        $page->name = $request->name;
        $page->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        $page->content = $request->content;
        $page->meta_title = $request->meta_title;
        $page->meta_description = $request->meta_description;
        $page->keywords = $request->keywords;
        $page->save();

        return to_route('pages.index')->with('success', 'Page has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Page::destroy($id);

        return to_route('pages.index')->with('success', 'Page deleted successfully!');
    }

    public function aboutUs()
    {
        return view('backend.pages.about');
    }

    public function contactUs()
    {
        return view('backend.pages.contact');
    }

    public function home()
    {
        return view('backend.pages.home');
    }

    public function footer()
    {
        return view('backend.pages.footer');
    }

    public function header()
    {
        return view('backend.pages.header');
    }

    public function system()
    {
        return view('backend.pages.system');
    }
}
