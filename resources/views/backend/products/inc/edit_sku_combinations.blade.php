@if(count($combinations[0]) > 0)
<table class="table table-bordered">
	<thead>
		<tr>
			<td class="text-center">
				{{ __('Variant')}}
			</td>
			<td class="text-center">
				{{ __('Variant Price')}}
			</td>
			<td class="text-center">
				{{ __('SKU')}}
			</td>
			<td class="text-center">
				{{ __('Quantity')}}
			</td>
			<td class="text-center">
				{{ __('Photo')}}
			</td>
		</tr>
	</thead>
	<tbody>
	@foreach ($combinations as $key => $combination)
		@php
			$sku = '';
			foreach (explode(' ', $product_name) as $key => $value) {
				$sku .= substr($value, 0, 1);
			}

			$str = '';
			foreach ($combination as $key => $item){
				if($key > 0 ){
					$str .= '-'.str_replace(' ', '', $item);
					$sku .='-'.str_replace(' ', '', $item);
				}
				else{
                    $str .= str_replace(' ', '', $item);
					$sku .='-'.str_replace(' ', '', $item);
				}
                $stock = $product->stocks->where('variant', $str)->first();
			}
		@endphp
		@if(strlen($str) > 0)
			<tr class="variant">
				<td>
					<label for="" class="control-label">{{ $str }}</label>
				</td>
				<td>
					<input type="number" name="price_{{ $str }}" value="{{ $stock->price ?? $unit_price }}" min="0" step="1" class="form-control" required>
				</td>
				<td>
					<input type="text" name="sku_{{ $str }}" value="{{ $stock?->sku ?? $str }}" class="form-control">
				</td>
				<td>
					<input type="number" name="qty_{{ $str }}" value="{{ $stock->qty ?? 10 }}" min="0" step="1" class="form-control" required>
				</td>
				<td>
					<div class=" input-group " data-toggle="uploader" data-type="image">
						<div class="input-group-prepend">
							<div class="input-group-text bg-soft-secondary font-weight-medium">{{  __('Browse') }}</div>
						</div>
						<div class="form-control file-amount text-truncate">{{  __('Choose File') }}</div>
						<input type="hidden" name="img_{{ $str }}" class="selected-files" value="{{ $stock?->image }}">
					</div>
					<div class="file-preview box sm"></div>
				</td>
			</tr>
		@endif
	@endforeach
	</tbody>
</table>
@endif
