<div class="col-md-4 mb-2">
    <input type="hidden" name="attributes[{{ data_get($attribute_values,'0.attribute_id') }}]" value="{{ data_get($attribute_values,'0.attribute_id') }}">
    <input type="text" value="{{ data_get($attribute_values,'0.attribute.name') }}" class="form-control" disabled>
</div>
<div class="col-md-8 mb-2">
    <x-select name="attributes_values_{{ data_get($attribute_values,'0.attribute_id')  }}[]" class="attribute_choice" id="attributes_values_{{ data_get($attribute_values,'0.attribute_id') }}" multiple>
        @foreach ($attribute_values as $row)
            <option value="{{ $row->value }}">{{ $row->value }}</option>
        @endforeach
    </x-select>
</div>
