<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::latest()->paginate();

        return view('backend.attribute.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:attributes,name',
        ]);

        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->save();

        return to_route('attribute.index')->with('success', 'Attribute added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attribute = Attribute::findOrFail($id);

        return view('backend.attribute.show', compact('attribute'));
    }

    public function valueStore(Request $request)
    {
        $request->validate([
            'value' => 'required|unique:attribute_values',
        ]);

        $attribute = new AttributeValue();
        $attribute->attribute_id = $request->attribute_id;
        $attribute->value = $request->value;
        $attribute->save();

        return back()->with('success', 'Attribute value added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attribute = Attribute::findOrFail($id);

        return view('backend.attribute.edit', compact('attribute'));
    }

    public function valueEdit($id)
    {
        $value = AttributeValue::findOrFail($id);

        return view('backend.attribute.value.edit', compact('value'));
    }

    public function valueUpdate(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|unique:attribute_values,value,'.$id,
        ]);

        $attribute = AttributeValue::findOrFail($id);
        $attribute->value = $request->value;
        $attribute->save();

        return to_route('attribute.show', $attribute->attribute_id)->with('success', 'Attribute value added successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:attributes,name,'.$id,
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->name = $request->name;
        $attribute->save();

        return to_route('attribute.index')->with('success', 'Attribute updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attribute = Attribute::findOrFail($id);

        $attribute->values->each->delete();

        $attribute->delete();

        return to_route('attribute.index')->with('success', 'Attribute deleted successfully!');

    }

    public function valueDelete($id)
    {
        $attribute = AttributeValue::findOrFail($id);

        $attribute->delete();

        return back()->with('success', 'Attribute value deleted!');
    }
}
