@extends('backend.layouts.app')

@section('title')
Edit Section
@endsection
@push('js')
<script src="{{ asset('backend') }}/assets/js/plugins/choices.min.js"></script>
<script>
    $(document).ready(function(){
        $('#category_ids').on('change',function(){
            getProducts();
        });

        getProducts();
        function getProducts(){
            var selectedProducts = {{ Js::from($section->products->pluck('product_id')) }}
            $.ajax({
                url : "{{ route('products.get') }}",
                data : {categories:$('#category_ids').val(),selectedProducts:selectedProducts,_token:"{{ csrf_token() }}"},
                type : 'POST',
                success : function(response){
                    $('.products-box').html(response);
                    new Choices(document.getElementById('product_ids'),{
                        removeItems: true,
                        removeItemButton: true,
                    });
                }
            });
        }
    });
</script>
@endpush
@section('content')
<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>Edit Section</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('settings.home.section.update',$section->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Name</label>
                        <div class="input-group">
                            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                type="text" placeholder="Name" autocomplete="off" value="{{ $section->name }}">
                        </div>
                        @error('name')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Order</label>
                        <div class="input-group">
                            <input id="order" name="order" class="form-control @error('order') is-invalid @enderror"
                                type="number" placeholder="Ex: 2" autocomplete="off" value="{{ $section->order }}">
                        </div>
                        @error('order')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 ">
                        <div class="input-area @error('description') border-danger @enderror">
                            <label class="form-label">Description</label>
                            <textarea name="short_description" class="form-control" cols="30" rows="3" placeholder="Write short description">{{ $section->short_description }}</textarea>
                        </div>
                        @error('description')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Button Text</label>
                        <div class="input-group">
                            <input id="button_text" name="button_text" class="form-control @error('button_text') is-invalid @enderror"
                                type="text" placeholder="Ex: View All" autocomplete="off" value="{{ $section->button_text }}">
                        </div>
                        @error('button_text')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Button URL</label>
                        <div class="input-group">
                            <input id="button_url" name="button_url" class="form-control @error('button_url') is-invalid @enderror"
                                type="url" placeholder="URL" autocomplete="off" value="{{ $section->button_url }}">
                        </div>
                        @error('button_url')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 @error('category_ids') border-danger @enderror">
                        <div class="input-area">
                            <label class="form-label">Categories</label>
                            <x-select name="category_ids[]" id="category_ids" multiple>
                                <option value="" disabled>Select Categories</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(is_array(json_decode($section->categories)) && in_array($category->id,json_decode($section->categories)))>{{ $category->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                    <div class="col-12 @error('product_ids') border-danger @enderror">
                        <div class="input-area">
                            <label class="form-label">Products</label>
                            <div class="products-box"></div>
                        </div>
                        @error('product_ids')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="text-center mt-2">
                        <button class="btn btn-success">Update Section</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
