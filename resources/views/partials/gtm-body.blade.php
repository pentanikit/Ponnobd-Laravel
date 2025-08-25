{{-- Google Tag Manager (noscript) --}}
@php($GTM_ID = config('services.gtm.id'))
@if(!empty($GTM_ID))
<noscript>
  <iframe src="https://www.googletagmanager.com/ns.html?id={{ $GTM_ID }}"
          height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
@else
<!-- GTM noscript skipped: missing services.gtm.id -->
@endif
{{-- End Google Tag Manager (noscript) --}}
