<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found — Bright Finance</title>
    <link rel="icon" type="image/png" href="/assets/images/bright.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 48px 40px;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0,0,0,.06);
        }
        .icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .icon-wrap i { font-size: 2rem; color: #1d4ed8; }
        .code {
            font-size: 4.5rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -3px;
            line-height: 1;
            margin-bottom: 8px;
        }
        .code span { color: #1d4ed8; }
        h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
        }
        p {
            font-size: .92rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 32px;
        }
        .btn-row {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .85rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-family: inherit;
        }
        .btn-primary { background: #1d4ed8; color: #fff; }
        .btn-primary:hover { background: #1e40af; }
        .btn-secondary { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .btn-secondary:hover { background: #e2e8f0; }
        .brand {
            margin-top: 40px;
            font-size: .78rem;
            color: #94a3b8;
        }
        .brand strong { color: #475569; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrap">
            <i class="material-icons-round">search_off</i>
        </div>

        <div class="code">4<span>0</span>4</div>
        <h1>Page Not Found</h1>

        @auth
        <p>
            Sorry, <strong>{{ auth()->user()->name }}</strong> — we couldn't find the page you were looking for.
            It may have been moved, deleted, or the link might be incorrect.
        </p>
        @else
        <p>
            We couldn't find the page you were looking for.
            It may have been moved, deleted, or the link might be incorrect.
        </p>
        @endauth

        <div class="btn-row">
            <button onclick="history.back()" class="btn btn-secondary">
                <i class="material-icons-round" style="font-size:1rem;">arrow_back</i>
                Go Back
            </button>
            @auth
            <a href="{{ route('transactions.index') }}" class="btn btn-primary">
                <i class="material-icons-round" style="font-size:1rem;">home</i>
                Back to Dashboard
            </a>
            @else
            <a href="{{ route('welcome') }}" class="btn btn-primary">
                <i class="material-icons-round" style="font-size:1rem;">home</i>
                Go Home
            </a>
            @endauth
        </div>

        <div class="brand">
            <strong>Bright Finance</strong> &mdash; Smart Financial Management
        </div>
    </div>
</body>
</html>
