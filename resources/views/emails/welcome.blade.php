@component('mail::message')
# Hi {{ $name }},

Welcome aboard! We’re glad you’re here.

@component('mail::button', ['url' => config('app.url')])
Go to site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

