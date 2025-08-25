<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
        * Display a listing of the resource.
    */
    public function index()
    {
        $posts = Blog::latest()
                            ->when(request('search'), function ($query) {
                                $query->where('name', 'LIKE', '%'.request('search').'%');
                            })
                            ->paginate(20);

        return view('backend.blog.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.blog.posts.create', [
            'categories' => BlogCategory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:blog_categories,id',
            'thumbnail' => 'nullable',
            'slug' => 'required|unique:blogs,slug',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $post = new Blog();
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->description = $request->description;
        $post->category_id = $request->category_id;
        $post->thumbnail = $request->thumbnail;
        $post->thumbnail_alt = $request->thumbnail_alt;
        $post->meta_keywords = $request->meta_keywords;
        $post->meta_title = $request->meta_title == null ? $request->title : $request->meta_title;
        $post->meta_description = $request->meta_description == null ? $request->description : $request->meta_description;
        $post->save();

        return to_route('posts.index')->with('success', 'Post updated successfully!');
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
        $post = Blog::findOrFail($id);
        $categories = BlogCategory::all();

        return view('backend.blog.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'nullable|exists:blog_categories,id',
            'thumbnail' => 'nullable',
            'slug' => 'required|unique:blogs,slug,'.$id,
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $post = Blog::findOrFail($id);
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->description = $request->description;
        $post->category_id = $request->category_id;
        $post->thumbnail = $request->thumbnail;
        $post->thumbnail_alt = $request->thumbnail_alt;
        $post->meta_keywords = $request->meta_keywords;
        $post->meta_title = $request->meta_title == null ? $request->title : $request->meta_title;
        $post->meta_description = $request->meta_description == null ? $request->description : $request->meta_description;
        $post->save();

        return to_route('posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Blog::findOrFail($id);

        $category->delete();

        return back()->with('success', 'Post deleted successfully!');

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
