<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($company->meta_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($company->meta_description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($company->meta_keywords) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= htmlspecialchars($company->fantasy_name) ?>">
    <meta name="theme-color" content="#0D3F6F">
    <meta name="format-detection" content="telephone=no">
    <link rel="canonical" href="<?= base_url('seguro-viagem-fapesp') ?>">

    <!-- Open Graph / Social -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($company->meta_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($company->meta_description) ?>">
    <meta property="og:url" content="<?= base_url('seguro-viagem-fapesp') ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($company->fantasy_name) ?>">
    <meta property="og:image" content="<?= base_url('assets/img/bolsista-fapesp-seguro-viagem-og.jpg') ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:locale" content="pt_BR">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($company->meta_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($company->meta_description) ?>">
    <meta name="twitter:image" content="<?= base_url('assets/img/bolsista-fapesp-seguro-viagem-og.jpg') ?>">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="https://wa.me">

    <!-- Fonts: Inter (blueprint spec) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS inline para performance (< 3s carregamento) -->
    <style>
        :root {
            --azul-escuro: #0D3F6F;
            --azul-medio: #1A5FA8;
            --verde: #0F6E56;
            --branco: #FFFFFF;
            --cinza-claro: #F5F5F3;
            --cinza-texto: #4A5568;
            --cinza-borda: #E2E8F0;
            --sombra: 0 4px 24px rgba(13, 63, 111, 0.08);
            --radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 17px;
            line-height: 1.7;
            color: var(--cinza-texto);
            background: var(--branco);
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 24px;
        }

        img { max-width: 100%; height: auto; }

        /* =========================================
           HEADER / NAV
        ========================================= */
        .site-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--cinza-borda);
            transition: box-shadow 0.3s;
        }
        .site-header.scrolled {
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }
        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }
        .nav-logo {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--azul-escuro);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .nav-logo i { color: var(--azul-medio); font-size: 1.4rem; }
        .nav-links {
            display: flex;
            gap: 20px;
            list-style: none;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--cinza-texto);
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.2s;
            white-space: nowrap;
        }
        .nav-links a:hover { color: var(--azul-medio); }
        .nav-cta {
            background: var(--verde);
            color: var(--branco) !important;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .nav-cta:hover { background: #0b5c47; }
        .nav-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: var(--azul-escuro); cursor: pointer; }

        /* =========================================
           BUTTONS
        ========================================= */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: var(--verde);
            color: var(--branco);
            box-shadow: 0 4px 16px rgba(15, 110, 86, 0.3);
        }
        .btn-primary:hover {
            background: #0b5c47;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(15, 110, 86, 0.4);
        }
        .btn-secondary {
            background: transparent;
            color: var(--azul-medio);
            border: 2px solid var(--azul-medio);
        }
        .btn-secondary:hover {
            background: var(--azul-medio);
            color: var(--branco);
        }
        .btn-whatsapp {
            background: #25D366;
            color: var(--branco);
            box-shadow: 0 4px 16px rgba(37, 211, 102, 0.3);
        }
        .btn-whatsapp:hover {
            background: #1fb855;
            transform: translateY(-2px);
        }

        /* =========================================
           S1 - HERO
        ========================================= */
        .hero {
            padding: 140px 0 80px;
            background: linear-gradient(135deg, #f8faff 0%, var(--cinza-claro) 100%);
            position: relative;
            overflow: hidden;
        }
        .hero::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(26, 95, 168, 0.06) 0%, transparent 70%);
            border-radius: 50%;
        }
        /* Hero 2-column layout */
        .hero-row {
            display: flex;
            align-items: center;
            gap: 48px;
        }
        .hero-col-text {
            flex: 1;
            min-width: 0;
        }
        .hero-col-image {
            flex: 0 0 420px;
            max-width: 420px;
            position: relative;
            z-index: 2;
        }
        .hero-col-image img {
            width: 100%;
            height: auto;
            border-radius: 16px;
            object-fit: cover;
        }
        /* Slider wrapper */
        .hero-slider { position: relative; min-height: 280px; }
        .hero-slide {
            position: absolute;
            top: 0; left: 0; width: 100%;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.8s ease, visibility 0.8s ease;
            z-index: 1;
        }
        .hero-slide.active {
            position: relative;
            opacity: 1;
            visibility: visible;
            z-index: 2;
        }
        .hero-dots {
            display: flex;
            gap: 10px;
            margin-top: 28px;
            z-index: 3;
            position: relative;
        }
        .hero-dots button {
            width: 12px; height: 12px;
            border-radius: 50%;
            border: 2px solid var(--azul-medio);
            background: transparent;
            cursor: pointer;
            padding: 0;
            transition: background 0.3s;
        }
        .hero-dots button.active { background: var(--azul-medio); }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 720px;
        }
        .hero h1,
        .hero .hero-heading {
            font-size: 3.2rem;
            font-weight: 800;
            color: var(--azul-escuro);
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
        }
        .hero .subtitle {
            font-size: 1.25rem;
            color: var(--cinza-texto);
            margin-bottom: 36px;
            line-height: 1.6;
        }
        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        .hero-selos {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }
        .selo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--azul-escuro);
        }
        .selo i {
            color: var(--verde);
            font-size: 1.1rem;
        }

        /* =========================================
           SECTION BASE
        ========================================= */
        .section {
            padding: 80px 0;
        }
        .section-alt {
            background: var(--cinza-claro);
        }
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--azul-escuro);
            margin-bottom: 16px;
            text-align: center;
            line-height: 1.3;
        }
        .section-desc {
            text-align: center;
            max-width: 680px;
            margin: 0 auto 48px;
            color: var(--cinza-texto);
            font-size: 1.05rem;
        }

        /* =========================================
           S2 - AUTORIDADE
        ========================================= */
        .autoridade-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
            margin-bottom: 48px;
        }
        .autoridade-card {
            text-align: center;
            padding: 40px 24px;
            background: var(--branco);
            border-radius: var(--radius);
            box-shadow: var(--sombra);
            transition: transform 0.3s;
        }
        .autoridade-card:hover { transform: translateY(-4px); }
        .autoridade-card .numero {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--azul-medio);
            display: block;
            margin-bottom: 8px;
        }
        .autoridade-card i {
            font-size: 2rem;
            color: var(--verde);
            margin-bottom: 16px;
            display: block;
        }
        .autoridade-card .label {
            font-size: 0.95rem;
            color: var(--cinza-texto);
            line-height: 1.5;
        }
        /* =========================================
           CREDIBILITY BAR (between S1 and S2)
        ========================================= */
        .credibility-bar {
            padding: 24px 0;
            background: var(--branco);
            border-bottom: 1px solid var(--cinza-borda);
            border-top: 1px solid var(--cinza-borda);
        }
        .credibility-logos {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 48px;
            flex-wrap: wrap;
        }
        .credibility-logos img {
            height: 48px;
            width: auto;
            opacity: 0.75;
            transition: opacity 0.3s;
        }
        .credibility-logos img:hover {
            opacity: 1;
        }
        .credibility-logos .credibility-sep {
            width: 1px;
            height: 36px;
            background: var(--cinza-borda);
        }

        /* =========================================
           SEGURADORAS PARCEIRAS
        ========================================= */
        .seguradoras-grid {
            display: flex;
            align-items: stretch;
            justify-content: center;
            gap: 32px;
            flex-wrap: wrap;
        }
        .seguradora-box {
            width: 160px;
            height: 160px;
            background: var(--branco);
            border-radius: var(--radius);
            box-shadow: var(--sombra);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            transition: all 0.3s;
            text-decoration: none;
            cursor: pointer;
        }
        .seguradora-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 32px rgba(13, 63, 111, 0.12);
        }
        .seguradora-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            opacity: 0.75;
            filter: grayscale(30%);
            transition: all 0.3s;
        }
        .seguradora-box:hover img {
            opacity: 1;
            filter: none;
        }

        /* =========================================
           S3 - REQUISITOS FAPESP
        ========================================= */
        .requisitos-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: start;
        }
        .checklist {
            list-style: none;
        }
        .checklist li {
            padding: 16px 0;
            border-bottom: 1px solid var(--cinza-borda);
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }
        .checklist li:last-child { border-bottom: none; }
        .checklist i {
            color: var(--verde);
            font-size: 1.2rem;
            margin-top: 3px;
            flex-shrink: 0;
        }
        .checklist strong {
            color: var(--azul-escuro);
            display: block;
            margin-bottom: 4px;
            font-size: 0.95rem;
        }
        .checklist span {
            font-size: 0.9rem;
            line-height: 1.5;
        }
        .requisitos-texto {
            font-size: 0.95rem;
            line-height: 1.8;
            color: var(--cinza-texto);
        }
        .requisitos-texto p { margin-bottom: 16px; }

        /* =========================================
           S4 - CARTÃO NÃO SERVE
        ========================================= */
        .cartao-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            max-width: 900px;
            margin: 0 auto;
        }
        .cartao-item {
            background: var(--branco);
            border-radius: var(--radius);
            padding: 28px;
            box-shadow: var(--sombra);
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }
        .cartao-item i {
            color: #E53E3E;
            font-size: 1.4rem;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .cartao-item p {
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* =========================================
           S5 - TABELA DE VALORES
        ========================================= */
        .valores-table-wrapper {
            overflow-x: auto;
            margin-bottom: 24px;
        }
        .valores-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--branco);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--sombra);
        }
        .valores-table thead {
            background: var(--azul-escuro);
            color: var(--branco);
        }
        .valores-table th {
            padding: 18px 24px;
            font-size: 0.9rem;
            font-weight: 600;
            text-align: left;
        }
        .valores-table td {
            padding: 18px 24px;
            font-size: 0.95rem;
            border-bottom: 1px solid var(--cinza-borda);
        }
        .valores-table tbody tr:hover {
            background: rgba(26, 95, 168, 0.03);
        }
        .valores-table .valor {
            font-weight: 700;
            color: var(--azul-medio);
            font-size: 1.05rem;
        }
        .valores-nota {
            background: rgba(15, 110, 86, 0.08);
            border-left: 4px solid var(--verde);
            padding: 20px 24px;
            border-radius: 0 var(--radius) var(--radius) 0;
            font-size: 0.92rem;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
        }
        .valores-nota strong { color: var(--verde); }

        /* =========================================
           S6 - PROCESSO 3 ETAPAS
        ========================================= */
        .etapas-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }
        .etapa-card {
            text-align: center;
            padding: 40px 28px;
            background: var(--branco);
            border-radius: var(--radius);
            box-shadow: var(--sombra);
            position: relative;
        }
        .etapa-num {
            width: 56px;
            height: 56px;
            background: var(--azul-medio);
            color: var(--branco);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 800;
            margin: 0 auto 20px;
        }
        .etapa-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--azul-escuro);
            margin-bottom: 12px;
        }
        .etapa-card p {
            font-size: 0.92rem;
            line-height: 1.6;
        }

        /* =========================================
           S7 - DEPOIMENTOS
        ========================================= */
        .depoimentos-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }
        .depoimento-card {
            background: var(--branco);
            border-radius: var(--radius);
            padding: 32px;
            box-shadow: var(--sombra);
            display: flex;
            flex-direction: column;
        }
        .depoimento-stars {
            color: #F6AD55;
            margin-bottom: 16px;
            font-size: 1rem;
        }
        .depoimento-texto {
            font-size: 0.92rem;
            line-height: 1.7;
            flex: 1;
            margin-bottom: 20px;
            font-style: italic;
            color: var(--cinza-texto);
        }
        .depoimento-autor {
            border-top: 1px solid var(--cinza-borda);
            padding-top: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .depoimento-foto {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
        .depoimento-autor strong {
            display: block;
            color: var(--azul-escuro);
            font-size: 0.95rem;
        }
        .depoimento-autor span {
            font-size: 0.82rem;
            color: var(--azul-medio);
        }

        /* =========================================
           S8 - FAQ ACCORDION
        ========================================= */
        .faq-list {
            max-width: 800px;
            margin: 0 auto;
        }
        .faq-item {
            border-bottom: 1px solid var(--cinza-borda);
        }
        .faq-question {
            width: 100%;
            background: none;
            border: none;
            padding: 24px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--azul-escuro);
            text-align: left;
            font-family: inherit;
            line-height: 1.4;
        }
        .faq-question i {
            transition: transform 0.3s;
            color: var(--azul-medio);
            flex-shrink: 0;
            margin-left: 16px;
        }
        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }
        .faq-answer-inner {
            padding: 0 0 24px;
            font-size: 0.95rem;
            line-height: 1.7;
            color: var(--cinza-texto);
        }

        /* =========================================
           S9 - CTA FINAL
        ========================================= */
        .cta-final {
            background: linear-gradient(135deg, var(--azul-escuro) 0%, var(--azul-medio) 100%);
            padding: 80px 0;
            text-align: center;
            color: var(--branco);
        }
        .cta-final h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--branco);
        }
        .cta-final .subtitle {
            font-size: 1.15rem;
            opacity: 0.9;
            margin-bottom: 40px;
        }
        .cta-final-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 32px;
        }
        .cta-email-form {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            max-width: 600px;
            margin: 0 auto;
        }
        .cta-email-form input[type="email"],
        .cta-email-form input[type="text"],
        .cta-email-form select {
            padding: 14px 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 10px;
            background: rgba(255,255,255,0.1);
            color: var(--branco);
            font-size: 1rem;
            flex: 1;
            min-width: 180px;
            font-family: inherit;
        }
        .cta-email-form input::placeholder,
        .cta-email-form select {
            color: rgba(255,255,255,0.6);
        }
        .cta-email-form select option {
            color: var(--azul-escuro);
            background: var(--branco);
        }
        .cta-email-form button {
            padding: 14px 28px;
            background: var(--branco);
            color: var(--azul-escuro);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        .cta-email-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* =========================================
           FOOTER
        ========================================= */
        .site-footer {
            background: #0A2D50;
            color: rgba(255,255,255,0.7);
            padding: 40px 0;
            text-align: center;
            font-size: 0.85rem;
        }
        .site-footer a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
        }
        .footer-susep {
            margin-top: 12px;
            font-size: 0.8rem;
            opacity: 0.6;
        }
        .footer-disclaimer {
            margin-top: 8px;
            font-size: 0.75rem;
            opacity: 0.5;
        }

        /* =========================================
           WHATSAPP FLUTUANTE
        ========================================= */
        .whatsapp-float {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            width: 60px;
            height: 60px;
            background: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.8rem;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            transition: all 0.3s;
            text-decoration: none;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 28px rgba(37, 211, 102, 0.6);
        }
        .whatsapp-tooltip {
            position: absolute;
            right: 70px;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            color: var(--azul-escuro);
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        .whatsapp-float:hover .whatsapp-tooltip {
            opacity: 1;
        }

        /* =========================================
           RESPONSIVE
        ========================================= */
        @media (max-width: 768px) {
            .hero { padding: 120px 0 60px; }
            .hero h1, .hero .hero-heading { font-size: 2.2rem; }
            .hero .subtitle { font-size: 1.05rem; }
            .hero-row { flex-direction: column; gap: 32px; }
            .hero-col-image { flex: 0 0 auto; max-width: 100%; }
            .autoridade-grid { grid-template-columns: 1fr; gap: 20px; }
            .requisitos-content { grid-template-columns: 1fr; }
            .cartao-grid { grid-template-columns: 1fr; }
            .etapas-grid { grid-template-columns: 1fr; gap: 20px; }
            .depoimentos-grid { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .nav-toggle { display: block; }
            .nav-links.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 72px;
                left: 0;
                right: 0;
                background: #fff;
                padding: 20px 24px;
                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            }
            .cta-final h2 { font-size: 1.6rem; }
            .section-title { font-size: 1.6rem; }
        }

        /* Animation on scroll */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <?php if (!empty($company->google_analytics)): ?>
    <!-- Google Analytics / GTM -->
    <?= $company->google_analytics ?>
    <?php endif; ?>

    <?php if (!empty($company->facebook_pixel)): ?>
    <!-- Facebook Pixel -->
    <?= $company->facebook_pixel ?>
    <?php endif; ?>
    <!-- Schema JSON-LD: InsuranceAgency + LocalBusiness -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": ["InsuranceAgency", "LocalBusiness"],
        "@id": "<?= base_url() ?>#organization",
        "name": "<?= htmlspecialchars($company->fantasy_name) ?>",
        "url": "<?= base_url('seguro-viagem-fapesp') ?>",
        "logo": "<?= base_url('assets/img/logos/otripulante.png') ?>",
        "image": "<?= base_url('assets/img/bolsista-fapesp-seguro-viagem-og.jpg') ?>",
        "description": "<?= htmlspecialchars($company->meta_description) ?>",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "<?= htmlspecialchars($company->city) ?>",
            "addressRegion": "<?= htmlspecialchars($company->state) ?>",
            "addressCountry": "BR"
        },
        <?php if (!empty($company->phone)): ?>"telephone": "<?= htmlspecialchars($company->phone) ?>",<?php elseif (!empty($configs['telefone_contato'])): ?>"telephone": "<?= htmlspecialchars($configs['telefone_contato']) ?>",<?php endif; ?>
        <?php if (!empty($configs['email_contato'])): ?>"email": "<?= htmlspecialchars($configs['email_contato']) ?>",<?php endif; ?>
        "priceRange": "$$",
        "areaServed": {
            "@type": "Country",
            "name": "BR"
        },
        "knowsAbout": ["Seguro Viagem FAPESP", "Seguro Viagem Bolsista", "BEPE", "BPE", "Seguro Viagem Internacional", "Prestação de Contas FAPESP"],
        "sameAs": [],
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            "opens": "09:00",
            "closes": "18:00"
        }
    }
    </script>

    <!-- Schema JSON-LD: FAQPage -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            <?php foreach ($faq as $i => $f): ?>
            {
                "@type": "Question",
                "name": "<?= htmlspecialchars($f->pergunta) ?>",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "<?= htmlspecialchars($f->resposta) ?>"
                }
            }<?= ($i < count($faq) - 1) ? ',' : '' ?>
            <?php endforeach; ?>
        ]
    }
    </script>

    <?php if (!empty($depoimentos)): ?>
    <!-- Schema JSON-LD: AggregateRating -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "<?= htmlspecialchars($company->fantasy_name) ?>",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "5",
            "reviewCount": "<?= count($depoimentos) ?>",
            "bestRating": "5"
        },
        "review": [
            <?php foreach ($depoimentos as $i => $d): ?>
            {
                "@type": "Review",
                "author": {"@type": "Person", "name": "<?= htmlspecialchars($d->nome) ?>"},
                "reviewRating": {"@type": "Rating", "ratingValue": "<?= $d->nota ?>"},
                "reviewBody": "<?= htmlspecialchars($d->texto) ?>"
            }<?= ($i < count($depoimentos) - 1) ? ',' : '' ?>
            <?php endforeach; ?>
        ]
    }
    </script>
    <?php endif; ?>
</head>
<body>

    <!-- ================================================
         HEADER / NAV
    ================================================ -->
    <header class="site-header" id="header">
        <div class="container">
            <nav class="nav-inner">
                <a href="<?= base_url() ?>" class="nav-logo">
                    <i class="fas fa-plane-departure"></i> Seguro Viagem FAPESP
                </a>
                <button class="nav-toggle" id="navToggle" aria-label="Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="nav-links" id="navLinks">
                    <li><a href="#requisitos">Requisitos</a></li>
                    <li><a href="#seguradoras">Seguradoras</a></li>
                    <li><a href="#valores">Valores 2026</a></li>
                    <li><a href="#processo">Como Funciona</a></li>
                    <li><a href="#depoimentos">Depoimentos</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="<?= $whatsapp_link ?>" target="_blank" rel="noopener noreferrer" class="nav-cta"><i class="fab fa-whatsapp"></i> Falar com Especialista</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ================================================
         S1 - HERO
    ================================================ -->
    <section class="hero" id="hero">
        <div class="container">
            <?php if (!empty($banners) && count($banners) > 1): ?>
            <!-- SLIDER: múltiplos banners -->
            <div class="hero-slider" id="heroSlider">
                <?php foreach ($banners as $i => $banner): ?>
                <div class="hero-slide<?= $i === 0 ? ' active' : '' ?>" data-slide="<?= $i ?>">
                    <div class="hero-row">
                        <div class="hero-col-text">
                            <div class="hero-content fade-up">
                                <?php if ($i === 0): ?>
                                <h1 aria-label="<?= htmlspecialchars($banner->title) ?>">
                                    <?= htmlspecialchars($banner->title) ?>
                                </h1>
                                <?php else: ?>
                                <p class="hero-heading">
                                    <?= htmlspecialchars($banner->title) ?>
                                </p>
                                <?php endif; ?>
                                <p class="subtitle">
                                    <?= nl2br(htmlspecialchars($banner->subtitle)) ?>
                                </p>
                                <div class="hero-buttons">
                                    <a href="<?= !empty($banner->cta_link) ? htmlspecialchars($banner->cta_link) : $whatsapp_link ?>" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp">
                                        <i class="fab fa-whatsapp"></i> <?= !empty($banner->cta_text) ? htmlspecialchars($banner->cta_text) : 'Falar com especialista' ?>
                                    </a>
                                    <a href="<?= !empty($banner->cta_secondary_link) ? htmlspecialchars($banner->cta_secondary_link) : '#requisitos' ?>" class="btn btn-secondary">
                                        <i class="fas fa-clipboard-check"></i> <?= !empty($banner->cta_secondary_text) ? htmlspecialchars($banner->cta_secondary_text) : 'Entender o que a FAPESP exige' ?>
                                    </a>
                                </div>
                                <div class="hero-selos">
                                    <div class="selo"><i class="fas fa-shield-alt"></i> <?= isset($configs['hero_selo_1']) ? htmlspecialchars($configs['hero_selo_1']) : 'Corretor SUSEP' ?></div>
                                    <div class="selo"><i class="fas fa-calendar-check"></i> <?= isset($configs['hero_selo_2']) ? htmlspecialchars($configs['hero_selo_2']) : '+10 anos' ?></div>
                                    <div class="selo"><i class="fas fa-check-circle"></i> <?= isset($configs['hero_selo_3']) ? htmlspecialchars($configs['hero_selo_3']) : '100% aprovação' ?></div>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($banner->image)): ?>
                        <div class="hero-col-image fade-up">
                            <picture>
                                <?php if (!empty($banner->image_mobile)): ?>
                                <source media="(max-width: 768px)" srcset="<?= base_url('userfiles/banners/' . $banner->image_mobile) ?>">
                                <?php endif; ?>
                                <img src="<?= base_url('userfiles/banners/' . $banner->image) ?>" alt="<?= htmlspecialchars($banner->title) ?>" loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
                            </picture>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="hero-dots" id="heroDots">
                <?php foreach ($banners as $i => $b): ?>
                <button type="button" class="<?= $i === 0 ? 'active' : '' ?>" data-goto="<?= $i ?>" aria-label="Slide <?= $i + 1 ?>"></button>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <!-- SINGLE banner ou fallback -->
            <?php $banner = !empty($banners) ? $banners[0] : null; ?>
            <div class="hero-row">
                <div class="hero-col-text">
                    <div class="hero-content fade-up">
                        <h1 aria-label="Seguro Viagem Obrigatório Bolsista FAPESP">
                            <?= $banner ? htmlspecialchars($banner->title) : (isset($configs['hero_titulo']) ? htmlspecialchars($configs['hero_titulo']) : 'Seguro Viagem FAPESP') ?>
                        </h1>
                        <p class="subtitle">
                            <?= $banner ? nl2br(htmlspecialchars($banner->subtitle)) : (isset($configs['hero_subtitulo']) ? nl2br(htmlspecialchars($configs['hero_subtitulo'])) : 'Especialistas no seguro obrigatório para bolsistas FAPESP.<br>Sua apólice correta, do embarque à prestação de contas.') ?>
                        </p>
                        <div class="hero-buttons">
                            <a href="<?= $whatsapp_link ?>" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp">
                                <i class="fab fa-whatsapp"></i> Falar com especialista
                            </a>
                            <a href="#requisitos" class="btn btn-secondary">
                                <i class="fas fa-clipboard-check"></i> Entender o que a FAPESP exige
                            </a>
                        </div>
                        <div class="hero-selos">
                            <div class="selo"><i class="fas fa-shield-alt"></i> <?= isset($configs['hero_selo_1']) ? htmlspecialchars($configs['hero_selo_1']) : 'Corretor SUSEP' ?></div>
                            <div class="selo"><i class="fas fa-calendar-check"></i> <?= isset($configs['hero_selo_2']) ? htmlspecialchars($configs['hero_selo_2']) : '+10 anos' ?></div>
                            <div class="selo"><i class="fas fa-check-circle"></i> <?= isset($configs['hero_selo_3']) ? htmlspecialchars($configs['hero_selo_3']) : '100% aprovação' ?></div>
                        </div>
                    </div>
                </div>
                <?php if ($banner && !empty($banner->image)): ?>
                <div class="hero-col-image fade-up">
                    <picture>
                        <?php if (!empty($banner->image_mobile)): ?>
                        <source media="(max-width: 768px)" srcset="<?= base_url('userfiles/banners/' . $banner->image_mobile) ?>">
                        <?php endif; ?>
                        <img src="<?= base_url('userfiles/banners/' . $banner->image) ?>" alt="<?= htmlspecialchars($banner->title) ?>" loading="eager">
                    </picture>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ================================================
         BARRA DE CREDIBILIDADE — FAPESP · Otripulante · SUSEP
    ================================================ -->
    <div class="credibility-bar">
        <div class="container">
            <div class="credibility-logos fade-up">
                <img src="<?= base_url('assets/img/logos/fapesp-logo.png') ?>" alt="FAPESP - Fundação de Amparo à Pesquisa" title="Seguro para Bolsistas FAPESP" width="1000" height="336" loading="lazy">
                <span class="credibility-sep"></span>
                <img src="<?= base_url('assets/img/logos/otripulante.png') ?>" alt="Otripulante Seguro Viagem" title="Otripulante Seguro Viagem" width="200" height="104" loading="lazy">
                <span class="credibility-sep"></span>
                <img src="<?= base_url('assets/img/logos/susep.png') ?>" alt="SUSEP - Superintendência de Seguros Privados" title="Corretor licenciado SUSEP" width="200" height="90" loading="lazy">
            </div>
        </div>
    </div>

    <!-- ================================================
         S2 - NÚMEROS DE AUTORIDADE
    ================================================ -->
    <section class="section" id="autoridade">
        <div class="container">
            <h2 class="section-title fade-up">Por que confiar na nossa assessoria?</h2>
            <p class="section-desc fade-up">Não somos um comparador automático. Somos corretores licenciados pela SUSEP que conhecem o SAGe, o SCBA e os editais da FAPESP por dentro.</p>

            <?php if (!empty($autoridade)): ?>
            <div class="autoridade-grid">
                <?php foreach ($autoridade as $item): ?>
                <div class="autoridade-card fade-up">
                    <i class="fas <?= htmlspecialchars($item->icone) ?>"></i>
                    <span class="numero"><?= htmlspecialchars($item->numero) ?></span>
                    <span class="label"><?= htmlspecialchars($item->label) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- ================================================
         SEGURADORAS PARCEIRAS DOS BOLSISTAS
    ================================================ -->
    <?php if (!empty($seguradoras)): ?>
    <section class="section section-alt" id="seguradoras">
        <div class="container">
            <h2 class="section-title fade-up">Seguradoras Parceiras dos Bolsistas</h2>
            <p class="section-desc fade-up">Trabalhamos com as principais seguradoras de viagem do Brasil para oferecer a melhor cobertura ao melhor custo dentro do limite FAPESP.</p>

            <div class="seguradoras-grid fade-up">
                <?php foreach ($seguradoras as $seg): ?>
                <a href="<?= !empty($seg->link) ? htmlspecialchars($seg->link) : '#' ?>" target="_blank" rel="noopener noreferrer" class="seguradora-box" title="<?= htmlspecialchars($seg->nome) ?>">
                    <?php if (!empty($seg->image)): ?>
                    <img src="<?= base_url('userfiles/seguradoras/' . $seg->image) ?>" alt="<?= htmlspecialchars($seg->nome) ?>" loading="lazy">
                    <?php else: ?>
                    <span style="font-weight:600;color:var(--azul-escuro);font-size:0.85rem;text-align:center;"><?= htmlspecialchars($seg->nome) ?></span>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================
         S3 - O QUE A FAPESP EXIGE
    ================================================ -->
    <section class="section" id="requisitos">
        <div class="container">
            <h2 class="section-title fade-up"><?= isset($configs['secao3_titulo']) ? htmlspecialchars($configs['secao3_titulo']) : 'O que a FAPESP Realmente Exige do Seu Seguro Viagem' ?></h2>

            <div class="requisitos-content">
                <div class="fade-up">
                    <ul class="checklist">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>VIGÊNCIA</strong>
                                <span>Deve cobrir do dia do embarque até o dia do retorno ao Brasil.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>COBERTURAS ESSENCIAIS</strong>
                                <span>Assistência médica e hospitalar por acidente ou doença. Repatriação sanitária e funerária. Traslado médico.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>DOCUMENTAÇÃO</strong>
                                <span>Apólice em nome do bolsista/pesquisador. Número do processo FAPESP no corpo do documento ou no recibo.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>COMPROVANTE DE PAGAMENTO</strong>
                                <span>Recibo com valor discriminado — por isso seguro gratuito de cartão não serve.</span>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>TRATADO DE SCHENGEN</strong>
                                <span>Para destinos europeus: cobertura mínima de €30.000 em despesas médicas.</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="requisitos-texto fade-up">
                    <?php if (!empty($configs['secao3_texto'])): ?>
                    <?= nl2br($configs['secao3_texto']) ?>
                    <?php else: ?>
                    <p>Para que a FAPESP aprove o reembolso do seguro viagem, a apólice precisa atender <strong>requisitos técnicos específicos</strong> que vão além da simples contratação de um plano qualquer. Muitos bolsistas — especialmente na primeira viagem internacional financiada por agência de fomento — desconhecem essas exigências e acabam tendo o reembolso negado ou solicitações de complementação documental, atrasando a prestação de contas.</p>

                    <p>A <strong>vigência da apólice</strong> é o primeiro ponto crítico: ela deve cobrir integralmente o período desde o dia do embarque até o retorno ao Brasil. Se o bolsista prorrogar a estadia, a apólice deve ser estendida proporcionalmente — caso contrário, o período descoberto será glosado na prestação de contas.</p>

                    <p>As <strong>coberturas obrigatórias</strong> incluem despesas médicas e hospitalares por acidente e doença, repatriação sanitária, repatriação funerária e traslado médico. No Brasil, a Resolução SUSEP nº 315/2014 já estabelece estas como coberturas mínimas obrigatórias do Seguro Viagem, o que garante conformidade automática quando contratado com seguradoras habilitadas pela SUSEP.</p>

                    <p>A <strong>documentação</strong> exige que a apólice esteja em nome do bolsista ou pesquisador responsável, e que contenha — no corpo do documento ou no recibo de pagamento — o <strong>número do processo FAPESP</strong>. Esta é a exigência mais frequentemente descumprida e a principal causa de pendências na prestação de contas.</p>

                    <p>Para destinos na <strong>Europa e países do Espaço Schengen</strong>, há ainda a exigência adicional do <strong>Tratado de Schengen</strong>: cobertura mínima de €30.000 em despesas médicas e hospitalares. As principais seguradoras brasileiras já oferecem planos que atendem esse requisito automaticamente, mas é fundamental verificar antes da contratação.</p>

                    <p>O <strong>comprovante de pagamento</strong> (recibo ou nota fiscal) com valor discriminado é indispensável. É por isso que o seguro gratuito de cartão de crédito não serve para a FAPESP: não gera recibo com valor pago, impossibilitando o reembolso pela agência de fomento.</p>

                    <p>Na Otripulante, <strong>revisamos cada documento antes do envio</strong> para garantir que todas essas exigências sejam cumpridas — desde a primeira contratação até a prestação de contas final. Nosso objetivo é que sua apólice seja aprovada de primeira, sem pendências.</p>

                    <p>Bolsistas das modalidades <strong>BEPE</strong> (Bolsa Estágio de Pesquisa no Exterior), <strong>BPE</strong> (Bolsa Pesquisa no Exterior) e <strong>Reuniões Científicas</strong> têm exigências idênticas quanto ao seguro viagem. A diferença está apenas no tempo de cobertura e no valor máximo de reembolso. Independente da modalidade, todos precisam apresentar a apólice completa na prestação de contas via sistema SAGe, junto com o comprovante de pagamento e a nota fiscal eletrônica ou recibo do corretor.</p>

                    <p>Contar com uma corretora especializada em seguro para bolsistas FAPESP elimina o risco de erros documentais que geram pendências e atrasos no reembolso — algo especialmente crítico para pesquisadores que já estão no exterior e precisam focar em sua pesquisa, não em burocracia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================
         S4 - POR QUE O CARTÃO NÃO SERVE
    ================================================ -->
    <section class="section section-alt" id="cartao">
        <div class="container">
            <h2 class="section-title fade-up"><?= isset($configs['secao4_titulo']) ? htmlspecialchars($configs['secao4_titulo']) : 'Por que o Seguro do Cartão de Crédito NÃO Serve para a FAPESP' ?></h2>
            <p class="section-desc fade-up">Muitos bolsistas acreditam que o seguro do cartão é suficiente. Entenda por que a FAPESP não aceita:</p>

            <div class="cartao-grid">
                <div class="cartao-item fade-up">
                    <i class="fas fa-times-circle"></i>
                    <p>O seguro do cartão é um <strong>benefício gratuito</strong> — a FAPESP exige um recibo com valor discriminado para reembolso.</p>
                </div>
                <div class="cartao-item fade-up">
                    <i class="fas fa-times-circle"></i>
                    <p><strong>Não cobre períodos longos</strong> de permanência no exterior (meses de bolsa).</p>
                </div>
                <div class="cartao-item fade-up">
                    <i class="fas fa-times-circle"></i>
                    <p>Funciona basicamente por <strong>reembolso</strong>, criando transtorno e burocracia para o bolsista.</p>
                </div>
                <div class="cartao-item fade-up">
                    <i class="fas fa-times-circle"></i>
                    <p><strong>Impossível incluir o número do processo FAPESP</strong> — exigência técnica da prestação de contas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================
         S5 - TABELA DE VALORES
    ================================================ -->
    <section class="section" id="valores">
        <div class="container">
            <h2 class="section-title fade-up">Tabela de Valores FAPESP 2026</h2>
            <p class="section-desc fade-up">Valores atualizados de reembolso do seguro viagem por modalidade de bolsa.</p>

            <?php if (!empty($valores)): ?>
            <div class="valores-table-wrapper fade-up">
                <table class="valores-table">
                    <thead>
                        <tr>
                            <th>Modalidade de Bolsa</th>
                            <th><?= htmlspecialchars($valores[0]->valor_atual_label) ?></th>
                            <th><?= htmlspecialchars($valores[0]->valor_anterior_label) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($valores as $v): ?>
                        <tr>
                            <td><?= htmlspecialchars($v->modalidade) ?></td>
                            <td class="valor"><?= htmlspecialchars($v->valor_atual) ?> <?= htmlspecialchars($v->unidade) ?></td>
                            <td><?= htmlspecialchars($v->valor_anterior) ?> <?= htmlspecialchars($v->unidade) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <div class="valores-nota fade-up">
                <strong>Exemplo prático:</strong> <?= isset($configs['exemplo_calculo']) ? htmlspecialchars($configs['exemplo_calculo']) : '' ?>
            </div>
        </div>
    </section>

    <!-- ================================================
         S6 - PROCESSO EM 3 ETAPAS
    ================================================ -->
    <section class="section section-alt" id="processo">
        <div class="container">
            <h2 class="section-title fade-up"><?= isset($configs['secao6_titulo']) ? htmlspecialchars($configs['secao6_titulo']) : 'Nosso Processo em 3 Etapas' ?></h2>
            <p class="section-desc fade-up">Quando você passa mal em Amsterdã às 2h da manhã, você não quer falar com um robô. Você quer falar com alguém que resolve.</p>

            <div class="etapas-grid">
                <div class="etapa-card fade-up">
                    <div class="etapa-num">1</div>
                    <h3><?= isset($configs['secao6_etapa1_titulo']) ? htmlspecialchars($configs['secao6_etapa1_titulo']) : 'Assessoria Pré-Embarque' ?></h3>
                    <p><?= isset($configs['secao6_etapa1_texto']) ? htmlspecialchars($configs['secao6_etapa1_texto']) : 'Escolhemos juntos o plano ideal, garantimos que a apólice tenha as exigências da FAPESP e do destino e revisamos os documentos antes do envio.' ?></p>
                </div>
                <div class="etapa-card fade-up">
                    <div class="etapa-num">2</div>
                    <h3><?= isset($configs['secao6_etapa2_titulo']) ? htmlspecialchars($configs['secao6_etapa2_titulo']) : 'Revisão da Prestação de Contas' ?></h3>
                    <p><?= isset($configs['secao6_etapa2_texto']) ? htmlspecialchars($configs['secao6_etapa2_texto']) : 'Ao voltar, revisamos sua documentação para garantir que o reembolso seja processado sem erros ou pendências.' ?></p>
                </div>
                <div class="etapa-card fade-up">
                    <div class="etapa-num">3</div>
                    <h3><?= isset($configs['secao6_etapa3_titulo']) ? htmlspecialchars($configs['secao6_etapa3_titulo']) : 'Suporte Antes, Durante e Depois' ?></h3>
                    <p><?= isset($configs['secao6_etapa3_texto']) ? htmlspecialchars($configs['secao6_etapa3_texto']) : 'Passou mal? Mala extraviada? Uma central de emergência com atendimento em português estará disponível 24h.' ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================
         S7 - DEPOIMENTOS
    ================================================ -->
    <?php if (!empty($depoimentos)): ?>
    <section class="section" id="depoimentos">
        <div class="container">
            <h2 class="section-title fade-up">O que dizem os bolsistas que confiam em nós</h2>
            <p class="section-desc fade-up">Depoimentos reais de pesquisadores que tiveram suas prestações de contas aprovadas de primeira.</p>

            <div class="depoimentos-grid">
                <?php foreach ($depoimentos as $dep): ?>
                <div class="depoimento-card fade-up">
                    <div class="depoimento-stars">
                        <?php for ($s = 0; $s < $dep->nota; $s++): ?>
                        <i class="fas fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="depoimento-texto">"<?= htmlspecialchars($dep->texto) ?>"</p>
                    <div class="depoimento-autor">
                        <?php if (!empty($dep->image)): ?>
                        <img src="<?= base_url('userfiles/depoimentos/' . $dep->image) ?>" alt="<?= htmlspecialchars($dep->nome) ?>" class="depoimento-foto" loading="lazy">
                        <?php endif; ?>
                        <strong><?= htmlspecialchars($dep->nome) ?></strong>
                        <span>
                            <?= htmlspecialchars($dep->modalidade) ?>
                            <?= !empty($dep->universidade) ? ' — ' . htmlspecialchars($dep->universidade) : '' ?>
                            <?= !empty($dep->pais) ? ', ' . htmlspecialchars($dep->pais) : '' ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================
         S8 - FAQ
    ================================================ -->
    <?php if (!empty($faq)): ?>
    <section class="section section-alt" id="faq">
        <div class="container">
            <h2 class="section-title fade-up">Dúvidas Frequentes dos Bolsistas</h2>
            <p class="section-desc fade-up">Respostas para as perguntas mais comuns sobre o seguro viagem obrigatório da FAPESP.</p>

            <div class="faq-list">
                <?php foreach ($faq as $f): ?>
                <div class="faq-item fade-up">
                    <button class="faq-question" aria-expanded="false">
                        <?= htmlspecialchars($f->pergunta) ?>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <?= nl2br(htmlspecialchars($f->resposta)) ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================================================
         S9 - CTA FINAL
    ================================================ -->
    <section class="cta-final" id="contato">
        <div class="container">
            <h2 class="fade-up"><?= isset($configs['cta_final_titulo']) ? htmlspecialchars($configs['cta_final_titulo']) : 'Sua bolsa foi aprovada. Agora garanta que seu seguro também seja.' ?></h2>
            <p class="subtitle fade-up"><?= isset($configs['cta_final_subtitulo']) ? htmlspecialchars($configs['cta_final_subtitulo']) : 'Você foca na sua pesquisa — nós cuidamos da burocracia.' ?></p>

            <div class="cta-final-buttons fade-up">
                <a href="<?= $whatsapp_link ?>" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp btn-lg">
                    <i class="fab fa-whatsapp"></i> <?= isset($configs['cta_final_botao']) ? htmlspecialchars($configs['cta_final_botao']) : 'Falar com um especialista em Seguro FAPESP' ?>
                </a>
            </div>

            <p class="subtitle fade-up" style="font-size:0.9rem; opacity:0.7; margin-bottom: 20px;">Ou receba orientação gratuita por e-mail:</p>
            <form class="cta-email-form fade-up" id="leadForm">
                <input type="text" name="nome" placeholder="Seu nome" required>
                <input type="email" name="email" placeholder="Seu melhor e-mail" required>
                <select name="modalidade_bolsa">
                    <option value="">Modalidade da bolsa</option>
                    <option value="BEPE - IC">BEPE - Iniciação Científica</option>
                    <option value="BEPE - Mestrado">BEPE - Mestrado</option>
                    <option value="BEPE - Doutorado">BEPE - Doutorado</option>
                    <option value="BEPE - Pós-Doutorado">BEPE - Pós-Doutorado</option>
                    <option value="BPE">BPE - Pesquisa no Exterior</option>
                    <option value="Reunião Científica">Reunião Científica</option>
                    <option value="Outra">Outra</option>
                </select>
                <button type="submit">Quero receber orientação</button>
            </form>
            <p id="leadMsg" style="margin-top:12px; font-size:0.9rem; display:none;"></p>
        </div>
    </section>

    <!-- ================================================
         FOOTER
    ================================================ -->
    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($company->fantasy_name) ?>. Todos os direitos reservados.</p>
            <?php if (!empty($company->susep_registro)): ?>
            <p class="footer-susep">Registro SUSEP: <?= htmlspecialchars($company->susep_registro) ?></p>
            <?php endif; ?>
            <?php if (!empty($configs['telefone_contato']) || !empty($configs['email_contato'])): ?>
            <p class="footer-contato" style="margin-top:8px;font-size:0.85rem;">
                <?php if (!empty($configs['telefone_contato'])): ?>
                <i class="fas fa-phone"></i> <?= htmlspecialchars($configs['telefone_contato']) ?>
                <?php endif; ?>
                <?php if (!empty($configs['telefone_contato']) && !empty($configs['email_contato'])): ?>
                <span style="margin:0 10px;">|</span>
                <?php endif; ?>
                <?php if (!empty($configs['email_contato'])): ?>
                <i class="fas fa-envelope"></i> <a href="mailto:<?= htmlspecialchars($configs['email_contato']) ?>" style="color:rgba(255,255,255,0.8);"><?= htmlspecialchars($configs['email_contato']) ?></a>
                <?php endif; ?>
            </p>
            <?php endif; ?>
            <p class="footer-disclaimer">Este não é um site oficial da FAPESP. Site desenvolvido por <?= htmlspecialchars($company->fantasy_name) ?>.</p>
            <p style="margin-top:8px;font-size:0.75rem;opacity:0.5;"><a href="#" style="color:rgba(255,255,255,0.7);">Política de Privacidade</a></p>
        </div>
    </footer>

    <!-- ================================================
         WHATSAPP FLUTUANTE
    ================================================ -->
    <a href="<?= $whatsapp_link ?>" target="_blank" rel="noopener noreferrer" class="whatsapp-float" aria-label="Falar no WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-tooltip">Falar agora com um consultor especialista em FAPESP</span>
    </a>

    <!-- ================================================
         JAVASCRIPT
    ================================================ -->
    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            document.getElementById('header').classList.toggle('scrolled', window.scrollY > 20);
        });

        // Mobile nav toggle
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });

        // Close mobile nav on link click
        document.querySelectorAll('.nav-links a').forEach(function(link) {
            link.addEventListener('click', function() {
                document.getElementById('navLinks').classList.remove('active');
            });
        });

        // FAQ Accordion
        document.querySelectorAll('.faq-question').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var item = this.parentElement;
                var answer = item.querySelector('.faq-answer');
                var isActive = item.classList.contains('active');

                // Close all
                document.querySelectorAll('.faq-item').forEach(function(fi) {
                    fi.classList.remove('active');
                    fi.querySelector('.faq-answer').style.maxHeight = null;
                    fi.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
                });

                // Open clicked if it was closed
                if (!isActive) {
                    item.classList.add('active');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });

        // Fade-up on scroll (Intersection Observer)
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.fade-up').forEach(function(el) {
            observer.observe(el);
        });

        // Hero Slider
        (function() {
            var slider = document.getElementById('heroSlider');
            var dotsWrap = document.getElementById('heroDots');
            if (!slider || !dotsWrap) return;
            var slides = slider.querySelectorAll('.hero-slide');
            var dots = dotsWrap.querySelectorAll('button');
            var current = 0;
            var total = slides.length;
            var interval = 6000; // 6 seconds
            var timer;

            function goTo(index) {
                slides[current].classList.remove('active');
                dots[current].classList.remove('active');
                current = (index + total) % total;
                slides[current].classList.add('active');
                dots[current].classList.add('active');
            }

            function autoPlay() {
                timer = setInterval(function() { goTo(current + 1); }, interval);
            }

            dots.forEach(function(dot) {
                dot.addEventListener('click', function() {
                    clearInterval(timer);
                    goTo(parseInt(this.dataset.goto));
                    autoPlay();
                });
            });

            autoPlay();
        })();

        // Lead Form (AJAX)
        document.getElementById('leadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var email = this.querySelector('input[name="email"]').value;
            var msg = document.getElementById('leadMsg');

            var nome = this.querySelector('input[name="nome"]').value;
            var modalidade = this.querySelector('select[name="modalidade_bolsa"]').value;

            fetch('<?= base_url('home/lead') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                body: 'nome=' + encodeURIComponent(nome) + '&email=' + encodeURIComponent(email) + '&modalidade_bolsa=' + encodeURIComponent(modalidade)
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                msg.textContent = data.message || 'Obrigado!';
                msg.style.display = 'block';
                msg.style.color = '#fff';
                e.target.reset();
            })
            .catch(function() {
                msg.textContent = 'Erro ao enviar. Tente novamente.';
                msg.style.display = 'block';
                msg.style.color = '#FEB2B2';
            });
        });
    </script>
</body>
</html>
