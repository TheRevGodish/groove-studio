<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groove Studio — Connexion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream: #F2EDE4;
            --black: #0E0E0E;
            --gray:  #6B6B6B;
            --border: #C8C2B8;
            --accent: #C8A96E;
        }

        html { min-height: 100%; }

        body {
            min-height: 100vh;
            background: var(--black);
            color: var(--black);
            font-family: 'DM Sans', sans-serif;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* LEFT */
        .left {
            background: var(--black);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .left::before {
            content: '';
            position: absolute;
            top: -120px; right: -120px;
            width: 400px; height: 400px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .left::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.03);
        }

        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 26px;
            letter-spacing: 0.14em;
            color: #fff;
        }

        .left-content { position: relative; z-index: 1; }

        .left-tagline {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(52px, 6vw, 88px);
            line-height: 0.95;
            letter-spacing: 0.02em;
            color: #fff;
            margin-bottom: 28px;
        }

        .left-tagline span { color: var(--accent); }

        .left-sub {
            font-size: 14px;
            color: rgba(255,255,255,0.4);
            line-height: 1.7;
            max-width: 300px;
            font-weight: 300;
        }

        .left-footer {
            font-size: 11px;
            color: rgba(255,255,255,0.18);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* RIGHT */
        .right {
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            min-height: 100vh;
        }

        .form-wrap { width: 100%; max-width: 400px; }

        .form-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 52px;
            letter-spacing: 0.04em;
            line-height: 1;
            margin-bottom: 8px;
        }

        .form-sub {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 40px;
            font-weight: 300;
        }

        .alert-error {
            background: #FDE8E8;
            border-left: 3px solid #D94040;
            padding: 12px 16px;
            font-size: 13px;
            color: #8B2020;
            margin-bottom: 24px;
        }

        .field { margin-bottom: 24px; }

        .field-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        label {
            display: block;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gray);
        }

        .field-row label { margin-bottom: 0; }

        input {
            width: 100%;
            padding: 14px 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: var(--black);
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 0;
            outline: none;
            transition: border-color 0.2s;
            -webkit-appearance: none;
        }

        input::placeholder { color: #C0BAB2; }
        input:focus { border-color: var(--black); }

        .forgot {
            font-size: 12px;
            color: var(--gray);
            text-decoration: none;
            font-weight: 300;
            transition: color 0.2s;
        }

        .forgot:hover { color: var(--black); }

        .btn-submit {
            width: 100%;
            padding: 16px;
            margin-top: 8px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 18px;
            letter-spacing: 0.12em;
            color: var(--cream);
            background: var(--black);
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover { background: #1a1a1a; }
        .btn-submit:active { transform: scale(0.99); }
        .btn-submit .arrow { transition: transform 0.2s; }
        .btn-submit:hover .arrow { transform: translateX(4px); }

        .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 32px 0;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider span {
            font-size: 11px;
            color: var(--gray);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .register-link {
            text-align: center;
            font-size: 13px;
            color: var(--gray);
            font-weight: 300;
        }

        .register-link a {
            color: var(--black);
            font-weight: 500;
            text-decoration: none;
            border-bottom: 1px solid var(--black);
            padding-bottom: 1px;
            transition: opacity 0.2s;
        }

        .register-link a:hover { opacity: 0.6; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-wrap > * { animation: fadeUp 0.45s ease both; }
        .form-wrap > *:nth-child(1) { animation-delay: 0.05s; }
        .form-wrap > *:nth-child(2) { animation-delay: 0.10s; }
        .form-wrap > *:nth-child(3) { animation-delay: 0.15s; }
        .form-wrap > *:nth-child(4) { animation-delay: 0.20s; }
        .form-wrap > *:nth-child(5) { animation-delay: 0.25s; }

        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .left { display: none; }
            .right { padding: 32px 24px; align-items: flex-start; padding-top: 64px; }
        }
    </style>
</head>
<body>

<div class="left">
    <div class="logo">GROOVE</div>
    <div class="left-content">
        <h1 class="left-tagline">VOTRE<br><span>STUDIO.</span><br>VOTRE SON.</h1>
        <p class="left-sub">Réservez un studio d'enregistrement, de répétition ou de mastering. La structure s'occupe du reste.</p>
    </div>
    <div class="left-footer">Groove Studio &mdash; Bordeaux</div>
</div>

<div class="right">
    <div class="form-wrap">

        <h2 class="form-title">CONNEXION</h2>
        <p class="form-sub">Accédez à votre espace client ou administrateur.</p>

        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="field">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email"
                       placeholder="votre@email.com"
                       value="{{ old('email') }}"
                       required autocomplete="email">
            </div>

            <div class="field">
                <input type="password" id="password" name="password"
                       placeholder="••••••••"
                       required autocomplete="current-password">
                <div class="field-row">
                    <label for="password">Mot de passe</label>
                    <a href="#" class="forgot">Mot de passe oublié ?</a>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                SE CONNECTER <span class="arrow">→</span>
            </button>

        </form>

        <div class="divider"><span>ou</span></div>

        <p class="register-link">Pas encore de compte ? <a href="#">Créer un compte</a></p>

    </div>
</div>

</body>
</html>
