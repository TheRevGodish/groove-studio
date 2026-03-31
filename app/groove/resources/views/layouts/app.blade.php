<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groove Studio — @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:   #F2EDE4;
            --black:   #0E0E0E;
            --gray:    #6B6B6B;
            --border:  #C8C2B8;
            --accent:  #C8A96E;
            --danger:  #D94040;
            --success: #2A7A45;
        }

        html, body {
            min-height: 100vh;
            background: var(--cream);
            color: var(--black);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            line-height: 1.6;
        }

        /* ── NAV ── */
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            height: 60px;
            background: var(--black);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 22px;
            letter-spacing: 0.14em;
            color: #fff;
            text-decoration: none;
        }

        .nav-center {
            display: flex;
            gap: 32px;
        }

        .nav-link {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: color 0.2s;
            padding: 4px 0;
            border-bottom: 1px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff;
            border-bottom-color: var(--accent);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-user {
            font-size: 13px;
            color: rgba(255,255,255,0.45);
            font-weight: 300;
        }

        .nav-user strong {
            color: #fff;
            font-weight: 500;
        }

        @if(Auth::check() && Auth::user()->is_admin)
        .nav-admin-badge {
            font-size: 9px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            background: var(--accent);
            color: var(--black);
            padding: 2px 7px;
            font-weight: 500;
        }
        @endif

        .nav-logout {
            font-size: 11px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: color 0.2s;
            padding: 0;
        }

        .nav-logout:hover { color: #fff; }

        /* ── MAIN ── */
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 56px 48px;
        }

        /* ── TYPOGRAPHY ── */
        .page-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 64px;
            letter-spacing: 0.03em;
            line-height: 1;
            margin-bottom: 8px;
        }

        .page-sub {
            font-size: 14px;
            color: var(--gray);
            font-weight: 300;
            margin-bottom: 48px;
        }

        .section-label {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gray);
            margin-bottom: 16px;
        }

        /* ── CARDS ── */
        .card {
            background: #fff;
            border: 0.5px solid var(--border);
            padding: 28px 32px;
            margin-bottom: 24px;
        }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 48px;
        }

        .stat-card {
            background: var(--black);
            padding: 24px 28px;
        }

        .stat-label {
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            margin-bottom: 8px;
        }

        .stat-value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 44px;
            letter-spacing: 0.02em;
            line-height: 1;
            color: var(--accent);
        }

        /* ── TABLE ── */
        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr { border-bottom: 1px solid var(--black); }

        thead th {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--gray);
            padding: 0 16px 12px 0;
            text-align: left;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        tbody tr:hover { background: rgba(0,0,0,0.02); }

        tbody td {
            padding: 14px 16px 14px 0;
            font-size: 13px;
            vertical-align: middle;
        }

        .td-muted {
            color: var(--gray);
            font-weight: 300;
        }

        .td-bold {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 18px;
            letter-spacing: 0.03em;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 3px 8px;
        }

        .badge-en_attente  { background: #F0EDDC; color: #7A7040; }
        .badge-proposee    { background: #DDE8F5; color: #2D5A8E; }
        .badge-confirmee   { background: #DCF0E2; color: #2A7A45; }
        .badge-refusee     { background: #F5DDDD; color: #8E2D2D; }
        .badge-annulee     { background: #EBEBEB; color: #555; }
        .badge-terminee    { background: #0E0E0E; color: #fff; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 24px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 15px;
            letter-spacing: 0.1em;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn:active { transform: scale(0.99); }

        .btn-primary { background: var(--black); color: var(--cream); }
        .btn-primary:hover { opacity: 0.85; }

        .btn-accent { background: var(--accent); color: var(--black); }
        .btn-accent:hover { opacity: 0.85; }

        .btn-ghost {
            background: transparent;
            color: var(--black);
            border: 1px solid var(--border);
        }
        .btn-ghost:hover { border-color: var(--black); }

        /* ── ALERTS ── */
        .alert {
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 24px;
            border-left: 3px solid;
        }

        .alert-error   { background: #FDE8E8; border-color: var(--danger); color: #8B2020; }
        .alert-success { background: #DCF0E2; border-color: var(--success); color: #1A5C31; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-1 { animation: fadeUp 0.4s ease 0.05s both; }
        .fade-2 { animation: fadeUp 0.4s ease 0.10s both; }
        .fade-3 { animation: fadeUp 0.4s ease 0.15s both; }
        .fade-4 { animation: fadeUp 0.4s ease 0.20s both; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            nav  { padding: 0 24px; }
            main { padding: 32px 24px; }
            .nav-center { display: none; }
            .page-title { font-size: 44px; }
        }

        @yield('styles')
    </style>
</head>
<body>

<nav>
    <a href="/" class="nav-logo">GROOVE</a>

    @auth
        <div class="nav-center">
            
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
            
            <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">Mon espace</a>
            
            @if(Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">[admin] Dashboard</a>
            @endif
            
        </div>

        <div class="nav-right">
        <span class="nav-user">
            <strong>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</strong>
            @if(Auth::user()->is_admin)
                <span class="nav-admin-badge">Admin</span>
            @endif
        </span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-logout">Déconnexion</button>
            </form>
        </div>
    @endauth
</nav>

<main>
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</main>

@yield('scripts')
</body>
</html>
