<x-mail::message>
# Solicitare noua de contact

Ai primit o solicitare noua prin formularul de contact de pe site.

<x-mail::panel>
**Nume:** {{ $contactRequest->name }}

**Email:** {{ $contactRequest->email }}

@if ($contactRequest->phone)
**Telefon:** {{ $contactRequest->phone }}
@endif

@if ($contactRequest->service)
**Serviciu:** {{ $contactRequest->service }}
@endif

@if ($contactRequest->budget)
**Buget:** {{ $contactRequest->budget }}
@endif
</x-mail::panel>

**Mesaj:**

{{ $contactRequest->message }}

<x-mail::button :url="$adminUrl" color="primary">
Deschide in panoul de administrare
</x-mail::button>

Poti raspunde clientului direct din email sau poti actualiza statusul cererii din panoul de administrare.
</x-mail::message>
