<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title') — Yalla Courier</title>

    {{--
        Deliberately self-contained: no @extends of the site's CMS-driven
        master layout, no DB queries, no model lookups. An error page has to
        be the one thing in the app that can never itself throw an error —
        if the database or a model is what broke in the first place, a 500
        page that queries the database too would just fail again.
    --}}
    <style>
        :root { --purple: #680895; --purple-dark: #4e0570; }
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            height: 100%;
            font-family: Helvetica, Arial, sans-serif;
            background: #f6f5f8;
            color: #2a2a2a;
        }
        .wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(16, 15, 13, 0.08);
            padding: 40px 32px;
            text-align: center;
        }
        .logo { width: 140px; height: auto; margin-bottom: 28px; }
        .code {
            font-size: 4.5rem;
            font-weight: 800;
            color: var(--purple);
            line-height: 1;
            margin: 0 0 8px;
        }
        h1 {
            font-size: 1.3rem;
            margin: 0 0 12px;
            color: #1f1b24;
        }
        p.desc {
            color: #6b6475;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0 0 28px;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-primary { background: var(--purple); color: #fff; }
        .btn-primary:hover { background: var(--purple-dark); color: #fff; }
        .btn-whatsapp { background: #25D366; color: #fff; }
        .btn-whatsapp:hover { background: #1ebe59; color: #fff; }
        @media (max-width: 420px) {
            .card { padding: 32px 20px; }
            .code { font-size: 3.5rem; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <img src="{{ asset('front_assets/images/header-logo.svg') }}" alt="Yalla Courier" class="logo">
            <p class="code">@yield('code')</p>
            <h1>@yield('message')</h1>
            <p class="desc">@yield('description')</p>
            <div class="actions">
                <a href="/" class="btn btn-primary">Back to homepage</a>
                @hasSection('whatsapp')
                <a href="https://wa.me/971526607133" target="_blank" rel="noopener" class="btn btn-whatsapp">Need help? WhatsApp</a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
