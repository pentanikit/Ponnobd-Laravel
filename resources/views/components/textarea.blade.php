@push('css')
    @once
        <link rel="stylesheet" href="{{ asset('backend/assets/js/plugins/summernote/summernote-lite.min.css') }}">
    @endonce
@endpush

<textarea {{ $attributes }} id="{{ $attributes->get('name') }}">{!! $attributes->get('value') !!}</textarea>

@push('js')
    @once
        <script type="text/javascript" src="{{ asset('backend/assets/js/plugins/tinymce/tinymce.min.js') }}"></script>
    @endonce
    <script>

        $(document).ready(function () {
0 < $("#{{ $attributes->get('name') }}").length && tinymce.init({
    selector: "textarea#{{ $attributes->get('name') }}",
    height: 300,
    plugins: ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking", "save table contextmenu directionality emoticons template paste textcolor"],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
})
});
    </script>
@endpush                                                                                                    
