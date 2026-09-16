<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
<a href="{{ config('app.url') }}" style="color:#64748b;text-decoration:none;font-weight:600;">{{ config('app.name') }}</a>
&nbsp;&middot;&nbsp;
<a href="{{ route('legal.privacy') }}">{{ __('Politica de confidentialitate') }}</a>
<br>
© {{ date('Y') }} {{ config('app.name') }}. {{ __('Toate drepturile rezervate.') }}
<br>
<span style="font-size:11px;color:#a1a1aa;">{{ __('Acest email a fost trimis automat, ca raspuns la o actiune efectuata pe site-ul nostru.') }}</span>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
