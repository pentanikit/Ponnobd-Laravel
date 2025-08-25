<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::latest()
                                ->when(request('search'), function ($query) {
                                    $query->where('name', 'LIKE', '%'.request('search').'%');
                                })
                                ->paginate(20);

        return view('backend.blog.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'parent_category_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        return to_route('blog.categories.index')->with('success', 'Category added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        return view('backend.blog.categories.edit', compact('category'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:blog_categories,slug,'.$id,
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        return to_route('blog.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $this->destroy($id);
            }

            session()->flash('success', count($ids).' Bulk deleted successfully!');

            return 1;
        }
        session()->flash('error', 'Whoops, something went wrong!');

        return 0;
    }
}
