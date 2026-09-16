@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
@if (trim($slot) === config('app.name'))
<img src="{{ asset('logo_symbol.png') }}" class="logo" alt="{{ config('app.name') }}">
<div class="logo-wordmark">
    <span class="logo-wordmark-dark">conectica</span><span class="logo-wordmark-accent">-it</span>
</div>
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
