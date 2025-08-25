<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DisplaySection;
use App\Models\Product;
use App\Models\ProductBySection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeSectionController extends Controller
{
    public function index()
    {
        $sections = DisplaySection::withCount('products')->orderBy('order')->paginate();

        return view('backend.home_section.index', compact('sections'));
    }

    public function create()
    {

        $categories = Cache::rememberForever('categories', function () {
            return Category::select('id', 'name')->get();
        });

        return view('backend.home_section.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'order' => 'required',
            'button_url' => 'nullable|active_url',
            'product_ids' => 'required|array|min:1',
        ]);

        $display = new DisplaySection();
        $display->name = $request->name;
        $display->categories = json_encode($request->category_ids);
        $display->short_description = $request->short_description;
        $display->order = $request->order;
        $display->button_text = $request->button_text;
        $display->button_url = $request->button_url;
        $display->save();

        $products = [];

        foreach ($request->product_ids as $product_id) {
            $products[] = [
                'product_id' => $product_id,
                'section_id' => $display->id,
            ];
        }

        ProductBySection::insert($products);

        Cache::forget('display_sections');

        return to_route('settings.home.section.index')->with('success', 'Section added successfully!');

    }

    public function edit($id)
    {
        $section = DisplaySection::with('products')->findOrFail($id);

        $products = Cache::rememberForever('published_products', function () {
            return Product::publish()->select('id', 'name')->get();
        });

        $categories = Cache::rememberForever('categories', function () {
            return Category::select('id', 'name')->get();
        });

        return view('backend.home_section.edit', compact('section', 'products', 'categories'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'order' => 'required',
            'button_url' => 'nullable|active_url',
            'product_ids' => 'required|array|min:1',
        ]);

        $display = DisplaySection::findOrFail($request->id);
        $display->categories = json_encode($request->category_ids);
        $display->name = $request->name;
        $display->short_description = $request->short_description;
        $display->order = $request->order;
        $display->button_text = $request->button_text;
        $display->button_url = $request->button_url;
        $display->save();

        $display->products->each->delete();

        $products = [];

        foreach ($request->product_ids as $product_id) {
            $products[] = [
                'product_id' => $product_id,
                'section_id' => $display->id,
            ];
        }

        ProductBySection::insert($products);
        Cache::forget('display_sections');

        return to_route('settings.home.section.index')->with('success', 'Section updated successfully!');

    }

    public function destroy($id)
    {
        $section = DisplaySection::findOrFail($id);

        $section->products->each->delete();
        $section->delete();
        Cache::forget('display_sections');

        return to_route('settings.home.section.index')->with('success', 'Section deleted successfully!');

    }
}
