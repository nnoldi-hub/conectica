<x-mail::message>
# Am primit mesajul tau!

Salut, {{ $contactRequest->name }},

Iti multumim ca ne-ai scris. Am primit solicitarea ta si revenim in cel mai scurt timp, de obicei in aceeasi zi lucratoare.

**Rezumatul solicitarii tale:**

@if ($contactRequest->service)
**Serviciu:** {{ $contactRequest->service }}
@endif

{{ $contactRequest->message }}

Daca ai informatii suplimentare de adaugat, poti raspunde direct la acest email.

Cu drag,<br>
Echipa Conectica IT

@if ($trackingToken ?? null)
<img src="{{ route('mail.pixel', $trackingToken) }}" alt="" width="1" height="1" style="display:none;">
@endif
</x-mail::message>
