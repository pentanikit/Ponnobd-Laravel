
<select name="product_ids[]" id="product_ids" multiple>
    <option value="" disabled>Select Products</option>
    @foreach($products as $product)
    <option value='{{ $product->id }}' @selected(is_array(request('selectedProducts')) && in_array($product->id,request('selectedProducts')))>{{ $product->name }}</option>
    @endforeach
</select>
