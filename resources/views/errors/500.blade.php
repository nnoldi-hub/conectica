<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Eroare temporara | Conectica IT</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #020617;
            color: #e2e8f0;
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            padding: 24px;
        }
        .card { max-width: 32rem; text-align: center; }
        img { height: 56px; margin: 0 auto 32px; display: block; }
        .code {
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #fb923c;
            margin-bottom: 16px;
        }
        h1 { font-size: 2rem; font-weight: 600; color: #fff; letter-spacing: -0.01em; }
        p { margin-top: 16px; font-size: 1.05rem; line-height: 1.7; color: #94a3b8; }
        .actions { margin-top: 32px; display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        a.btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        a.btn-primary { background: #22d3ee; color: #020617; }
        a.btn-primary:hover { background: #67e8f9; }
        a.btn-secondary { border: 1px solid rgba(255,255,255,0.2); color: #fff; }
        a.btn-secondary:hover { border-color: rgba(255,255,255,0.5); }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('logo_symbol.png') }}" alt="Conectica IT">
        <p class="code">Eroare 500</p>
        <h1>A aparut o problema tehnica.</h1>
        <p>Echipa noastra a fost notificata automat si lucram deja la remediere. Te rugam sa incerci din nou in cateva momente.</p>
        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-primary">Inapoi la pagina principala</a>
        </div>
    </div>
</body>
</html>
