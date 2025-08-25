@push('css')
    @once
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
    @endonce
@endpush
@push('js')
    @once
        {{-- <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
    @endonce
    <script>
        let el = "#{{ $attributes->get('name') }}";
        $(el).selectpicker();
    </script>
@endpush

<select {{ $attributes }}>
    {{ $slot }}
</select>
