<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoriesMenuController extends Controller
{
    public function index()
    {
        $menus = CategoryMenu::with('parent')->latest()->paginate();
        return view('backend.categories.menu.index', compact('menus'));
    }

    public function create()
    {
        $menus = CategoryMenu::select('id', 'name')->get();
        return view('backend.categories.menu.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|exists:category_menus,id',
            'url' => 'required',
            'target' => 'required'
        ]);


        $menu = new CategoryMenu();
        $menu->name = $request->name;
        $menu->parent_id = $request->parent_id;
        $menu->url = $request->url;
        $menu->target = $request->target;
        $menu->icon = $request->icon;
        $menu->save();

        Cache::forget('categories-menu');

        return to_route('categories.menus.index')->with('success', 'Menu added successfully!');
    }

    public function edit($id)
    {
        $menu = CategoryMenu::findOrFail($id);
        $menus = CategoryMenu::select('id', 'name')->get();

        return view('backend.categories.menu.edit', compact('menus', 'menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|exists:category_menus,id',
            'url' => 'required',
            'target' => 'required'
        ]);

        $menu = CategoryMenu::findOrFail($id);
        $menu->name = $request->name;
        $menu->parent_id = $request->parent_id;
        $menu->url = $request->url;
        $menu->icon = $request->icon;
        $menu->target = $request->target;
        $menu->save();

        Cache::forget('categories-menu');

        return to_route('categories.menus.index')->with('success', 'Menu updated successfully!');
    }

    public function destroy($id)
    {
        CategoryMenu::find($id)->delete();
        CategoryMenu::where('parent_id', $id)->delete();
        Cache::forget('categories-menu');
        return back()->with('success', 'Menu deleted successfully!');
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
