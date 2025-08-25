@extends('backend.layouts.app')

@section('title')
Add Product
@endsection
@push('js')
    <script>
        $("[name=shipping_type]").on("change", function (){
            $("#shippingCost").hide();

            if($(this).val() == 'flat_rate'){
                $("#shippingCost").show();
            }
        });

        function addChoiceOption(i, name){
            $.ajax({
                type:"POST",
                url: "{{ route('products.add.choice.option') }}",
                data:{
                    attribute_id: i
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

        // function updateSku(){
        //     $.ajax({
        //         type:"POST",
        //         url:'{{ route('products.sku.combination') }}',
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

    // function delete_row(em){
    //     $(em).closest('.form-group row').remove();
    //     updateSku();
    // }

    // function delete_variant(em){
    //     $(em).closest('.variant').remove();
    // }

    </script>
@endpush
@section('content')
<div class="container-fluid">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
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
                                type="text" placeholder="Product Name" autocomplete="off" value="{{ old('name') }}" required>
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
                                <option value="{{ $brand->id }}" @selected($brand->id == old('brand_id'))>{{ $brand->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        @error('brand_id')
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
                                <option value="{{ $category->id }}" @selected($category->id == old('categories_id'))>{{ $category->name }}
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
                                type="number" placeholder="Weight" value="{{ old('weight') }}">
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
                                type="text" placeholder="Unit (e.g. KG, Pc etc)" value="{{ old('unit') }}">
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
                            <x-tags name="tags" placeholder="Write tag"></x-tags>
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
                                type="text" placeholder="Barcode" value="{{ old('barcode') }}">
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
                            <x-textarea name='short_description' placeholder="Write short description" value="{{ old('short_description') }}" required/>
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
                            <x-textarea name='description' placeholder="Write description" value="{{ old('description') }}" required/>
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
                            <x-textarea name='support_description' placeholder="Write support description" value="{{ old('support_description') }}" required/>
                        </div>
                        @error('support_description')
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
                        <x-upload-file name="thumbnail" fileType='image' value="{{ old('thumbnail') }}"/>
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Galleries</label>
                        <x-upload-file name="galleries" fileType='image' multiple value="{{ old('galleries') }}"/>
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Thumbnail Alt</label>
                        <input type="text" class="form-control" name="alt" placeholder="ALT For Product Thumbnail">
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Galleries Alt <small class="text-danger">(Separate by comma.)</small></label>
                        <input type="text" class="form-control" name="galleries_alt" placeholder="ALT For Product Galleries">
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
                                type="number" placeholder="Estimate Shipping Days" value="{{ old('estimate_delivery_days') }}">
                        </div>
                        @error('estimate_delivery_days')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-3" id="shippingCost">
                        <label class="form-label">Inside Dhaka Shipping Cost</label>
                        <div class="input-group">
                            <input name="shipping_type[inside_dhaka]" class="form-control"
                                type="number" placeholder="Shipping Cost">
                        </div>
                    </div>
                    <div class="col-3" id="shippingCost">
                        <label class="form-label">Outside Dhaka Shipping Cost</label>
                        <div class="input-group">
                            <input name="shipping_type[outside_dhaka]" class="form-control"
                                type="number" placeholder="Shipping Cost">
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
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Feature One</label>
                        <div class="input-group">
                            <input name="features[0]" class="form-control"
                                type="text">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Feature Two</label>
                        <div class="input-group">
                            <input name="features[1]" class="form-control"
                                type="text">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Feature Three</label>
                        <div class="input-group">
                            <input name="features[2]" class="form-control"
                                type="text">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Feature Four</label>
                        <div class="input-group">
                            <input name="features[3]" class="form-control"
                                type="text">
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
                                <option value="{{ $attribute->id }}" @selected($attribute->id == old('attributes_id'))>{{ $attribute->name }}</option>
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
                                type="number" placeholder="Regular Price" value="{{ old('unit_price',0) }}">
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
                                type="number" placeholder="Discount Price" value="{{ old('discount_price') }}">
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
                                    type="number" placeholder="Quantity" value="{{ old('quantity',0) }}">
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
                                    type="text" placeholder="SKU" value="{{ old('sku') }}">
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
                                type="number" placeholder="VAT" value="{{ old('vat') }}">
                            <select name="vat_type" class="form-select">
                                <option value="flat">Flat</option>
                                <option value="percent">Percent</option>
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
                                type="number" placeholder="tax" value="{{ old('tax') }}">
                            <select name="tax_type" class="form-select">
                                <option value="flat">Flat</option>
                                <option value="percent">Percent</option>
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
                                placeholder="Meta Title" value="{{ old('meta_title') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <x-textarea name='meta_description' placeholder='Write meta description' value="{{ old('meta_description') }}"/>
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Meta Image</label>
                        <x-upload-file name="meta_image" fileType='image' value="{{ old('meta_image') }}"/>
                    </div>

                    <div class="col-12">
                        <div class="btn-toolbar float-right mb-3">
                            <div class="btn-group mr-2">
                                <button type="submit" name="button" value="draft" class="btn btn-secondary">Save as Draft</button>
                            </div>
                            <div class="btn-group mr-2">
                                <button type="submit" name="button" value="unpublish" class="btn btn-primary">Save as Unpublish</button>
                            </div>
                            <div class="btn-group">
                                <button type="submit" name="button" value="publish" class="btn btn-success">Save as Publish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection
