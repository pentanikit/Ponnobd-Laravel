@push('js')
    @once
        <script src="{{ asset('backend') }}/assets/js/plugins/choices.min.js"></script>
    @endonce
    <script>
        var choice = document.getElementById('{{ $attributes->get('name') }}');
        new Choices(choice,{
            removeItems: true,
            removeItemButton: true,
            placeholder : true,
            placeholderValue :"{{ $attributes->get('placeholder') }}",
            addItems: true,
        });

        choice.addEventListener('addItem',function(event) {
            if(event.detail.value){
                event.preventDefault()
            }
        },false);
    </script>
@endpush


<input class="form-select" value="{{ $attributes->get('value') }}" name="{{ $attributes->get('name') }}" id="{{ $attributes->get('name') }}" placeholder="{{ $attributes->get('placeholder') }}"/>
