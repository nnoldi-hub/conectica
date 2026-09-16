@php
    $statusLabel = \App\Models\ContactRequest::STATUSES[$contactRequest->status] ?? $contactRequest->status;
@endphp
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <title>Cerere de contact - {{ $contactRequest->name }}</title>
    @include('pdf.partials.styles')
</head>
<body>
    @include('pdf.partials.header', ['title' => 'Cerere de contact'])

    <table class="meta-table">
        <tr>
            <td class="meta-label">Nume</td>
            <td>{{ $contactRequest->name }}</td>
        </tr>
        <tr>
            <td class="meta-label">Email</td>
            <td>{{ $contactRequest->email }}</td>
        </tr>
        @if ($contactRequest->phone)
        <tr>
            <td class="meta-label">Telefon</td>
            <td>{{ $contactRequest->phone }}</td>
        </tr>
        @endif
        @if ($contactRequest->service)
        <tr>
            <td class="meta-label">Serviciu</td>
            <td>{{ $contactRequest->service }}</td>
        </tr>
        @endif
        @if ($contactRequest->budget)
        <tr>
            <td class="meta-label">Buget</td>
            <td>{{ $contactRequest->budget }}</td>
        </tr>
        @endif
        <tr>
            <td class="meta-label">Status</td>
            <td><span class="badge">{{ $statusLabel }}</span></td>
        </tr>
        <tr>
            <td class="meta-label">Primita la</td>
            <td>{{ $contactRequest->created_at?->format('d.m.Y H:i') }}</td>
        </tr>
        @if ($contactRequest->contacted_at)
        <tr>
            <td class="meta-label">Contactat la</td>
            <td>{{ $contactRequest->contacted_at->format('d.m.Y H:i') }}</td>
        </tr>
        @endif
    </table>

    <h2 class="section-title">Mesaj</h2>
    <div class="panel">
        {!! nl2br(e($contactRequest->message)) !!}
    </div>

    @include('pdf.partials.footer')
</body>
</html>
