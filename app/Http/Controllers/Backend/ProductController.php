<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\ProductReview;
use App\Models\ProductStock;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories.category', 'brand')
                            ->when(request('search'), function ($query) {
                                $query->where('name', 'LIKE', '%'.request('search').'%');
                            })
                            ->latest()
                            ->paginate(30);

        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::withCount('products')->latest()->get();
        $brands = Brand::all();
        $attributes = Attribute::all();
        $colors = Color::all();

        return view('backend.products.create', compact('categories', 'colors', 'attributes', 'brands'));
    }

    public function get(Request $request)
    {
        $products = Product::publish()->whereHas('categories', function ($query) use ($request) {
            $query->whereIn('category_id', $request->categories);
        })->select('id', 'name')->get();

        return view('backend.products.inc.product_get', compact('products'))->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        try {

            DB::beginTransaction();

            $product = new Product();
            $product->name = $request->name;
            // $product->added_by = $request->added_by;
            $product->user_id = User::where('user_type', 'admin')->first()->id;

            $category_ids = [];

            foreach ($request->categories_id as $category) {
                array_push($category_ids, [
                    'id' => $category,
                ]);
            }

            $product->category_ids = json_encode($category_ids);
            $product->brand_id = $request->brand_id;
            $product->barcode = $request->barcode;
            $product->weight = $request->weight;

            $photos = [];
            foreach (explode(',', $request->galleries) as $photo) {
                array_push($photos, [
                    'id' => $photo,
                ]);
            }

            $product->photos = json_encode($photos);

            $product->thumbnail_img = $request->thumbnail;
            $product->unit = $request->unit;

            $product->tags = $request->tags;
            $product->alt = $request->alt;
            $product->galleries_alt = $request->galleries_alt;

            $product->description = $request->description;
            $product->product_video = $request->product_video;
            $product->short_description = $request->short_description;
            $product->support_description = $request->support_description;
            $product->unit_price = $request->unit_price;
            $product->discount = $request->discount_price;
            $product->discount_type = 'amount';

            // if ($request->date_range != null) {
            //     $date_var               = explode(" to ", $request->date_range);
            //     $product->discount_start_date = strtotime($date_var[0]);
            //     $product->discount_end_date   = strtotime($date_var[1]);
            // }
            
            $product->features = json_encode($request->features);
            $product->shipping_type = json_encode($request->shipping_type);
            $product->est_shipping_days = $request->estimate_delivery_days;

            $product->shipping_cost = $request->shipping_type == 'flat_rate' ? $request->shipping_cost : 0;

            $product->current_stock = $request->quantity;

            $product->meta_title = $request->meta_title != null ? $request->meta_title : $product->name;
            $product->meta_img = $request->meta_img != null ? $request->meta_img : $product->thumbnail_img;
            $product->meta_description = $request->meta_description != null ? $request->meta_description : strip_tags($product->description);

            $slug = $request->slug ? Str::slug($request->slug, '-') : Str::slug($request->name, '-');
            $same_slug_count = Product::where('slug', 'LIKE', $slug.'%')->count();
            $slug_suffix = $same_slug_count ? '-'.$same_slug_count + 1 : '';
            $slug .= $slug_suffix;

            $product->slug = $slug;

            $attributes_list = [];

            foreach($request->get('attributes') ?? [] as $attribute_id){
                $key = "attributes_values_".$attribute_id;
                $attributes_list[$attribute_id] = $request->get($key);
            }

            $product->attributes = json_encode($attributes_list);

            $product->choice_options = json_encode([]);

            $product->status = $request->button == 'unpublish' ? 'unpublish' : ($request->button == 'draft' ? 'unpublish' : 'publish');

            //VAT & Tax
            $product->vat = $request->vat;
            $product->tax = $request->tax;
            $product->vat_type = $request->vat_type;
            $product->tax_type = $request->tax_type;

            //combinations start
            $options = [];

            if ($request->has('choice_no')) {
                foreach ($request->choice_no as $key => $no) {
                    $name = 'attributes_values_'.$no;
                    $data = [];
                    foreach ($request[$name] as $key => $eachValue) {
                        array_push($data, $eachValue);
                    }
                    array_push($options, $data);
                }
            }

            $product->save();

            $categories = [];
            foreach ($request->categories_id as $id) {
                array_push($categories, [
                    'product_id' => $product->id,
                    'category_id' => $id,
                ]);
            }

            ProductCategories::insert($categories);

            //Generates the combinations of customer choice options
            // $combinations = $this->makeCombinations($options);
            // if (count($combinations[0]) > 0) {
            //     $product->variant_product = 1;
            //     foreach ($combinations as $key => $combination) {
            //         $str = '';
            //         foreach ($combination as $key => $item) {
            //             if ($key > 0) {
            //                 $str .= '-'.str_replace(' ', '', $item);
            //             } else {
            //                 if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            //                     $color_name = Color::where('code', $item)->first()->name;
            //                     $str .= $color_name;
            //                 } else {
            //                     $str .= str_replace(' ', '', $item);
            //                 }
            //             }
            //         }
            //         $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
            //         if ($product_stock == null) {
            //             $product_stock = new ProductStock;
            //             $product_stock->product_id = $product->id;
            //         }

            //         $product_stock->variant = $str;
            //         $product_stock->price = $request['price_'.str_replace('.', '_', $str)];
            //         $product_stock->sku = $request['sku_'.str_replace('.', '_', $str)];
            //         $product_stock->qty = $request['qty_'.str_replace('.', '_', $str)];
            //         $product_stock->image = $request['img_'.str_replace('.', '_', $str)];
            //         $product_stock->save();
            //     }
            // } else {
            //     $product_stock = new ProductStock;
            //     $product_stock->product_id = $product->id;
            //     $product_stock->variant = '';
            //     $product_stock->price = $request->unit_price;
            //     $product_stock->sku = $request->sku;
            //     $product_stock->qty = $request->quantity;
            //     $product_stock->save();
            // }
            //combinations end

            $product->save();

            DB::commit();

            return to_route('products.index')->with('success', 'Product has been added successfully!');

        } catch (\Throwable $th) {
            throw $th;
            return to_route('products.index')->with('error', 'Sorry, something went wrong!');
        }

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
        $product = Product::findOrFail($id);
        // dd(json_decode($product->choice_options,true));

        $categories = Category::withCount('products')->latest()->get();
        $brands = Brand::all();
        $attributes = Attribute::all();
        $colors = Color::all();

        return view('backend.products.edit', compact('product', 'categories', 'attributes', 'colors', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     
     */
  
    public function update(Request $request, string $id)
    {
        $request->validate([
            'slug' => 'required|unique:products,slug,'.$id
        ]);

        try {

            DB::beginTransaction();

            $product = Product::findOrFail($id);
            $product->name = $request->name;
            // $product->added_by = $request->added_by;
            $product->user_id = User::where('user_type', 'admin')->first()->id;

            $category_ids = [];

            foreach ($request->categories_id ?? [] as $category) {
                array_push($category_ids, [
                    'id' => $category,
                ]);
            }

            $product->category_ids = json_encode($category_ids);
            $product->brand_id = $request->brand_id;
            $product->barcode = $request->barcode;
            $product->weight = $request->weight;

            $photos = [];
            foreach (explode(',', $request->galleries) as $photo) {
                array_push($photos, [
                    'id' => $photo,
                ]);
            }

            $product->photos = json_encode($photos);

            $product->thumbnail_img = $request->thumbnail;
            $product->unit = $request->unit;

            $product->tags = $request->tags;
            $product->alt = $request->alt;
            $product->galleries_alt = $request->galleries_alt;

            $product->current_stock = $request->quantity;
            $product->description = $request->description;
            $product->product_video = $request->product_video;
            $product->short_description = $request->short_description;
            $product->support_description = $request->support_description;
            $product->unit_price = $request->unit_price;
            $product->discount = $request->discount_price;
            $product->discount_type = 'amount';

            // if ($request->date_range != null) {
            //     $date_var               = explode(" to ", $request->date_range);
            //     $product->discount_start_date = strtotime($date_var[0]);
            //     $product->discount_end_date   = strtotime($date_var[1]);
            // }

            $product->features = json_encode($request->features);
            $product->shipping_type = json_encode($request->shipping_type);
            $product->est_shipping_days = $request->estimate_delivery_days;

            $product->shipping_cost = $request->shipping_type == 'flat_rate' ? $request->shipping_cost : 0;

            $product->meta_title = $request->meta_title != null ? $request->meta_title : $product->name;
            $product->meta_img = $request->meta_img != null ? $request->meta_img : $product->thumbnail_img;
            $product->meta_description = $request->meta_description != null ? $request->meta_description : strip_tags($product->description);

            $slug = $request->slug ? Str::slug($request->slug, '-') : Str::slug($request->name, '-');
            $same_slug_count = Product::where('id', '!=', $id)->where('slug', 'LIKE', $slug.'%')->count();
            $slug_suffix = $same_slug_count ? '-'.$same_slug_count + 1 : '';
            $slug .= $slug_suffix;

            $product->slug = $slug;

            $attributes_list = [];

            foreach($request->get('attributes') ?? [] as $attribute_id){
                $key = "attributes_values_".$attribute_id;
                $attributes_list[$attribute_id] = $request->get($key);
            }

            $product->attributes = $attributes_list;

            $product->save();

            $product->status = $request->button == 'unpublish' ? 'unpublish' : ($request->button == 'draft' ? 'unpublish' : 'publish');

            //VAT & Tax
            $product->vat = $request->vat;
            $product->tax = $request->tax;
            $product->vat_type = $request->vat_type;
            $product->tax_type = $request->tax_type;

            //combinations start
            $options = [];

            if ($request->has('choice_no')) {
                foreach ($request->choice_no as $key => $no) {
                    $name = 'attributes_values_'.$no;
                    $data = [];
                    foreach ($request[$name] as $key => $eachValue) {
                        array_push($data, $eachValue);
                    }
                    array_push($options, $data);
                }
            }

            $product->save();

            $categories = [];
            foreach ($request->categories_id as $id) {
                array_push($categories, [
                    'product_id' => $product->id,
                    'category_id' => $id,
                ]);
            }

            // Delete old categories and insert new categories
            ProductCategories::where('product_id', $product->id)->delete();
            ProductCategories::insert($categories);

            // Delete old stock data
            ProductStock::where('product_id', $product->id)->delete();

            //Generates the combinations of customer choice options
            // $combinations = $this->makeCombinations($options);
            // if (count($combinations[0]) > 0) {
            //     $product->variant_product = 1;
            //     foreach ($combinations as $key => $combination) {
            //         $str = '';
            //         foreach ($combination as $key => $item) {
            //             if ($key > 0) {
            //                 $str .= '-'.str_replace(' ', '', $item);
            //             } else {
            //                 if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            //                     $color_name = Color::where('code', $item)->first()->name;
            //                     $str .= $color_name;
            //                 } else {
            //                     $str .= str_replace(' ', '', $item);
            //                 }
            //             }
            //         }
            //         $product_stock = ProductStock::where('product_id', $product->id)->where('variant', $str)->first();
            //         if ($product_stock == null) {
            //             $product_stock = new ProductStock;
            //             $product_stock->product_id = $product->id;
            //         }

            //         $product_stock->variant = $str;
            //         $product_stock->price = $request['price_'.str_replace('.', '_', $str)];
            //         $product_stock->sku = $request['sku_'.str_replace('.', '_', $str)];
            //         $product_stock->qty = $request['qty_'.str_replace('.', '_', $str)];
            //         $product_stock->image = $request['img_'.str_replace('.', '_', $str)];
            //         $product_stock->save();
            //     }
            // } else {
            //     $product_stock = new ProductStock;
            //     $product_stock->product_id = $product->id;
            //     $product_stock->variant = '';
            //     $product_stock->price = $request->unit_price;
            //     $product_stock->sku = $request->sku;
            //     $product_stock->qty = $request->quantity;
            //     $product_stock->save();
            // }
            //combinations end

            $product->save();

            DB::commit();
            Log::info('Request quantity: ' . $request->quantity);

            Artisan::call('cache:clear');

            return to_route('products.index')->with('success', 'Product has been updated successfully!');

        } catch (\Throwable $th) {
            return to_route('products.index')->with('error', 'Sorry, something went wrong!');
        }
    } 
  
//  /* 
//   public function update(Request $request, string $id)
// {
//     $request->validate([
//         'slug' => 'required|unique:products,slug,'.$id
//     ]);

//     try {
//         DB::beginTransaction();

//         $product = Product::findOrFail($id);
//         $product->name = $request->name;
//         $product->user_id = User::where('user_type', 'admin')->first()->id;

//         $categoryIds = $request->categories_id;

//         $product->category_ids = json_encode($categoryIds);
//         $product->brand_id = $request->brand_id;
//         $product->barcode = $request->barcode;
//         $product->weight = $request->weight;

//         $photos = [];
//         foreach (explode(',', $request->galleries) as $photo) {
//             array_push($photos, ['id' => $photo]);
//         }

//         $product->photos = json_encode($photos);

//         $product->thumbnail_img = $request->thumbnail;
//         $product->unit = $request->unit;

//         $product->tags = $request->tags;
//         $product->alt = $request->alt;
//         $product->galleries_alt = $request->galleries_alt;

//         $product->current_stock = $request->quantity;
//         $product->description = $request->description;
//         $product->short_description = $request->short_description;
//         $product->unit_price = $request->unit_price;
//         $product->discount = $request->discount_price;
//         $product->discount_type = 'amount';

//         $product->shipping_type = $request->shipping_type;
//         $product->est_shipping_days = $request->estimate_delivery_days;

//         $product->shipping_cost = $request->shipping_type == 'flat_rate' ? $request->shipping_cost : 0;

//         $product->meta_title = $request->meta_title ?? $product->name;
//         $product->meta_img = $request->meta_img ?? $product->thumbnail_img;
//         $product->meta_description = $request->meta_description ?? strip_tags($product->description);

//         $slug = $request->slug ? Str::slug($request->slug, '-') : Str::slug($request->name, '-');
//         $sameSlugCount = Product::where('id', '!=', $id)->where('slug', 'LIKE', $slug.'%')->count();
//         $slugSuffix = $sameSlugCount ? '-'.$sameSlugCount + 1 : '';
//         $slug .= $slugSuffix;

//         $product->slug = $slug;

//         $product->save();

//         $choiceOptions = [];

//         if ($request->has('choice_no')) {
//             foreach ($request->choice_no as $no) {
//                 $attributeValues = $request->input('attributes_values_'.$no, []);
//                 $item['attribute_id'] = $no;
//                 $item['values'] = $attributeValues;
//                 array_push($choiceOptions, $item);
//             }
//         }

//         $product->attributes = json_encode($request->choice_no ?? []);
//         $product->choice_options = json_encode($choiceOptions);

//         $product->status = $request->button == 'unpublish' ? 'unpublish' : ($request->button == 'draft' ? 'unpublish' : 'publish');

//         //VAT & Tax
//         $product->vat = $request->vat;
//         $product->tax = $request->tax;
//         $product->vat_type = $request->vat_type;
//         $product->tax_type = $request->tax_type;

//         // Delete old categories and insert new categories
//         $product->categories()->sync($categoryIds);

//         // Delete old stock data and insert new stock data
//         $product->stocks()->delete();

//         //Generates the combinations of customer choice options
//         // Your makeCombinations function is assumed to be defined and working correctly
//         $combinations = $this->makeCombinations($request->only('choice_no'));
//         foreach ($combinations as $combination) {
//             $product->stocks()->create([
//                 'variant' => $combination['variant'],
//                 'price' => $combination['price'],
//                 'sku' => $combination['sku'],
//                 'qty' => $combination['qty'],
//                 'image' => $combination['image']
//             ]);
//         }

//         DB::commit();

//         Log::info('Product updated successfully: ' . $product->id);

//         Artisan::call('cache:clear');

//         return redirect()->route('products.index')->with('success', 'Product has been updated successfully!');

//     } catch (\Throwable $th) {
//         DB::rollBack();
//         Log::error('Error updating product: ' . $th->getMessage());
//         return redirect()->route('products.index')->with('error', 'Sorry, something went wrong!');
//     }
// }
  
  
//   */
  
  
  
  
  
  
  
  
  
  
  

//     /**
//      * Remove the specified resource from storage.
//      */
    public function destroy(string $id)
    {

        $product = Product::findOrFail($id);

        try {

            foreach ($product->stocks as $stock) {
                $stock->delete();
            }

            ProductCategories::where('product_id', $id)->delete();
            ProductReview::where('product_id', $id)->delete();
            Cart::where('product_id', $id)->delete();
            Wishlist::where('product_id', $id)->delete();

            $product->delete();

            Artisan::call('cache:clear');

            return back()->with('success', 'Product deleted successfully!');

        } catch (\Throwable $th) {
            return back()->with('error', 'Sorry, something went wrong!');
        }
    }

    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        $product->save();

        return 1;
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = $request->status == 1 ? 'publish' : 'unpublish';
        $product->save();

        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if ($product->save()) {
            return 1;
        }

        return 0;
    }

    public function addChoiceOption(Request $request)
    {

        $attribute_values = AttributeValue::with('attribute')->where('attribute_id', $request->attribute_id)->get()->unique('value');
        // dd($attribute_values);

        $attributes = $request->attributes;

        return response([
            'view' => view('backend.products.inc.add_more_option', compact('attribute_values'))->render(),
        ]);
    }

    public function skuCombination(Request $request)
    {

        $options = [];

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'attributes_values_'.$no;
                $data = [];

                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = $this->makeCombinations($options);

        return response([
            'view' => view('backend.products.inc.sku_combinations', compact('combinations', 'unit_price', 'product_name'))->render(),
        ]);
    }

    public function editSkuCombination(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $options = [];

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'attributes_values_'.$no;
                $data = [];

                foreach ($request[$name] as $key => $item) {
                    array_push($data, $item);
                }
                array_push($options, $data);
            }
        }

        $combinations = $this->makeCombinations($options);

        return response([
            'view' => view('backend.products.inc.edit_sku_combinations', compact('combinations', 'product', 'unit_price', 'product_name'))->render(),
        ]);
    }

    private static function makeCombinations($arrays)
    {
        $result = [[]];
        foreach ($arrays as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $tmp;
        }

        return $result;
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
