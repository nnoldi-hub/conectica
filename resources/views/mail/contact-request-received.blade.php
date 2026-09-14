<x-mail::message>
# Solicitare noua de contact

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

**Mesaj:**

{{ $contactRequest->message }}

</x-mail::message>
