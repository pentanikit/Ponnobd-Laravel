@push('js')
<script src="{{ asset('assets/js/uppy.min.js') }}"></script>
@endpush
<div class="input-group @error($attributes->get('name')) border-danger @enderror" data-toggle="uploader" data-type="{{ $attributes->get('fileType') }}" data-multiple="{{ $attributes->has('multiple') ? 'true' : 'false' }}">
    <div class="input-group-prepend">
        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
    </div>
    <div class="form-control file-amount">Choose File</div>
    <input type="hidden" name="{{ $attributes->get('name') }}" class="selected-files" value="{{ $attributes->get('value') }}">
</div>
<div class="file-preview box sm">

</div>
<br>
@error($attributes->get('name'))
<div class="text text-danger">
    {{ $message }}
</div>
@enderror
