<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $categories = Category::withCount('products')
                                ->with('parentCategory')
                                ->latest()
                                ->when(request('search'), function ($query) {
                                    $query->where('name', 'LIKE', '%'.request('search').'%');
                                })
                                ->paginate(20);
                                
                                
                       

        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.categories.create', [
            'categories' => Category::withCount('products')->get(),
        ]);
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

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->parent_id = $request->parent_category_id;
        $category->icon = $request->icon;
        $category->meta_keywords = $request->meta_keywords;
        $category->meta_title = $request->meta_title == null ? $request->name : $request->meta_title;
        $category->meta_description = $request->meta_description == null ? $request->description : $request->meta_description;
        $category->save();

        return to_route('categories.index')->with('success', 'Category added successfully!');
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
        $category = Category::findOrFail($id);
        $categories = Category::withCount('products')->get();

        return view('backend.categories.edit', compact('category', 'categories'));
    }

    /**
     * Category featured
     */
    public function updateFeatured(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->featured = $request->status;
        if ($category->save()) {
            return 1;
        }

        return 0;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'parent_category_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable',
            'slug' => 'required|unique:categories,slug,'.$id,
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->parent_id = $request->parent_category_id;
        $category->icon = $request->icon;
        $category->meta_keywords = $request->meta_keywords;
        $category->meta_title = $request->meta_title == null ? $request->name : $request->meta_title;
        $category->meta_description = $request->meta_description == null ? $request->description : $request->meta_description;
        $category->save();

        return to_route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        ProductCategories::where('category_id',$category->id)->delete();
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

        return 1;
    }
}