<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groove Studio — Bordeaux</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:  #F2EDE4;
            --black:  #0E0E0E;
            --gray:   #6B6B6B;
            --border: #C8C2B8;
            --accent: #C8A96E;
        }

        html { scroll-behavior: smooth; }

        body {
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

        .nav-links {
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

        .nav-link:hover {
            color: #fff;
            border-bottom-color: var(--accent);
        }

        .nav-cta {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 14px;
            letter-spacing: 0.1em;
            color: var(--black);
            background: var(--accent);
            padding: 8px 20px;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .nav-cta:hover { opacity: 0.85; }

        /* ── HERO ── */
        .hero {
            background: var(--black);
            min-height: calc(50vh - 60px);
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            border-radius: 50%;
            border: 1px solid rgba(200,169,110,0.08);
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -150px; left: 30%;
            width: 400px; height: 400px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.03);
            pointer-events: none;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 48px 40px 80px;
            position: relative;
            z-index: 1;
        }

        .hero-eyebrow {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(48px, 5.5vw, 80px);
            line-height: 0.92;
            letter-spacing: 0.02em;
            color: #fff;
            margin-bottom: 20px;
        }

        .hero-title span { color: var(--accent); }

        .hero-desc {
            font-size: 14px;
            color: rgba(255,255,255,0.45);
            line-height: 1.7;
            max-width: 380px;
            font-weight: 300;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .btn-hero-primary {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 16px;
            letter-spacing: 0.12em;
            color: var(--black);
            background: var(--accent);
            padding: 16px 36px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn-hero-primary:hover { opacity: 0.9; }
        .btn-hero-primary:active { transform: scale(0.99); }
        .btn-hero-primary .arrow { transition: transform 0.2s; }
        .btn-hero-primary:hover .arrow { transform: translateX(4px); }

        .btn-hero-ghost {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding-bottom: 2px;
            transition: color 0.2s, border-color 0.2s;
        }

        .btn-hero-ghost:hover {
            color: #fff;
            border-bottom-color: rgba(255,255,255,0.6);
        }

        .hero-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 40px 80px 40px 48px;
            position: relative;
            z-index: 1;
        }

        .hero-stat-block {
            display: flex;
            flex-direction: row;
            gap: 48px;
        }

        .hero-stat {
            border-left: 2px solid rgba(200,169,110,0.3);
            padding-left: 20px;
        }

        .hero-stat-value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 40px;
            line-height: 1;
            letter-spacing: 0.02em;
            color: var(--accent);
        }

        .hero-stat-label {
            font-size: 11px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            font-weight: 300;
            margin-top: 4px;
        }

        /* ── TICKER ── */
        .ticker {
            background: var(--accent);
            overflow: hidden;
            height: 40px;
            display: flex;
            align-items: center;
        }

        .ticker-track {
            display: flex;
            animation: tickerScroll 30s linear infinite;
            white-space: nowrap;
        }

        .ticker-item {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 14px;
            letter-spacing: 0.15em;
            color: var(--black);
            padding: 0 32px;
        }

        .ticker-sep {
            font-size: 14px;
            color: rgba(14,14,14,0.3);
            padding: 0 8px;
        }

        @keyframes tickerScroll {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        /* ── SERVICES ── */
        .services {
            padding: 96px 80px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-eyebrow {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gray);
            margin-bottom: 16px;
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(44px, 5vw, 72px);
            letter-spacing: 0.02em;
            line-height: 1;
            margin-bottom: 56px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2px;
        }

        .service-card {
            background: #fff;
            border: 0.5px solid var(--border);
            padding: 40px 36px;
            position: relative;
            overflow: hidden;
            transition: transform 0.25s;
        }

        .service-card:hover { transform: translateY(-4px); }

        .service-card::before {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 2px;
            background: var(--accent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .service-card:hover::before { transform: scaleX(1); }

        .service-number {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 13px;
            letter-spacing: 0.2em;
            color: var(--accent);
            margin-bottom: 24px;
        }

        .service-icon {
            font-size: 32px;
            margin-bottom: 20px;
            display: block;
        }

        .service-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 32px;
            letter-spacing: 0.04em;
            line-height: 1;
            margin-bottom: 16px;
        }

        .service-desc {
            font-size: 13px;
            color: var(--gray);
            line-height: 1.75;
            font-weight: 300;
            margin-bottom: 28px;
        }

        .service-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .service-features li {
            font-size: 12px;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .service-features li::before {
            content: '';
            width: 16px;
            height: 1px;
            background: var(--accent);
            flex-shrink: 0;
        }

        /* ── AMBIANCE ── */
        .ambiance {
            background: var(--black);
            padding: 96px 80px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .ambiance-eyebrow {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 16px;
        }

        .ambiance-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(40px, 4.5vw, 64px);
            letter-spacing: 0.02em;
            line-height: 1;
            color: #fff;
            margin-bottom: 28px;
        }

        .ambiance-text {
            font-size: 14px;
            color: rgba(255,255,255,0.45);
            line-height: 1.85;
            font-weight: 300;
            margin-bottom: 20px;
        }

        .ambiance-right {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .ambiance-item {
            background: rgba(255,255,255,0.04);
            border: 0.5px solid rgba(255,255,255,0.08);
            padding: 28px 24px;
        }

        .ambiance-item-icon {
            font-size: 24px;
            margin-bottom: 14px;
            display: block;
        }

        .ambiance-item-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 20px;
            letter-spacing: 0.06em;
            color: #fff;
            margin-bottom: 8px;
        }

        .ambiance-item-desc {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            line-height: 1.65;
            font-weight: 300;
        }

        /* ── CTA ── */
        .cta-section {
            padding: 96px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: 'GROOVE';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(120px, 18vw, 260px);
            letter-spacing: 0.05em;
            color: rgba(0,0,0,0.04);
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
        }

        .cta-inner { position: relative; z-index: 1; }

        .cta-eyebrow {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gray);
            margin-bottom: 16px;
        }

        .cta-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(52px, 6vw, 88px);
            letter-spacing: 0.02em;
            line-height: 1;
            margin-bottom: 20px;
        }

        .cta-title span { color: var(--accent); }

        .cta-sub {
            font-size: 14px;
            color: var(--gray);
            font-weight: 300;
            max-width: 480px;
            margin: 0 auto 48px;
            line-height: 1.75;
        }

        .cta-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-cta-primary {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 16px;
            letter-spacing: 0.12em;
            color: var(--cream);
            background: var(--black);
            padding: 16px 40px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: opacity 0.2s;
        }

        .btn-cta-primary:hover { opacity: 0.8; }

        .btn-cta-secondary {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 16px;
            letter-spacing: 0.12em;
            color: var(--black);
            background: transparent;
            padding: 15px 40px;
            text-decoration: none;
            border: 1px solid var(--border);
            transition: border-color 0.2s;
        }

        .btn-cta-secondary:hover { border-color: var(--black); }

        /* ── FOOTER ── */
        footer {
            background: var(--black);
            padding: 48px 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 20px;
            letter-spacing: 0.14em;
            color: #fff;
        }

        .footer-info {
            font-size: 12px;
            color: rgba(255,255,255,0.2);
            font-weight: 300;
            text-align: center;
            line-height: 1.7;
        }

        .footer-right {
            font-size: 11px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.15);
            text-align: right;
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-1 { animation: fadeUp 0.5s ease 0.05s both; }
        .fade-2 { animation: fadeUp 0.5s ease 0.15s both; }
        .fade-3 { animation: fadeUp 0.5s ease 0.25s both; }
        .fade-4 { animation: fadeUp 0.5s ease 0.35s both; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .hero { grid-template-columns: 1fr; }
            .hero-right { display: none; }
            .hero-left { padding: 80px 48px; }
            .services-grid { grid-template-columns: 1fr; }
            .ambiance { grid-template-columns: 1fr; gap: 48px; padding: 72px 48px; }
        }

        @media (max-width: 768px) {
            nav { padding: 0 24px; }
            .nav-links { display: none; }
            .hero-left { padding: 64px 24px; }
            .services { padding: 64px 24px; }
            .cta-section { padding: 64px 24px; }
            footer { padding: 40px 24px; flex-direction: column; gap: 24px; text-align: center; }
            .footer-right { text-align: center; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav>
    <a href="{{ route('home') }}" class="nav-logo">GROOVE</a>
    <div class="nav-links">
        <a href="#services" class="nav-link">Studios</a>
        <a href="#ambiance" class="nav-link">L'esprit</a>
    </div>
    @auth
        <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('client.dashboard') }}" class="nav-cta">
            Mon espace →
        </a>
    @else
        <a href="{{ route('login') }}" class="nav-cta">Se connecter →</a>
    @endauth
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-left">
        <p class="hero-eyebrow fade-1">Studio d'enregistrement — Bordeaux</p>
        <h1 class="hero-title fade-2">
            VOTRE<br>
            <span>MUSIQUE</span><br>
            MÉRITE LE<br>
            MEILLEUR.
        </h1>
        <p class="hero-desc fade-3">
            Réservez un studio d'enregistrement, de répétition ou de mastering en quelques clics.
            Groove vous accueille dans un espace chaleureux conçu pour les artistes.
        </p>
        <div class="hero-actions fade-4">
            <a href="{{ route('login') }}" class="btn-hero-primary">
                Réserver un créneau <span class="arrow">→</span>
            </a>
            <a href="#services" class="btn-hero-ghost">Découvrir nos studios</a>
        </div>
    </div>
    <div class="hero-right">
        <div class="hero-stat-block">
            <div class="hero-stat">
                <div class="hero-stat-value">3</div>
                <div class="hero-stat-label">Studios disponibles</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-value">7J</div>
                <div class="hero-stat-label">Ouvert 7 jours / 7</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-value">10+</div>
                <div class="hero-stat-label">Années d'expérience</div>
            </div>
        </div>
    </div>
</section>

<!-- TICKER -->
<div class="ticker">
    <div class="ticker-track">
        <span class="ticker-item">ENREGISTREMENT</span><span class="ticker-sep">·</span>
        <span class="ticker-item">RÉPÉTITION</span><span class="ticker-sep">·</span>
        <span class="ticker-item">MASTERING</span><span class="ticker-sep">·</span>
        <span class="ticker-item">MIXAGE</span><span class="ticker-sep">·</span>
        <span class="ticker-item">PRODUCTION</span><span class="ticker-sep">·</span>
        <span class="ticker-item">BORDEAUX</span><span class="ticker-sep">·</span>
        <span class="ticker-item">GROOVE STUDIO</span><span class="ticker-sep">·</span>
        <span class="ticker-item">ENREGISTREMENT</span><span class="ticker-sep">·</span>
        <span class="ticker-item">RÉPÉTITION</span><span class="ticker-sep">·</span>
        <span class="ticker-item">MASTERING</span><span class="ticker-sep">·</span>
        <span class="ticker-item">MIXAGE</span><span class="ticker-sep">·</span>
        <span class="ticker-item">PRODUCTION</span><span class="ticker-sep">·</span>
        <span class="ticker-item">BORDEAUX</span><span class="ticker-sep">·</span>
        <span class="ticker-item">GROOVE STUDIO</span><span class="ticker-sep">·</span>
    </div>
</div>

<!-- SERVICES -->
<section class="services" id="services">
    <p class="section-eyebrow">Nos espaces</p>
    <h2 class="section-title">TROIS STUDIOS,<br>UN SEUL ENDROIT.</h2>

    <div class="services-grid">
        <div class="service-card">
            <div class="service-number">01</div>
            <span class="service-icon">🎙</span>
            <h3 class="service-name">ENREGISTREMENT</h3>
            <p class="service-desc">
                Une cabine insonorisée de haut niveau et une régie équipée pour capter chaque nuance de votre performance.
            </p>
            <ul class="service-features">
                <li>Console SSL + préamplis haut de gamme</li>
                <li>Isolation acoustique professionnelle</li>
                <li>Ingénieur du son disponible</li>
                <li>Enregistrement multipiste</li>
            </ul>
        </div>

        <div class="service-card">
            <div class="service-number">02</div>
            <span class="service-icon">🥁</span>
            <h3 class="service-name">RÉPÉTITION</h3>
            <p class="service-desc">
                Un espace généreux et bien équipé pour répéter, écrire et créer ensemble, dans une ambiance décontractée.
            </p>
            <ul class="service-features">
                <li>Backline complet (batterie, amplis)</li>
                <li>PA professionnel inclus</li>
                <li>Vestiaire et espace détente</li>
                <li>Climatisation &amp; isolation phonique</li>
            </ul>
        </div>

        <div class="service-card">
            <div class="service-number">03</div>
            <span class="service-icon">🎚</span>
            <h3 class="service-name">MASTERING</h3>
            <p class="service-desc">
                Finalisez votre son dans notre suite de mastering acoustiquement traitée, pensée pour la précision et le détail.
            </p>
            <ul class="service-features">
                <li>Monitoring haut-parleurs de référence</li>
                <li>Traitement acoustique sur mesure</li>
                <li>Finalisation pour streaming &amp; CD</li>
                <li>Retour de fichiers en 24h</li>
            </ul>
        </div>
    </div>
</section>

<!-- AMBIANCE -->
<section class="ambiance" id="ambiance">
    <div class="ambiance-left">
        <p class="ambiance-eyebrow">L'esprit Groove</p>
        <h2 class="ambiance-title">UN LIEU PENSÉ<br>POUR LES<br>ARTISTES.</h2>
        <p class="ambiance-text">
            Groove Studio n'est pas qu'un espace de travail. C'est un lieu de vie pour les musiciens — chaleureux, inspirant, et sans prise de tête.
        </p>
        <p class="ambiance-text">
            Nous avons conçu chaque détail pour que vous puissiez vous concentrer sur une seule chose : votre musique.
        </p>
    </div>
    <div class="ambiance-right">
        <div class="ambiance-item">
            <span class="ambiance-item-icon">☕</span>
            <div class="ambiance-item-title">DÉTENTE</div>
            <p class="ambiance-item-desc">Salon confortable, café et thé à disposition. Parce qu'une pause fait partie du processus créatif.</p>
        </div>
        <div class="ambiance-item">
            <span class="ambiance-item-icon">🕐</span>
            <div class="ambiance-item-title">FLEXIBILITÉ</div>
            <p class="ambiance-item-desc">Créneaux de 1h à la journée complète, 7j/7, de 9h à minuit. On s'adapte à vos rythmes.</p>
        </div>
        <div class="ambiance-item">
            <span class="ambiance-item-icon">🔒</span>
            <div class="ambiance-item-title">SÉCURITÉ</div>
            <p class="ambiance-item-desc">Accès sécurisé, casiers pour vos instruments et équipements. Vos affaires sont en sécurité.</p>
        </div>
        <div class="ambiance-item">
            <span class="ambiance-item-icon">🎧</span>
            <div class="ambiance-item-title">EXPERTISE</div>
            <p class="ambiance-item-desc">Notre équipe est à votre disposition pour vous conseiller sur le matériel et les techniques.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-inner">
        <p class="cta-eyebrow">Prêt à enregistrer ?</p>
        <h2 class="cta-title">RÉSERVEZ VOTRE<br><span>CRÉNEAU</span> DÈS MAINTENANT.</h2>
        <p class="cta-sub">Créez votre compte en quelques secondes et choisissez le studio et le créneau qui vous conviennent.</p>
        <div class="cta-actions">
            <a href="{{ route('login') }}" class="btn-cta-primary">Accéder à mon espace →</a>
            <a href="mailto:contact@groove-studio.fr" class="btn-cta-secondary">Nous contacter</a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-logo">GROOVE</div>
    <div class="footer-info">
        Groove Studio &mdash; Bordeaux<br>
        contact@groove-studio.fr
    </div>
    <div class="footer-right">
        &copy; {{ date('Y') }} Groove Studio<br>
        Tous droits réservés
    </div>
</footer>

</body>
</html>
