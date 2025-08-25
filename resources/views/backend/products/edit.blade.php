@extends('backend.layouts.app')

@section('title')
Edit Product
@endsection
@push('js')
    <script>
        $(document).ready(function(){

            function addChoiceOption(i, name){
                $.ajax({
                    type:"POST",
                    url: "{{ route('products.add.choice.option') }}",
                    data:{
                        attribute_id: i,
                        mode : 'edit',
                        attributes : {{ Js::from($product->attributes) }}
                    },
                    success: function(response) {
                        $('#addChoiceOption').append(response.view);
                        new Choices('#attributes_values_'+i,{
                            removeItems: true,
                            removeItemButton: true
                        });
                }});
            }

            $('#attributes_id').on('change', function() {
                $('#addChoiceOption').html(null);

                $.each($("#attributes_id option:selected"), function(){
                    addChoiceOption($(this).val(), $(this).text());
                });

                // updateSku();
            });

            // updateSku();
            // function updateSku(){
            //     $.ajax({
            //         type:"POST",
            //         url:'{{ route('products.edit.sku.combination') }}',
            //         data:$('form').serialize(),
            //         success: function(data) {
            //             $('#skuCombination').html(data.view);
            //             uploader.previewGenerate();
            //             if (data.view.length > 1) {
            //                 $('#show-hide-div').hide();
            //             }
            //             else {
            //                 $('#show-hide-div').show();
            //             }
            //         }
            //     });
            // }

            // $(document).on("change", ".attribute_choice",function() {
            //     updateSku();
            // });

            // $('input[name="unit_price"]').on('keyup', function() {
            //     updateSku();
            // });

            // $('input[name="name"]').on('keyup', function() {
            //     updateSku();
            // });

            function delete_row(em){
                $(em).closest('.form-group row').remove();
                // updateSku();
            }

            function delete_variant(em){
                $(em).closest('.variant').remove();
            }
        })
    </script>
@endpush
@section('content')
<div class="container-fluid">
    <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $product->id }}">
        <div class="card mt-4">

            <div class="card-header border-bottom">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Product Name</label>
                        <div class="input-group">
                            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                type="text" placeholder="Product Name" autocomplete="off" value="{{ $product->name }}" required>
                        </div>
                        @error('name')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6 @error('brand_id') border-danger @enderror">
                        <div class="input-area">
                            <label class="form-label">Brand</label>
                            <x-select name="brand_id">
                                <option value="" selected disabled>Select Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected($brand->id == $product->brand_id)>{{ $brand->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        @error('brand_id')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 m-2">
                        <label class="form-label">Slug</label>
                        <div class="input-group">
                            <input id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                type="text" placeholder="Product slug" autocomplete="off" value="{{ old('slug',$product->slug) }}">
                        </div>
                        @error('slug')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-8 @error('parent_category_id') border-danger @enderror">
                        <div class="input-area">
                            <label class="form-label">Categories</label>
                            <x-select name="categories_id[]" multiple>
                                <option value="" disabled>Select Categories</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(in_array($category->id,$product->categories->pluck('category_id')->toArray()))>{{ $category->name }}
                                    - {{ $category->products_count }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        @error('categories_id')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <div class="col-4">
                        <label class="form-label">Weight</label>
                        <div class="input-group">
                            <input id="weight" name="weight" class="form-control @error('weight') is-invalid @enderror"
                                type="number" placeholder="Weight" value="{{ $product->weight }}">
                        </div>
                        @error('weight')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <label class="form-label">Unit</label>
                        <div class="input-group">
                            <input id="unit" name="unit" class="form-control @error('unit') is-invalid @enderror"
                                type="text" placeholder="Unit (e.g. KG, Pc etc)" value="{{ $product->unit }}">
                        </div>
                        @error('unit')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <label class="form-label">Tags <small class="text-muted">( For product serach )</small></label>
                        <div class="input-group">
                            <x-tags name="tags" placeholder="Write tag" value="{{ $product->tags }}"></x-tags>
                        </div>
                        @error('tags')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <label class="form-label">Barcode</label>
                        <div class="input-group">
                            <input id="barcode" name="barcode" class="form-control @error('barcode') is-invalid @enderror"
                                type="text" placeholder="Barcode" value="{{ $product->barcode }}">
                        </div>
                        @error('barcode')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    {{-- <div class="text-center mt-2">
                        <button class="btn btn-success">Add Category</button>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header border-bottom">
                <h6 class="mb-0">Product Description</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="input-area @error('short_description') border-danger @enderror">
                            <label class="form-label">Short Description</label>
                            <x-textarea name='short_description' placeholder="Write short description" value="{{ $product->short_description }}" required/>
                        </div>
                        @error('short_description')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="input-area @error('description') border-danger @enderror">
                            <label class="form-label">Specification</label>
                            <x-textarea name='description' placeholder="Write description" value="{{ $product->description }}"/>
                        </div>
                        @error('description')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
           
                    <div class="col-6">
                        <div class="input-area @error('support_description') border-danger @enderror">
                            <label class="form-label">Description</label>
                            <x-textarea name='support_description' placeholder="Write support description" value="{{ $product->support_description }}" required/>
                        </div>
                        @error('support_description')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                     
                     <div class="col-6">
                        <div class="input-area @error('product_video') border-danger @enderror">
                            <label class="form-label">Product Video Youtube Link</label>
                            <x-textarea name='product_video' placeholder="Product Video Youtube Link" value="{{ $product->product_video }}"/>
                        </div>
                        @error('product_video')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header border-bottom">
                <h6 class="mb-0">Product Images</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Thumbnail</label>
                        <x-upload-file name="thumbnail" fileType='image' value="{{ $product->thumbnail_img }}"/>
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Galleries</label>
                        <x-upload-file name="galleries" fileType='image' multiple value="{{ collect(json_decode($product->photos))->pluck('id')->implode(',') }}"/>
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Thumbnail Alt</label>
                        <input type="text" class="form-control" name="alt" placeholder="ALT For Product Thumbnail" value="{{ $product->alt }}">
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Galleries Alt <small class="text-danger">(Separate by comma.)</small></label>
                        <input type="text" class="form-control" name="galleries_alt" placeholder="ALT For Product Galleries" value="{{ $product->galleries_alt }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header border-bottom">
                <h6 class="mb-0">Product Shipping</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1 text-center">
                        {{-- <label class="form-label">Refundable</label> <br>
                        <label class="switch">
                            <input type="checkbox" name="refundable">
                            <span class="slider round"></span>
                        </label> --}}
                    </div>
                    <div class="col-3">
                        <label class="form-label">Estimate Shipping Days</label>
                        <div class="input-group">
                            <input id="estimate_delivery_days" min="1" name="estimate_delivery_days" class="form-control @error('estimate_delivery_days') is-invalid @enderror"
                                type="number" placeholder="Estimate Shipping Days" value="{{ $product->est_shipping_days }}">
                        </div>
                        @error('estimate_delivery_days')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @php
                $shipping = json_decode($product->shipping_type);
                @endphp
                    <div class="col-3" id="shippingCost">
                        <label class="form-label">Inside Dhaka Shipping Cost</label>
                        <div class="input-group">
                            <input name="shipping_type[inside_dhaka]" class="form-control"
                                type="number" value="{{ data_get($shipping,'inside_dhaka') }}" placeholder="Shipping Cost">
                        </div>
                    </div>
                    <div class="col-3" id="shippingCost">
                        <label class="form-label">Outside Dhaka Shipping Cost</label>
                        <div class="input-group">
                            <input name="shipping_type[outside_dhaka]" class="form-control"
                                type="number" value="{{ data_get($shipping,'outside_dhaka') }}" placeholder="Shipping Cost">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header border-bottom">
                <h6 class="mb-0">Product Features</h6>
            </div>
            <div class="card-body">
                @php
                    $features = json_decode($product->features);
                @endphp
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Feature One</label>
                        <div class="input-group">
                            <input name="features[0]" class="form-control"
                                type="text" value="{{ data_get($features,'0') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Feature Two</label>
                        <div class="input-group">
                            <input name="features[1]" class="form-control"
                                type="text" value="{{ data_get($features,'1') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Feature Three</label>
                        <div class="input-group">
                            <input name="features[2]" class="form-control"
                                type="text" value="{{ data_get($features,'2') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Feature Four</label>
                        <div class="input-group">
                            <input name="features[3]" class="form-control"
                                type="text" value="{{ data_get($features,'3') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header border-bottom">
                <h6 class="mb-0">Product Variation</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- <div class="col-12 @error('colors') border-danger @enderror">
                        <div class="input-area">
                            <label class="form-label">Colors</label> <br>
                            <x-select name="colors[]" multiple>
                                @foreach ($colors as $color)
                                <option value="{{ $color->code }}">{{ $color->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        @error('colors')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div> --}}
                    <div class="col-12 @error('attributes_id') border-danger @enderror">
                        <div class="input-area">
                            <label class="form-label">Attributes</label>
                            <x-select name="attributes_id[]" id="attributes_id" multiple>
                                <option value="" disabled>Select Attribute</option>
                                @foreach ($attributes as $attribute)
                                <option value="{{ $attribute->id }}" @selected(is_array($product->attributes) && in_array($attribute->id,$product->attributes))>{{ $attribute->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        @error('attributes_id')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div id="addChoiceOption" class="row mt-3">
                        @if(is_array($product->attributes))
                        @foreach ($product->attributes ?? [] as $attribute_id => $choice)
                        @php
                            $attribute = App\Models\Attribute::find($attribute_id);
                            $attribute_values = \App\Models\AttributeValue::where('attribute_id', $attribute_id)->get()->unique('value');
                        @endphp
                        <div class="col-md-4 mb-2">
                            <input type="hidden" name="attributes[{{ $attribute?->id }}]" value="{{ $attribute_id }}">
                            <input type="text" value="{{ $attribute?->name }}" class="form-control" disabled>
                        </div>
                        <div class="col-md-8 mb-2">
                            <x-select name="attributes_values_{{ $attribute_id }}[]" class="attribute_choice" id="attributes_values_{{ data_get($attribute_values,'0.attribute.id') }}" multiple>
                                @foreach ($attribute_values as $row)
                                    <option value="{{ $row->value }}" @selected(in_array($row->value, $choice))>{{ $row->value }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header border-bottom">
                <h6 class="mb-0">Product Stock & Price</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Regular Price</label>
                        <div class="input-group">
                            <input id="unit_price" name="unit_price" class="form-control @error('unit_price') is-invalid @enderror"
                                type="number" placeholder="Regular Price" value="{{ $product->unit_price }}">
                        </div>
                        @error('unit_price')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Discount Price</label>
                        <div class="input-group">
                            <input id="discount_price" name="discount_price" class="form-control @error('discount_price') is-invalid @enderror"
                                type="number" placeholder="Discount Price" value="{{ $product->discount }}">
                            {{-- <select class="form-select" name="discount_type">
                                <option value="flat">Flat</option>
                                <option value="percent">Percent</option>
                            </select> --}}
                        </div>
                        @error('discount_price')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div id="show-hide-div" class="row">
                        <div class="col-6">
                            <label class="form-label">Quantity</label>
                            <div class="input-group">
                                <input id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                    type="number" placeholder="Quantity" value="{{ $product->stocks->first()?->qty ?? $product->current_stock }}">
                            </div>
                            @error('quantity')
                            <div class="text text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">SKU</label>
                            <div class="input-group">
                                <input id="sku" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                    type="text" placeholder="SKU" value="{{ $product->sku }}">
                            </div>
                            @error('sku')
                            <div class="text text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div id="skuCombination" class="mt-2"></div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header border-bottom">
                <h6 class="mb-0">Product VAT & TAX</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">VAT</label>
                        <div class="input-group">
                            <input id="vat" name="vat" class="form-control @error('vat') is-invalid @enderror"
                                type="number" placeholder="VAT" value="{{ $product->vat }}">
                            <select name="vat_type" class="form-select">
                                <option value="flat" @selected($product->vat_type == 'flat')>Flat</option>
                                <option value="percent" @selected($product->vat_type == 'percent')>Percent</option>
                            </select>
                        </div>
                        @error('vat')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">TAX</label>
                        <div class="input-group">
                            <input id="tax" name="tax" class="form-control @error('tax') is-invalid @enderror"
                                type="number" placeholder="tax" value="{{ $product->tax }}">
                            <select name="tax_type" class="form-select">
                                <option value="flat" @selected($product->tax_type == 'flat')>Flat</option>
                                <option value="percent" @selected($product->tax_type == 'percent')>Percent</option>
                            </select>
                        </div>
                        @error('tax')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header border-bottom">
                <h6 class="mb-0">Product SEO</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <div class="input-group">
                            <input id="meta_title" name="meta_title"
                                class="form-control @error('meta_title') is-invalid @enderror" type="text"
                                placeholder="Meta Title" value="{{ $product->meta_title }}"  autocomplete="off">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <x-textarea name='meta_description' placeholder='Write meta description' value="{{ $product->meta_description }}"/>
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Meta Image</label>
                        <x-upload-file name="meta_image" fileType='image' value="{{ $product->meta_img }}"/>
                    </div>

                    <div class="col-12">
                        <div class="btn-toolbar float-right mb-3">
                            <div class="btn-group mr-2">
                                <button type="submit" name="button" value="draft" class="btn btn-secondary">Update as Draft</button>
                            </div>
                            <div class="btn-group">
                                <button type="submit" name="button" value="publish" class="btn btn-success">Update as Publish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection
