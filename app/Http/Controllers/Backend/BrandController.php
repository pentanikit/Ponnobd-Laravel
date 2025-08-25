<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->paginate(20);

        return view('backend.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'logo' => 'required',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->slug = Str::slug($request->name);
        $brand->logo = $request->logo;
        $brand->meta_title = $request->meta_title == null ? $request->name : $request->meta_title;
        $brand->meta_description = $request->meta_description == null ? $request->description : $request->meta_description;
        $brand->save();

        return to_route('brand.index')->with('success', 'Brand added successfully!');
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
        $brand = Brand::findOrFail($id);

        return view('backend.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'logo' => 'required',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->slug = Str::slug($request->name);
        $brand->logo = $request->logo;
        $brand->meta_title = $request->meta_title == null ? $request->name : $request->meta_title;
        $brand->meta_description = $request->meta_description == null ? $request->description : $request->meta_description;
        $brand->save();

        return to_route('brand.index')->with('success', 'Brand updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();

        return back()->with('success', 'Brand deleted successfully!');
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
