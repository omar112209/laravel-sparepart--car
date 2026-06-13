<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
<script>(function(){var t=localStorage.getItem('frontend_theme')||'dark';document.documentElement.setAttribute('data-theme',t);})();</script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_mazteach.jpeg') }}">
<title>MaztechGarage</title>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@300;400;500;600&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/slick-theme.css') }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
[data-theme="light"]{--color-dark-base:#FFFFFF;--color-dark-2:#F2F2F5;--color-dark-3:#E5E5EA;--color-steel:#D1D1D6;--color-border:rgba(0,0,0,0.1);--color-border-red:rgba(200,16,46,0.25);--color-text:#1C1C1E;--color-text-2:#636366;--color-text-3:#8E8E93;--color-accent:#C8960E;--color-red-glow:rgba(200,16,46,0.18)}
[data-theme="light"] .glass{background:rgba(255,255,255,0.6);border:1px solid rgba(255,255,255,0.3)}
[data-theme="light"] .product-card:hover{box-shadow:0 16px 48px rgba(0,0,0,0.12)}
*,*::before,*::after{box-sizing:border-box}
body{margin:0;background:var(--color-dark-base);color:var(--color-text);font-family:'Barlow',sans-serif;-webkit-font-smoothing:antialiased}
a{color:inherit;text-decoration:none}
img{max-width:100%;height:auto}
.container{max-width:1200px;margin:0 auto;padding:0 16px}

/* === PROGRESS + CURSOR === */
#scroll-progress{position:fixed;top:0;left:0;width:0;height:2px;background:linear-gradient(90deg,var(--color-red-primary),var(--color-accent));z-index:99999;transition:width .1s linear}
.cursor-dot{position:fixed;pointer-events:none;z-index:99999;width:6px;height:6px;background:var(--color-red-primary);border-radius:50%;transform:translate(-50%,-50%);transition:width .2s,height .2s,background .2s;mix-blend-mode:difference}
.cursor-ring{position:fixed;pointer-events:none;z-index:99998;width:32px;height:32px;border:1.5px solid var(--color-red-primary);border-radius:50%;transform:translate(-50%,-50%);transition:width .4s cubic-bezier(.22,.68,0,1),height .4s cubic-bezier(.22,.68,0,1),border-color .3s,opacity .3s;opacity:.6}
.cursor-ring.hover{width:56px;height:56px;border-color:var(--color-accent);opacity:.3}
.cursor-ring.hide{opacity:0}
@media(pointer:coarse){.cursor-dot,.cursor-ring{display:none}}

/* === BG ORBS === */
.blur-orb{position:fixed;border-radius:50%;pointer-events:none;z-index:0;filter:blur(80px);opacity:.25;will-change:transform}
.blur-orb:nth-child(1){width:400px;height:400px;background:rgba(200,16,46,.3);top:-100px;left:-100px;animation:orbFloat1 16s ease-in-out infinite}
.blur-orb:nth-child(2){width:350px;height:350px;background:rgba(232,184,75,.2);bottom:-80px;right:-80px;animation:orbFloat2 20s ease-in-out infinite}
.blur-orb:nth-child(3){width:300px;height:300px;background:rgba(200,16,46,.15);top:50%;left:50%;animation:orbFloat3 18s ease-in-out infinite}
@keyframes orbFloat1{0%,100%{transform:translate(0,0)scale(1)}33%{transform:translate(200px,150px)scale(1.1)}66%{transform:translate(100px,300px)scale(.9)}}
@keyframes orbFloat2{0%,100%{transform:translate(0,0)scale(1)}33%{transform:translate(-150px,-100px)scale(1.15)}66%{transform:translate(-250px,-50px)scale(.85)}}
@keyframes orbFloat3{0%,100%{transform:translate(-50%,-50%)scale(1)}33%{transform:translate(-30%,-60%)scale(1.2)}66%{transform:translate(-60%,-40%)scale(.8)}}

/* === TOP HEADER === */
.top-header{background:var(--color-red-primary);padding:7px 0;position:relative;overflow:hidden}
.top-header::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(-45deg,transparent,transparent 10px,rgba(0,0,0,.06) 10px,rgba(0,0,0,.06) 20px)}
.top-header .container{display:flex;align-items:center;justify-content:space-between;position:relative}
.top-header-text{font-family:var(--font-mono);font-size:11px;letter-spacing:1.5px;color:rgba(255,255,255,.95);text-transform:uppercase}
.top-header-info{display:none;gap:20px}
@media(min-width:768px){.top-header-info{display:flex}}
.top-header-info span{display:flex;align-items:center;gap:6px;font-size:11px;color:rgba(255,255,255,.85);font-family:var(--font-mono);letter-spacing:.5px}

/* === MAIN HEADER === */
.main-header{position:sticky;top:0;z-index:999;background:var(--color-dark-2);border-bottom:1px solid var(--color-border);box-shadow:0 4px 40px rgba(0,0,0,.5)}
.header-inner{display:flex;align-items:center;justify-content:space-between;height:70px}
.header-logo{display:flex;align-items:center;gap:12px}
.header-logo img{width:46px;height:46px;border-radius:8px;object-fit:cover;border:1px solid var(--color-border)}
.header-logo-text{font-family:var(--font-display);font-size:22px;font-weight:800;letter-spacing:4px;color:var(--color-text);line-height:1;text-transform:uppercase}
.header-logo-text span{color:var(--color-red-primary)}
.header-logo-sub{font-family:var(--font-mono);font-size:8px;letter-spacing:3px;color:var(--color-text-3);text-transform:uppercase}
.header-search{display:none;align-items:center;background:var(--color-dark-3);border:1px solid var(--color-border);border-radius:6px;overflow:hidden;width:320px}
.header-search input{flex:1;background:transparent;border:none;outline:none;padding:10px 14px;font-size:13px;color:var(--color-text);font-family:var(--font-body)}
.header-search button{padding:0 16px;height:40px;background:var(--color-red-primary);color:#fff;cursor:pointer;border:none;display:flex;align-items:center;justify-content:center}
@media(min-width:1024px){.header-search{display:flex}}
.header-actions{display:flex;align-items:center;gap:4px;margin:0;padding:0;list-style:none}
.header-actions a,.user-trigger{display:flex;flex-direction:column;align-items:center;padding:8px 14px;border-radius:6px;color:var(--color-text-2);cursor:pointer;transition:background .2s,color .2s}
.header-actions a:hover,.user-trigger:hover{color:var(--color-text)}
.header-actions a i,.user-trigger i{font-size:18px}
.header-actions a strong,.user-trigger strong{font-family:var(--font-mono);font-size:10px;letter-spacing:1px;font-weight:500;text-transform:uppercase;margin-top:2px}
.user-dropdown{position:relative}
.user-dropdown:hover .dropdown-menu{display:block}
.dropdown-menu{display:none;position:absolute;top:100%;right:0;margin-top:8px;min-width:180px;padding:8px;border-radius:10px;list-style:none;background:var(--color-dark-3);border:1px solid var(--color-border);box-shadow:0 20px 60px rgba(0,0,0,.4);z-index:100}
.dropdown-menu li a{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:6px;font-size:13px;color:var(--color-text-2);transition:background .2s}
.dropdown-menu li a:hover{background:var(--color-steel);color:var(--color-text)}
.dropdown-menu li a i{width:14px;text-align:center;font-size:12px;color:var(--color-red-primary)}
.mobile-toggle-wrap{display:block}
@media(min-width:1024px){.mobile-toggle-wrap{display:none}}
#mobile-toggle{width:38px;height:38px;display:flex;align-items:center;justify-content:center;border-radius:6px;cursor:pointer;background:var(--color-dark-3);border:1px solid var(--color-border);color:var(--color-text);transition:all .2s}
#mobile-toggle:hover{background:var(--color-red-primary);border-color:var(--color-red-primary);color:#fff}

/* === NAV === */
.main-nav{display:none;background:var(--color-dark-3);border-bottom:1px solid var(--color-border)}
@media(min-width:1024px){.main-nav{display:block}}
.nav-inner{display:flex;align-items:stretch;height:48px}
.category-dropdown{position:relative;flex-shrink:0}
.cat-trigger{display:flex;align-items:center;gap:8px;padding:0 20px;height:48px;cursor:pointer;background:var(--color-red-primary);color:#fff;font-family:var(--font-display);font-size:14px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;white-space:nowrap;user-select:none}
.cat-list{display:none;position:absolute;top:100%;left:0;min-width:220px;padding:8px;list-style:none;z-index:200;background:var(--color-dark-2);border:1px solid var(--color-border);border-top:2px solid var(--color-red-primary);border-radius:0 0 10px 10px;box-shadow:0 20px 60px rgba(0,0,0,.4)}
.category-dropdown:hover .cat-list{display:block}
.category-dropdown.show-on-click:hover .cat-list{display:none}
.category-dropdown.show-on-click.open .cat-list{display:block}
.cat-list li a{display:flex;align-items:center;gap:10px;padding:8px 14px;border-radius:6px;font-size:13px;color:var(--color-text-2);transition:background .2s}
.cat-list li a:hover{background:var(--color-steel);color:var(--color-text)}
.cat-list li a span{color:var(--color-red-primary)}
.nav-links{display:flex;align-items:center;flex:1}
.nav-links a{display:flex;align-items:center;padding:0 16px;height:48px;font-family:var(--font-display);font-size:14px;font-weight:600;letter-spacing:1px;text-transform:uppercase;border-bottom:2px solid transparent;color:var(--color-text-2);transition:all .2s}
.nav-links a:hover,.nav-links a.active{color:var(--color-text);border-bottom-color:var(--color-red-primary)}
.promo-badge{display:flex;align-items:center;gap:6px;margin-left:auto;font-family:var(--font-mono);font-size:10px;color:var(--color-text-3)}
.promo-dot{width:6px;height:6px;border-radius:50%;background:var(--color-accent);animation:blink 2s infinite}

/* === MOBILE NAV === */
.mobile-nav{display:none;overflow:hidden;transition:max-height .3s}
@media(max-width:1023px){.mobile-nav{display:block}}
.mobile-nav[style*="max-height: 0"]{display:block}
.mobile-nav{background:var(--color-dark-2);border-bottom:1px solid var(--color-border)}
.mobile-search{display:flex;padding:12px;gap:8px;border-bottom:1px solid var(--color-border)}
.mobile-search input{flex:1;padding:8px 12px;border-radius:6px;font-size:13px;background:transparent;border:1px solid var(--color-border);color:var(--color-text);outline:none}
.mobile-search button{padding:8px 16px;border-radius:6px;background:var(--color-red-primary);color:#fff;border:none;cursor:pointer}
.mobile-nav a{display:block;padding:12px 20px;font-size:13px;color:var(--color-text-2);border-bottom:1px solid var(--color-border);transition:color .2s}
.mobile-nav a:hover{color:var(--color-text)}

/* === HERO === */
.hero-section{position:relative;overflow:hidden}
#home-slick,.hero-slider-wrap{position:relative;z-index:2}
#home-slick{overflow:hidden}
.particle-canvas{position:absolute;inset:0;width:100%;height:100%;pointer-events:none;z-index:0}
.hero-slide{position:relative;overflow:hidden;height:320px}
@media(min-width:768px){.hero-slide{height:480px}}
.hero-slide img{width:100%;height:100%;object-fit:cover;filter:brightness(.35)saturate(.7)}
.hero-content{position:absolute;inset:0;display:flex;flex-direction:column;justify-content:center;padding:0 8%;z-index:2}
.hero-eyebrow{font-family:var(--font-mono);font-size:11px;letter-spacing:4px;text-transform:uppercase;margin-bottom:16px;color:var(--color-red-primary)}
.hero-title{font-family:var(--font-display);font-size:clamp(48px,7vw,88px);font-weight:800;line-height:.9;letter-spacing:2px;margin:0 0 20px;text-transform:uppercase;color:var(--color-text)}
.hero-title span{color:var(--color-red-primary)}
.hero-desc{font-size:16px;font-weight:300;letter-spacing:1px;margin:0 0 32px;color:var(--color-text-2)}
.hero-actions{display:flex;gap:12px}

/* === TRUST BAR === */
.trust-bar{animation:slideUp .5s ease .2s both;background:var(--color-dark-3);border-top:1px solid var(--color-border);border-bottom:1px solid var(--color-border)}
.trust-grid{display:flex;flex-wrap:wrap}
.trust-item{flex:1;display:flex;align-items:center;gap:14px;padding:18px 24px;min-width:50%;border-right:1px solid var(--color-border)}
@media(min-width:768px){.trust-item{min-width:0}}
.trust-item:last-child{border-right:none}
.trust-icon{width:40px;height:40px;flex-shrink:0;display:flex;align-items:center;justify-content:center;border-radius:10px;font-size:16px;background:var(--color-red-glow);border:1px solid var(--color-border-red);color:var(--color-red-primary)}
.trust-item strong{display:block;font-family:var(--font-display);font-size:14px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--color-text)}
.trust-item span{font-size:11px;color:var(--color-text-3)}

/* === MAIN SECTION === */
.main-section{padding:40px 0;position:relative;z-index:1}
.main-grid{display:flex;flex-wrap:wrap;margin:0 -10px}
.sidebar{width:100%;padding:0 10px}
@media(min-width:1024px){.sidebar{width:25%}}
.main-content{width:100%;padding:0 10px}
@media(min-width:1024px){.main-content{width:75%}}
.sidebar-product{display:flex;align-items:center;gap:12px;padding:14px 16px;border-bottom:1px solid var(--color-border);transition:background .2s}
.sidebar-product:last-child{border-bottom:none}
.sidebar-product:hover{background:var(--color-steel)}
.sidebar-product-img{width:64px;height:64px;flex-shrink:0;border-radius:6px;overflow:hidden;background:var(--color-dark-2);border:1px solid var(--color-border)}
.sidebar-product-img img{width:100%;height:100%;object-fit:cover;filter:saturate(.8)}
.sidebar-product h4{font-size:13px;font-weight:500;margin:0 0 4px;color:var(--color-text)}
.sidebar-product h4 a{color:inherit}
.sidebar-product-price{font-family:var(--font-display);font-size:15px;font-weight:700;color:var(--color-red-primary)}

/* === PROMO CARD === */
.promo-card{border-radius:10px;overflow:hidden;margin-bottom:20px;border:1px solid var(--color-border-red)}
.promo-inner{padding:24px 20px;text-align:center;background:linear-gradient(135deg,var(--color-dark-2),var(--color-dark-3))}
.promo-eyebrow{font-family:var(--font-mono);font-size:9px;letter-spacing:2px;color:var(--color-red-primary);margin-bottom:8px;display:block}
.promo-title{font-family:var(--font-display);font-size:36px;font-weight:800;line-height:1.1;color:var(--color-text)}
.promo-title span{color:var(--color-red-primary)}
.promo-text{font-size:12px;color:var(--color-text-3);margin:10px 0 16px}
.promo-text strong{color:var(--color-accent);font-family:var(--font-mono)}

/* === SHARED COMPONENTS === */
.page-title{display:flex;align-items:baseline;gap:14px;margin-bottom:28px}
.page-title h3{font-family:var(--font-display);font-size:24px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--color-text);margin:0}
.page-title h3 span{color:var(--color-red-primary)}
.page-title .divider{flex:1;height:1px;background:linear-gradient(90deg,var(--color-border),transparent)}
.page-title .label{font-family:var(--font-mono);font-size:9px;letter-spacing:2px;color:var(--color-text-3)}
.card{background:var(--color-dark-3);border:1px solid var(--color-border);border-radius:12px;overflow:hidden}
.card-section{background:var(--color-dark-3);border:1px solid var(--color-border);border-radius:12px;padding:20px}
.card-header{display:flex;align-items:center;gap:8px;padding:14px 20px;font-family:var(--font-mono);font-size:9px;letter-spacing:2px;text-transform:uppercase;color:var(--color-text-3);background:var(--color-steel);border-bottom:1px solid var(--color-border)}
.card-header .dot{width:3px;height:12px;border-radius:2px;background:var(--color-red-primary);display:inline-block}
.input-field{width:100%;padding:13px 16px;background:var(--color-dark-2);border:1.5px solid var(--color-border);border-radius:12px;color:var(--color-text);font-size:14px;outline:none;transition:all .25s}
.input-field:focus{border-color:var(--color-red-primary);box-shadow:0 0 0 4px rgba(200,16,46,.08)}
.input-field::placeholder{color:var(--color-text-3);font-size:13px}
.input-label{display:block;font-family:var(--font-mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:8px;color:var(--color-text-3)}
.badge-status{display:inline-flex;align-items:center;gap:6px;padding:4px 14px;border-radius:20px;font-family:var(--font-mono);font-size:10px;letter-spacing:1.5px;text-transform:uppercase;font-weight:500;border:1px solid}
.alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:12px;margin-bottom:20px;font-size:13px;animation:fadeUp .4s ease both}
.alert-error{background:rgba(200,16,46,.08);border:1px solid rgba(200,16,46,.2);color:#f87171}
.alert-success{background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);color:#4ade80}
.empty-state{display:flex;align-items:center;gap:16px;padding:24px 20px;border-radius:12px;background:var(--color-dark-3);border:1px solid var(--color-border);color:var(--color-text-2);transition:border-color .3s}
.empty-state:hover{border-color:var(--color-border-red)}
.empty-state i{font-size:20px;color:var(--color-text-3)}
.empty-state strong{display:block;font-size:14px;color:var(--color-text)}
.empty-state span{font-size:13px;color:var(--color-text-3)}
.mb-5{margin-bottom:20px}
.hidden{display:none!important}

/* === FOOTER === */
.site-footer{background:var(--color-dark-2);border-top:1px solid var(--color-border)}
.footer-grid{display:flex;flex-wrap:wrap;padding:48px 16px 32px;gap:0}
.footer-col{width:100%;padding:0 16px;margin-bottom:32px}
@media(min-width:640px){.footer-col{width:50%}}
@media(min-width:1024px){.footer-col{width:20%}}
.footer-brand{font-family:var(--font-display);font-size:20px;font-weight:800;letter-spacing:3px;color:var(--color-text);margin-bottom:4px}
.footer-brand span{color:var(--color-red-primary)}
.footer-brand-sub{font-family:var(--font-mono);font-size:9px;letter-spacing:2px;color:var(--color-text-3);text-transform:uppercase;margin-bottom:16px}
.footer-col p{font-size:13px;line-height:1.6;color:var(--color-text-3);max-width:240px;margin:0 0 20px}
.footer-contact{display:flex;align-items:center;gap:10px;font-size:13px;color:var(--color-text-3);margin-bottom:10px}
.footer-contact i{width:16px;text-align:center;color:var(--color-red-primary)}
.footer-social{display:flex;gap:8px;margin-top:16px}
.footer-social a{width:34px;height:34px;display:flex;align-items:center;justify-content:center;border-radius:6px;background:var(--color-dark-3);border:1px solid var(--color-border);color:var(--color-text-3);transition:all .2s}
.footer-social a:hover{background:var(--color-red-primary);border-color:var(--color-red-primary);color:#fff}
.footer-col h3{display:flex;align-items:center;gap:8px;margin:0 0 18px;padding-bottom:10px;font-family:var(--font-display);font-size:14px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--color-text);border-bottom:1px solid var(--color-border)}
.footer-col h3::before{content:'';width:3px;height:14px;border-radius:2px;background:var(--color-red-primary)}
.footer-col ul{list-style:none;padding:0;margin:0}
.footer-col ul li a{display:block;padding:7px 0;font-size:13px;color:var(--color-text-2);transition:color .2s}
.footer-col ul li a:hover{color:var(--color-text)}
.newsletter-form{display:flex;border-radius:6px;overflow:hidden;border:1px solid var(--color-border);margin-bottom:20px}
.newsletter-form input{flex:1;padding:10px 14px;font-size:12px;outline:none;background:transparent;border:none;color:var(--color-text)}
.newsletter-form button{padding:0 16px;background:var(--color-red-primary);color:#fff;font-family:var(--font-display);font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;cursor:pointer;border:none;white-space:nowrap}
.payment-label{font-family:var(--font-mono);font-size:9px;letter-spacing:2px;color:var(--color-text-3);text-transform:uppercase;margin-bottom:10px}
.payment-badges{display:flex;flex-wrap:wrap;gap:6px}
.payment-badges span{padding:4px 10px;border-radius:4px;font-family:var(--font-mono);font-size:9px;letter-spacing:1px;text-transform:uppercase;background:var(--color-dark-3);border:1px solid var(--color-border);color:var(--color-text-3)}
.footer-bottom{border-top:1px solid var(--color-border);padding:16px 0;background:var(--color-dark-base)}
.footer-bottom-inner{display:flex;align-items:center;justify-content:space-between}
.footer-bottom-inner span{font-family:var(--font-mono);font-size:11px;color:var(--color-text-3)}
.secured-text{font-family:var(--font-mono);font-size:9px;color:var(--color-text-3);letter-spacing:1px;margin-right:8px}
.secured-badge{padding:4px 10px;border-radius:4px;font-family:var(--font-mono);font-size:9px;letter-spacing:1px;text-transform:uppercase;background:var(--color-dark-3);border:1px solid var(--color-border);color:var(--color-text-3)}
</style>
</head>
<body class="min-h-screen">

{{-- LOADING OVERLAY --}}
<div id="loading-overlay" class="loading-overlay">
    <img src="{{ asset('image/icon_mazteach.jpeg') }}" alt="" class="loading-logo">
    <div class="loading-spinner-ring"></div>
    <div class="loading-text">Memuat</div>
    <div class="loading-dots"><span></span><span></span><span></span></div>
</div>

<div id="scroll-progress"></div>
<div class="cursor-dot"></div>
<div class="cursor-ring"></div>
<div class="blur-orb"></div>
<div class="blur-orb"></div>
<div class="blur-orb"></div>

{{-- TOP HEADER --}}
<div class="top-header">
    <div class="container">
        <span class="top-header-text">MaztechGarage &amp; Aftermarket Terlengkap</span>
        <div class="top-header-info">
            <span><i class="fa fa-truck"></i> Free Ongkir</span>
            <span><i class="fa fa-check-circle"></i> Garansi Ori</span>
            <span><i class="fa fa-phone"></i> 082325228161</span>
        </div>
    </div>
</div>

{{-- HEADER --}}
<header class="main-header">
    <div class="container header-inner">
        <a class="header-logo" href="#">
            <img src="{{ asset('image/icon_mazteach.jpeg') }}" alt="Logo">
            <div>
                <span class="header-logo-text">Maztech<span>Garage</span></span>
                <span class="header-logo-sub">Sparepart</span>
            </div>
        </a>

        <form action="{{ route('produk.search') }}" method="GET" class="header-search">
            <input type="text" name="q" placeholder="Cari produk..." value="{{ request('q') }}" autocomplete="off">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>

        <ul class="header-actions">
            <li><a href="javascript:void(0)" onclick="toggleFrontendTheme()" title="Ganti tema"><i class="fa fa-moon-o" id="theme-icon-frontend"></i><strong id="theme-label-frontend">Gelap</strong></a></li>
            <li><a href="{{ route('order.cart') }}"><i class="fa fa-shopping-cart"></i><strong>Keranjang</strong></a></li>
            @if (Auth::check())
            <li class="user-dropdown">
                <div class="user-trigger"><i class="fa fa-user-o"></i><strong>{{ Auth::user()->nama }} <i class="fa fa-caret-down"></i></strong></div>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('customer.akun',['id'=>Auth::user()->id]) }}"><i class="fa fa-user-o"></i> Akun Saya</a></li>
                    <li><a href="{{ route('order.history') }}"><i class="fa fa-list-alt"></i> Riwayat Pesanan</a></li>
                    <li><a href="{{ route('order.retur.index') }}"><i class="fa fa-undo"></i> Retur Barang</a></li>
                    <li><a href="#" onclick="event.preventDefault();document.getElementById('keluar-app').submit();"><i class="fa fa-power-off"></i> Keluar</a><form id="keluar-app" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form></li>
                </ul>
            </li>
            @else
            <li class="user-dropdown">
                <div class="user-trigger"><i class="fa fa-user-o"></i><strong>Akun Saya <i class="fa fa-caret-down"></i></strong></div>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('customer.login') }}"><i class="fa fa-sign-in"></i> Login</a></li>
                </ul>
            </li>
            @endif
            <li class="mobile-toggle-wrap">
                <button id="mobile-toggle"><i class="fa fa-bars"></i></button>
            </li>
        </ul>
    </div>
</header>

{{-- NAV --}}
<nav class="main-nav">
    <div class="container nav-inner" id="responsive-nav">
        @php $kategori = DB::table('kategori')->orderBy('nama_kategori','asc')->get(); @endphp
        @php $isBeranda = request()->segment(1)==''||request()->segment(1)=='beranda'; @endphp
        <div class="category-dropdown {{ $isBeranda ? '' : 'show-on-click' }}">
            <span class="cat-trigger"><i class="fa fa-th-large"></i> Semua Kategori</span>
            <ul class="cat-list">
                @foreach ($kategori as $row)
                <li><a href="{{ route('produk.kategori',$row->id) }}"><span>›</span> {{ $row->nama_kategori }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="nav-links">
            <a href="{{ route('beranda') }}" class="{{ request()->segment(1)==''||request()->segment(1)=='beranda' ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('produk.all') }}" class="{{ request()->segment(1)=='produk' ? 'active' : '' }}">Katalog</a>
            <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Raya+Duta+Pelni+No.57+Tugu+Cimanggis+Depok" target="_blank">Lokasi Toko</a>
            <a href="https://wa.me/6282325228161" target="_blank">Hubungi Kami</a>
            <span class="promo-badge"><span class="promo-dot"></span> PROMO GANTI OLI GRATIS FILTER</span>
        </div>
    </div>
</nav>

{{-- MOBILE NAV --}}
<div class="mobile-nav" id="mobile-nav">
    <form action="{{ route('produk.search') }}" method="GET" class="mobile-search">
        <input type="text" name="q" placeholder="Cari produk..." value="{{ request('q') }}" autocomplete="off">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
    <a href="{{ route('beranda') }}">Beranda</a>
    <a href="{{ route('produk.all') }}">Katalog</a>
    <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Raya+Duta+Pelni+No.57+Tugu+Cimanggis+Depok" target="_blank">Lokasi Toko</a>
    <a href="https://wa.me/6282325228161" target="_blank">Hubungi Kami</a>
</div>

{{-- BANNER + TRUST (beranda only) --}}
@if ($isBeranda)
<section id="home" class="hero-section">
    <div class="hero-slider-wrap">
        <canvas id="particle-canvas" class="particle-canvas"></canvas>
        <div id="home-slick">
            <div class="hero-slide">
                <img src="{{ asset('frontend/banner/banner01.jpg') }}" alt="">
                <div class="hero-content">
                    <span class="hero-eyebrow">// Part Original &amp; Aftermarket</span>
                    <h1 class="hero-title">Suku Cadang<br><span>Mazda</span><br>Terlengkap</h1>
                    <p class="hero-desc">Original Equipment Manufacturer · Bergaransi Resmi</p>
                    <div class="hero-actions"><a href="{{ route('produk.all') }}" class="btn-primary"><i class="fa fa-bolt"></i> Belanja Sekarang</a></div>
                </div>
            </div>
            <div class="hero-slide">
                <img src="{{ asset('frontend/banner/banner02.jpg') }}" alt="">
                <div class="hero-content">
                    <span class="hero-eyebrow">// Rem &amp; Suspensi</span>
                    <h1 class="hero-title">Rem &amp;<br><span>Suspensi</span><br>Berkualitas</h1>
                    <p class="hero-desc">Keamanan Berkendara Adalah Prioritas Kami</p>
                    <div class="hero-actions"><a href="{{ route('produk.all') }}" class="btn-primary"><i class="fa fa-bolt"></i> Lihat Produk</a></div>
                </div>
            </div>
            <div class="hero-slide">
                <img src="{{ asset('frontend/banner/banner03.png') }}" alt="">
                <div class="hero-content">
                    <span class="hero-eyebrow">// Pengiriman Cepat 24 Jam</span>
                    <h1 class="hero-title">Kirim ke<br><span>Seluruh</span><br>Indonesia</h1>
                    <p class="hero-desc">Free Ongkir · Packing Aman · Tiba Tepat Waktu</p>
                    <div class="hero-actions"><a href="{{ route('produk.all') }}" class="btn-primary"><i class="fa fa-bolt"></i> Order Sekarang</a></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="trust-bar reveal">
    <div class="container trust-grid">
        <div class="trust-item"><div class="trust-icon"><i class="fa fa-certificate"></i></div><div><strong>Part Bergaransi</strong><span>Garansi original 6–12 bulan</span></div></div>
        <div class="trust-item"><div class="trust-icon"><i class="fa fa-truck"></i></div><div><strong>Pengiriman 24 Jam</strong><span>Free ongkir</span></div></div>
        <div class="trust-item"><div class="trust-icon"><i class="fa fa-lock"></i></div><div><strong>Pembayaran Aman</strong><span>Transfer, QRIS, COD</span></div></div>
        <div class="trust-item"><div class="trust-icon"><i class="fa fa-undo"></i></div><div><strong>Retur 7 Hari</strong><span>Part tidak sesuai? Kami ganti</span></div></div>
    </div>
</section>
@endif

{{-- MAIN --}}
<main class="main-section">
    <div class="container">
        <div class="main-grid">
            <aside class="sidebar">
                <div class="card mb-5">
                    <h3 class="card-header"><span class="dot"></span> Produk Terlaris</h3>
                    @php $produkTerlaris = DB::table('produk')->orderBy('id','desc')->limit(4)->get(); @endphp
                    @forelse ($produkTerlaris as $p)
                    <div class="sidebar-product">
                        <div class="sidebar-product-img">
                            <a href="{{ route('produk.detail',$p->id) }}"><div class="img-skeleton w-full h-full"><img src="{{ asset('storage/img-produk/thumb_sm_'.$p->foto) }}" alt="" class="w-full h-full object-cover img-lazy" loading="lazy" onerror="this.src='{{ asset('frontend/img/no-image.jpg') }}'"></div></a>
                        </div>
                        <div>
                            <h4><a href="{{ route('produk.detail',$p->id) }}">{{ $p->nama_produk }}</a></h4>
                            <span class="sidebar-product-price">Rp {{ number_format($p->harga,0,',','.') }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-[12px]" style="color:var(--color-text-3);">Belum ada produk</div>
                    @endforelse
                </div>

                <div class="promo-card">
                    <div class="promo-inner">
                        <span class="promo-eyebrow">// PROMO SPESIAL</span>
                        <div class="promo-title">DISKON<br><span>20%</span></div>
                        <p class="promo-text">Untuk pembelian pertama<br>dengan kode: <strong>MAZDA20</strong></p>
                        <a href="{{ route('produk.all') }}" class="btn-primary btn-block">Klaim Sekarang</a>
                    </div>
                </div>
            </aside>
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>
</main>

{{-- FOOTER --}}
<footer class="site-footer">
    <div class="container footer-grid reveal">
        <div class="footer-col">
            <div class="footer-brand">MAZTECH<span>GARAGE</span></div>
            <div class="footer-brand-sub">Sparepart</div>
            <p>Distributor sparepart Mazda terpercaya. Melayani seluruh Indonesia dengan part original dan aftermarket berkualitas.</p>
            <div class="footer-contact"><i class="fa fa-map-marker"></i> Jl. Raya Duta Pelni No.57, Tugu, Kec. Cimanggis, Kota Depok, Jawa Barat 16451</div>
            <div class="footer-contact"><i class="fa fa-phone"></i> 082325228161</div>
            <div class="footer-contact"><i class="fa fa-envelope-o"></i> parts@mazdastore.id</div>
            <div class="footer-social">
                <a href="https://www.instagram.com/maztechgarage?igsh=cGM0dDRuaTJyaXYy"><i class="fa fa-instagram"></i></a>
                <a href="https://wa.me/6282325228161"><i class="fa fa-whatsapp"></i></a>
                <a href="https://www.tiktok.com/@maztech_garage2?_r=1&_t=ZS-96876K6peH2" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.75a4.85 4.85 0 0 1-1.01-.06z"/></svg>
                </a>
            </div>
        </div>
        <div class="footer-col">
            <h3>Akun Saya</h3>
            <ul>
                @if (Auth::check())
                <li><a href="{{ route('customer.akun',['id'=>Auth::user()->id]) }}">Profil Saya</a></li>
                <li><a href="{{ route('order.cart') }}">Keranjang</a></li>
                <li><a href="{{ route('order.history') }}">Riwayat Pesanan</a></li>
                <li><a href="#" onclick="event.preventDefault();document.getElementById('keluar-footer').submit();">Keluar</a><form id="keluar-footer" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form></li>
                @else
                <li><a href="{{ route('auth.redirect') }}">Login</a></li>
                <li><a href="{{ route('order.cart') }}">Keranjang</a></li>
                @endif
            </ul>
        </div>
        <div class="footer-col">
            <h3>Layanan</h3>
            <ul>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Kategori Part</h3>
            <ul>
                <li><a href="#">Mesin</a></li>
                <li><a href="#">Rem</a></li>
                <li><a href="#">Kelistrikan</a></li>
                <li><a href="#">Suspensi &amp; Fluida</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h3>Newsletter</h3>
            <p>Dapatkan info promo dan tips perawatan Mazda di inbox Anda.</p>
            <div class="newsletter-form">
                <input type="email" placeholder="Masukkan email Anda...">
                <button>Daftar</button>
            </div>
            <div class="payment-methods">
                <div class="payment-label">Metode Pembayaran</div>
                <div class="payment-badges">
                    <span>BCA</span><span>Mandiri</span><span>BNI</span><span>QRIS</span><span>COD</span>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <span>&copy; <script>document.write(new Date().getFullYear())</script> MaztechGarage — All rights reserved.</span>
            <div><span class="secured-text">SECURED BY</span><span class="secured-badge">BSI</span></div>
        </div>
    </div>
</footer>

<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/slick.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
(function(){
    var c=document.getElementById('particle-canvas');
    if(c&&typeof THREE!=='undefined'){
        var s=new THREE.Scene(),a=new THREE.PerspectiveCamera(75,c.parentElement.offsetWidth/c.parentElement.offsetHeight,0.1,1e3),
        r=new THREE.WebGLRenderer({canvas:c,alpha:true,antialias:true});
        r.setSize(c.parentElement.offsetWidth,c.parentElement.offsetHeight);
        r.setPixelRatio(Math.min(window.devicePixelRatio,2));
        var g=new THREE.BufferGeometry(),n=120,p=new Float32Array(n*3),d=[];
        for(var i=0;i<n;i++){p[i*3]=(Math.random()-0.5)*60;p[i*3+1]=(Math.random()-0.5)*30;p[i*3+2]=(Math.random()-0.5)*30-10;d.push({x:(Math.random()-0.5)*0.003,y:(Math.random()-0.5)*0.003,z:(Math.random()-0.5)*0.003})}
        g.setAttribute('position',new THREE.BufferAttribute(p,3));
        var tc=document.createElement('canvas');tc.width=32;tc.height=32;
        var ctx=tc.getContext('2d'),gr=ctx.createRadialGradient(16,16,0,16,16,16);
        gr.addColorStop(0,'rgba(200,16,46,1)');gr.addColorStop(0.3,'rgba(200,16,46,0.6)');gr.addColorStop(1,'rgba(200,16,46,0)');
        ctx.fillStyle=gr;ctx.fillRect(0,0,32,32);
        var t=new THREE.CanvasTexture(tc),m=new THREE.PointsMaterial({size:0.25,map:t,blending:THREE.AdditiveBlending,transparent:true,opacity:0.8,depthWrite:false,color:0xC8102E}),
        ps=new THREE.Points(g,m);s.add(ps);a.position.z=15;
        var mx=0,my=0;document.addEventListener('mousemove',function(e){var rect=c.getBoundingClientRect();mx=(e.clientX-rect.left)/rect.width-0.5;my=(e.clientY-rect.top)/rect.height-0.5});
        !function an(){requestAnimationFrame(an);var pos=ps.geometry.attributes.position.array;for(var i=0;i<n;i++){pos[i*3]+=d[i].x;pos[i*3+1]+=d[i].y;pos[i*3+2]+=d[i].z;if(Math.abs(pos[i*3])>30)d[i].x*=-1;if(Math.abs(pos[i*3+1])>15)d[i].y*=-1;if(Math.abs(pos[i*3+2])>20)d[i].z*=-1}
        ps.geometry.attributes.position.needsUpdate=true;ps.rotation.y+=0.0005;ps.rotation.x=0.05+my*0.1;ps.rotation.z=mx*0.1;r.render(s,a)}();
        window.addEventListener('resize',function(){var w=c.parentElement.offsetWidth,h=c.parentElement.offsetHeight;r.setSize(w,h);a.aspect=w/h;a.updateProjectionMatrix()});
    }
})();

(function(){
    var dot=document.querySelector('.cursor-dot'),ring=document.querySelector('.cursor-ring');
    if(!dot||!ring||window.matchMedia('(pointer:coarse)').matches)return;
    var mx=-100,my=-100,rx=-100,ry=-100;
    document.addEventListener('mousemove',function(e){mx=e.clientX;my=e.clientY;dot.style.left=mx+'px';dot.style.top=my+'px'});
    !function an(){rx+=(mx-rx)*0.12;ry+=(my-ry)*0.12;ring.style.left=rx+'px';ring.style.top=ry+'px';requestAnimationFrame(an)}();
    document.querySelectorAll('a,button,.product-card,.cat-trigger,.btn-primary,.btn-outline').forEach(function(e){e.addEventListener('mouseenter',function(){ring.classList.add('hover')});e.addEventListener('mouseleave',function(){ring.classList.remove('hover')})});
    document.addEventListener('mouseleave',function(){ring.classList.add('hide')});
    document.addEventListener('mouseenter',function(){ring.classList.remove('hide')});
})();

$(document).ready(function(){
    if($('#home-slick').length){
        $('#home-slick').slick({autoplay:true,autoplaySpeed:6000,speed:800,dots:true,arrows:true,pauseOnHover:false});
    }
    var $cat=$('.category-dropdown.show-on-click');
    if($cat.length){$cat.find('.cat-trigger').on('click',function(e){e.stopPropagation();$cat.find('.cat-list').slideToggle(200);$cat.toggleClass('open')});$(document).on('click',function(e){if(!$cat.is(e.target)&&$cat.has(e.target).length===0){$cat.find('.cat-list').slideUp(200);$cat.removeClass('open')}})}
});

(function(){
    var bar=document.getElementById('scroll-progress');
    if(bar)window.addEventListener('scroll',function(){var h=document.documentElement.scrollHeight-window.innerHeight;bar.style.width=Math.min((window.scrollY/h)*100,100)+'%'});
})();
(function(){
    var btn=document.getElementById('mobile-toggle'),nav=document.getElementById('mobile-nav');
    if(btn&&nav)btn.addEventListener('click',function(){var o=nav.style.maxHeight;if(o&&o!=='0px'){nav.style.maxHeight='0px';btn.querySelector('i').className='fa fa-bars'}else{nav.style.maxHeight=nav.scrollHeight+'px';btn.querySelector('i').className='fa fa-times'}});
})();
(function(){
    var hero=document.getElementById('home');
    if(hero)window.addEventListener('scroll',function(){var s=window.scrollY;if(s<600){hero.style.transform='translateY('+(s*0.15)+'px)';hero.style.opacity=1-(s/600)}});
})();
(function(){
    var m=document.querySelector('.main-content');
    if(m){m.style.opacity='0';setTimeout(function(){m.style.transition='opacity 0.5s ease';m.style.opacity='1'},80)}
    var cards=document.querySelectorAll('.product-card');
    cards.forEach(function(c,i){c.style.opacity='0';setTimeout(function(){c.style.transition='opacity 0.5s ease, transform 0.35s cubic-bezier(.22,.68,0,1), box-shadow 0.35s ease';c.style.opacity='1'},80+i*60)});
})();
function toggleFrontendTheme(){
    var html=document.documentElement,current=html.getAttribute('data-theme'),next=current==='light'?'dark':'light';
    html.setAttribute('data-theme',next);localStorage.setItem('frontend_theme',next);
    var icon=document.getElementById('theme-icon-frontend'),label=document.getElementById('theme-label-frontend');
    if(icon){icon.className=next==='light'?'fa fa-sun-o':'fa fa-moon-o'}
    if(label){label.textContent=next==='light'?'Terang':'Gelap'}
}
(function(){var t=localStorage.getItem('frontend_theme')||'dark',icon=document.getElementById('theme-icon-frontend'),label=document.getElementById('theme-label-frontend');if(icon)icon.className=t==='light'?'fa fa-sun-o':'fa fa-moon-o';if(label)label.textContent=t==='light'?'Terang':'Gelap'})();
</script>
</body>
</html>
