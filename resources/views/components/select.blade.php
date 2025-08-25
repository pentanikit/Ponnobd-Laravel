@push('js')
    @once
        <script src="{{ asset('backend') }}/assets/js/plugins/choices.min.js"></script>
    @endonce
    <script>
        var choice = document.getElementById('{{ $attributes->get('id') ?? $attributes->get('name') }}');
        new Choices(choice,{
            removeItems: true,
            removeItemButton: true,
        });
    </script>
@endpush


<select {{ $attributes->has('multiple') ? 'multiple' : '' }} class="form-select {{ $attributes->get('class') }}" name="{{ $attributes->get('name') }}" id="{{ $attributes->get('id') ?? $attributes->get('name') }}" placeholder="{{ $attributes->get('placeholder') }}">
    {{ $slot }}
</select>
