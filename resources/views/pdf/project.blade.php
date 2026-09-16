<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <title>Proiect - {{ $project->title }}</title>
    @include('pdf.partials.styles')
</head>
<body>
    @include('pdf.partials.header', ['title' => 'Studiu de caz'])

    <h1 class="doc-title">{{ $project->title }}</h1>

    @if ($project->client_name || $project->industry)
    <p class="doc-subtitle">
        @if ($project->client_name)
            {{ $project->client_name }}
        @endif
        @if ($project->client_name && $project->industry)
            &middot;
        @endif
        @if ($project->industry)
            {{ $project->industry }}
        @endif
    </p>
    @endif

    @if ($project->summary)
    <p>{{ $project->summary }}</p>
    @endif

    @if ($project->challenge)
    <h2 class="section-title">Provocare</h2>
    <div class="panel">{!! nl2br(e($project->challenge)) !!}</div>
    @endif

    @if ($project->solution)
    <h2 class="section-title">Solutie</h2>
    <div class="panel">{!! nl2br(e($project->solution)) !!}</div>
    @endif

    @if ($project->results)
    <h2 class="section-title">Rezultate</h2>
    <div class="panel">{!! nl2br(e($project->results)) !!}</div>
    @endif

    @if ($project->technologies)
    <h2 class="section-title">Tehnologii folosite</h2>
    <p>
        @foreach ($project->technologies as $technology)
            <span class="badge">{{ $technology }}</span>
        @endforeach
    </p>
    @endif

    @if ($project->testimonial_quote)
    <h2 class="section-title">Testimonial</h2>
    <div class="panel quote">
        <p>&bdquo;{{ $project->testimonial_quote }}&rdquo;</p>
        @if ($project->testimonial_author)
        <p class="quote-author">— {{ $project->testimonial_author }}</p>
        @endif
    </div>
    @endif

    <table class="meta-table">
        @if ($project->demo_url)
        <tr>
            <td class="meta-label">Link demo</td>
            <td>{{ $project->demo_url }}</td>
        </tr>
        @endif
        @if ($project->github_url)
        <tr>
            <td class="meta-label">Link GitHub</td>
            <td>{{ $project->github_url }}</td>
        </tr>
        @endif
        <tr>
            <td class="meta-label">Publicat</td>
            <td>{{ $project->is_published ? 'Da' : 'Nu' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Creat la</td>
            <td>{{ $project->created_at?->format('d.m.Y H:i') }}</td>
        </tr>
    </table>

    @include('pdf.partials.footer')
</body>
</html>
