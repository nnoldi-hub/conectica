<x-mail::message>
# Am primit mesajul tau!

Salut, {{ $contactRequest->name }},

Iti multumim ca ai ales sa ne scrii. Mesajul tau a ajuns cu succes la echipa Conectica IT si il analizam deja.

**Timp estimat de raspuns:** in aceeasi zi lucratoare, de obicei in cateva ore.

<x-mail::panel>
**Rezumatul solicitarii tale**

@if ($contactRequest->service)
**Serviciu:** {{ $contactRequest->service }}

@endif
@if ($contactRequest->budget)
**Buget orientativ:** {{ $contactRequest->budget }}

@endif
{{ $contactRequest->message }}
</x-mail::panel>

Daca vrei sa completezi ceva sau ai uitat un detaliu, poti sa raspunzi direct la acest email — ajunge direct la echipa noastra.

<x-mail::button :url="config('app.url')" color="primary">
Vezi site-ul Conectica IT
</x-mail::button>

Cu drag,<br>
Echipa Conectica IT

<x-slot:subcopy>
Acest email confirma doar primirea solicitarii tale si nu necesita nicio actiune din partea ta. Daca nu ai trimis tu aceasta solicitare, poti ignora acest mesaj in siguranta.
</x-slot:subcopy>

@if ($trackingToken ?? null)
<img src="{{ route('mail.pixel', $trackingToken) }}" alt="" width="1" height="1" style="display:none;">
@endif
</x-mail::message>

