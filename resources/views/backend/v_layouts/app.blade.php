<!DOCTYPE html>
<html dir="ltr" lang="en" data-theme="dark">
<head>
    <script>
        (function() {
            var theme = localStorage.getItem('backend_theme');
            if (theme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_mazteach.jpeg') }}">
    <title>MaztechGarage — Admin Panel</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('backend/extra-libs/multicheck/multicheck.css') }}">
    <link href="{{ asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700;800&family=Outfit:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        /* ════════════════════════════════════════
       CSS TOKENS
    ════════════════════════════════════════ */
        :root {
            --c-bg: #100808;
            --c-surface: #1C0E0E;
            --c-surface2: #2A1616;
            --c-border: rgba(255, 255, 255, .08);
            --c-red: #C8102E;
            --c-red-dk: #9A0C23;
            --c-orange: #D97706;
            --c-yellow: #F5C518;
            --c-green: #27AE60;
            --c-blue: #2E86DE;
            --c-text: #F0E8E8;
            --c-muted: #A07070;
            --c-white: #FFFFFF;
            --font-d: 'Barlow Condensed', sans-serif;
            --font-b: 'Outfit', sans-serif;
            --topbar-h: 64px;
            --sidebar-w: 260px;
            --radius: 10px;
        }

        [data-theme="light"] {
            --c-bg: #FDF5F5;
            --c-surface: #FFFFFF;
            --c-surface2: #FFF0F0;
            --c-border: rgba(0, 0, 0, .1);
            --c-text: #2D1B1B;
            --c-muted: #9A7A7A;
            --c-white: #1A0808;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-b) !important;
            background: var(--c-bg) !important;
            color: var(--c-text) !important;
        }

        /* ── Preloader ── */
        .preloader {
            background: var(--c-bg) !important;
        }

        .lds-ripple .lds-pos {
            border-color: var(--c-red) !important;
        }

        /* ════════════════════════════════════════
       TOPBAR
    ════════════════════════════════════════ */
        .topbar,
        .topbar[data-navbarbg="skin5"],
        .topbar[data-navbarbg="skin5"] .top-navbar {
            background: var(--c-surface) !important;
            border-bottom: 2px solid var(--c-red) !important;
            box-shadow: 0 2px 24px rgba(0, 0, 0, .5) !important;
        }

        .top-navbar {
            height: var(--topbar-h) !important;
            padding: 0 1.25rem !important;
        }

        /* Logo header cell */
        .navbar-header[data-logobg="skin5"] {
            background: var(--c-surface) !important;
            border-right: 1px solid var(--c-border) !important;
            width: var(--sidebar-w) !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 1.25rem !important;
        }

        /* Brand — hide original images, inject CSS brand */
        .navbar-brand {
            display: flex !important;
            align-items: center !important;
            gap: .5rem !important;
            padding: 0 !important;
            text-decoration: none !important;
        }

        .navbar-brand .logo-icon,
        .navbar-brand .logo-text {
            display: none !important;
        }

        .navbar-brand::before {
            content: '⚙';
            font-size: 1.5rem;
            color: var(--c-red);
            line-height: 1;
            flex-shrink: 0;
        }

        .navbar-brand::after {
            content: 'MazteachGarage';
            font-family: var(--font-d);
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--c-white);
            letter-spacing: .04em;
        }

        /* Nav links */
        .top-navbar .navbar-nav .nav-link {
            color: var(--c-muted) !important;
            transition: color .18s !important;
        }

        .top-navbar .navbar-nav .nav-link:hover {
            color: var(--c-white) !important;
        }

        .top-navbar .navbar-nav .nav-link i {
            color: inherit !important;
        }

        /* Avatar ring */
        .pro-pic img {
            border: 2px solid var(--c-red) !important;
            transition: border-color .18s;
            object-fit: cover;
        }

        .pro-pic:hover img {
            border-color: var(--c-orange) !important;
        }

        /* Dropdown */
        .user-dd {
            background: var(--c-surface2) !important;
            border: 1px solid var(--c-border) !important;
            border-top: 2px solid var(--c-red) !important;
            border-radius: 0 0 var(--radius) var(--radius) !important;
            box-shadow: 0 10px 32px rgba(0, 0, 0, .55) !important;
            min-width: 200px !important;
        }

        .user-dd .dropdown-item {
            color: var(--c-text) !important;
            font-size: .85rem !important;
            padding: .6rem 1.2rem !important;
            font-family: var(--font-b) !important;
            transition: background .15s, color .15s !important;
        }

        .user-dd .dropdown-item:hover {
            background: rgba(200, 16, 46, .15) !important;
            color: var(--c-white) !important;
        }

        .user-dd .dropdown-divider {
            border-color: var(--c-border) !important;
        }

        /* ════════════════════════════════════════
       LEFT SIDEBAR
    ════════════════════════════════════════ */
        .left-sidebar,
        .left-sidebar[data-sidebarbg="skin5"] {
            background: var(--c-surface) !important;
            border-right: 1px solid var(--c-border) !important;
            width: var(--sidebar-w) !important;
            top: var(--topbar-h) !important;
            box-shadow: 2px 0 20px rgba(0, 0, 0, .3) !important;
        }

        .scroll-sidebar {
            background: transparent !important;
        }

        /* Section headers */
        .nav-small-cap {
            font-family: var(--font-d) !important;
            font-size: .64rem !important;
            letter-spacing: .2em !important;
            color: var(--c-muted) !important;
            padding: 1.1rem 1.5rem .35rem !important;
            text-transform: uppercase !important;
        }

        /* Sidebar links */
        .sidebar-link {
            display: flex !important;
            align-items: center !important;
            gap: .7rem !important;
            padding: .7rem 1.4rem !important;
            color: var(--c-muted) !important;
            font-family: var(--font-b) !important;
            font-size: .87rem !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            transition: color .18s, background .18s !important;
            border-right: 3px solid transparent !important;
        }

        .sidebar-link i,
        .sidebar-link .mdi {
            font-size: 1.15rem !important;
            width: 22px !important;
            text-align: center !important;
            flex-shrink: 0 !important;
            color: inherit !important;
            transition: color .18s !important;
        }

        .sidebar-link span.hide-menu {
            font-family: var(--font-b) !important;
            font-size: .87rem !important;
            font-weight: 500 !important;
        }

        .sidebar-link:hover,
        .sidebar-item:hover>.sidebar-link {
            background: rgba(200, 16, 46, .1) !important;
            color: var(--c-white) !important;
        }

        .sidebar-link:hover i {
            color: var(--c-orange) !important;
        }

        .sidebar-item.selected>.sidebar-link {
            background: rgba(200, 16, 46, .15) !important;
            color: var(--c-white) !important;
            border-right-color: var(--c-red) !important;
        }

        .sidebar-item.selected>.sidebar-link i {
            color: var(--c-red) !important;
        }

        /* Submenu */
        .first-level {
            background: rgba(0, 0, 0, .18) !important;
            border-left: 2px solid rgba(200, 16, 46, .2) !important;
            margin-left: 1.4rem !important;
        }

        .first-level .sidebar-link {
            padding: .52rem 1rem .52rem 1rem !important;
            font-size: .83rem !important;
        }

        .first-level .sidebar-link:hover {
            color: var(--c-white) !important;
            background: rgba(200, 16, 46, .08) !important;
        }

        /* Arrow */
        .has-arrow::after {
            border-color: var(--c-muted) !important;
            right: 1.2rem !important;
        }

        /* Gradient rainbow strip at top of nav */
        #sidebarnav::before {
            content: '';
            display: block;
            height: 3px;
            background: linear-gradient(90deg, var(--c-red), var(--c-orange), var(--c-yellow));
            margin: 0 1rem 1rem;
            border-radius: 2px;
        }

        /* User chip at sidebar bottom */
        .sidebar-footer {
            position: sticky;
            bottom: 0;
            background: var(--c-surface);
            border-top: 1px solid var(--c-border);
            padding: .85rem 1.2rem;
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .sf-avatar {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--c-red), var(--c-orange));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-d);
            font-size: .95rem;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .sf-name {
            font-size: .82rem;
            font-weight: 600;
            color: var(--c-white);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 130px;
        }

        .sf-role {
            font-size: .69rem;
            color: var(--c-muted);
        }

        .sf-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--c-green);
            margin-left: auto;
            flex-shrink: 0;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, .2);
        }

        .mini-sidebar .sidebar-footer {
            display: none !important;
        }

        .mini-sidebar .navbar-header[data-logobg] {
            width: 70px !important;
        }

        .mini-sidebar .navbar-brand::after {
            display: none;
        }

        /* ════════════════════════════════════════
       PAGE WRAPPER
    ════════════════════════════════════════ */
        .page-wrapper {
            background: var(--c-bg) !important;
            margin-top: var(--topbar-h) !important;
            min-height: calc(100vh - var(--topbar-h)) !important;
        }

        .container-fluid {
            padding: 1.5rem !important;
            animation: page-in .38s ease both;
        }

        @keyframes page-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Cards ── */
        .card {
            background: var(--c-surface) !important;
            border: 1px solid var(--c-border) !important;
            border-radius: var(--radius) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .3) !important;
            color: var(--c-text) !important;
        }

        .card-title {
            font-family: var(--font-d) !important;
            font-size: 1rem !important;
            font-weight: 700 !important;
            letter-spacing: .06em !important;
            text-transform: uppercase !important;
            color: var(--c-white) !important;
        }

        .card-body {
            background: transparent !important;
            color: var(--c-text) !important;
        }

        .border-top {
            border-color: var(--c-border) !important;
        }

        /* ── Tables ── */
        .table {
            color: var(--c-text) !important;
            border-color: var(--c-border) !important;
        }

        .table thead th {
            background: var(--c-surface2) !important;
            color: var(--c-muted) !important;
            font-family: var(--font-d) !important;
            font-size: .73rem !important;
            letter-spacing: .12em !important;
            text-transform: uppercase !important;
            border-color: var(--c-border) !important;
            font-weight: 600 !important;
        }

        .table td,
        .table th {
            border-color: var(--c-border) !important;
            vertical-align: middle !important;
            font-size: .875rem !important;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, .025) !important;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background: rgba(255, 255, 255, .018) !important;
        }

        /* DataTables */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--c-red) !important;
            color: #fff !important;
            border-color: var(--c-red) !important;
            border-radius: 6px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--c-muted) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(200, 16, 46, .15) !important;
            color: var(--c-white) !important;
            border-color: transparent !important;
            border-radius: 6px !important;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background: var(--c-surface2) !important;
            border: 1px solid var(--c-border) !important;
            border-radius: 8px !important;
            color: var(--c-text) !important;
            padding: .3rem .7rem !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--c-muted) !important;
            font-size: .8rem !important;
        }

        /* ── Forms ── */
        .form-control {
            background: var(--c-surface2) !important;
            border: 1px solid var(--c-border) !important;
            border-radius: 8px !important;
            color: var(--c-text) !important;
            font-family: var(--font-b) !important;
            transition: border-color .18s, box-shadow .18s !important;
        }

        .form-control:focus {
            border-color: var(--c-red) !important;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, .18) !important;
            background: var(--c-surface2) !important;
            color: var(--c-white) !important;
            outline: none !important;
        }

        .form-control::placeholder {
            color: var(--c-muted) !important;
        }

        .form-control option {
            background: var(--c-surface2) !important;
        }

        label {
            font-size: .78rem !important;
            text-transform: uppercase !important;
            letter-spacing: .1em !important;
            color: var(--c-muted) !important;
            font-weight: 600 !important;
            margin-bottom: .3rem !important;
        }

        /* ── Buttons ── */
        .btn {
            font-family: var(--font-b) !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            font-size: .84rem !important;
            transition: all .18s !important;
        }

        .btn-primary {
            background: var(--c-red) !important;
            border-color: var(--c-red) !important;
            color: #fff !important;
        }

        .btn-primary:hover {
            background: var(--c-red-dk) !important;
            border-color: var(--c-red-dk) !important;
            box-shadow: 0 4px 14px rgba(200, 16, 46, .4) !important;
        }

        .btn-success {
            background: var(--c-green) !important;
            border-color: var(--c-green) !important;
        }

        .btn-warning {
            background: var(--c-orange) !important;
            border-color: var(--c-orange) !important;
            color: #fff !important;
        }

        .btn-danger {
            background: #8B0000 !important;
            border-color: #8B0000 !important;
        }

        .btn-info {
            background: var(--c-blue) !important;
            border-color: var(--c-blue) !important;
        }

        .btn-secondary {
            background: var(--c-surface2) !important;
            border-color: var(--c-border) !important;
            color: var(--c-text) !important;
        }

        .btn-secondary:hover {
            background: var(--c-surface) !important;
            color: var(--c-white) !important;
        }

        /* ── Badges ── */
        .badge-primary {
            background: var(--c-red) !important;
        }

        .badge-success {
            background: var(--c-green) !important;
        }

        .badge-warning {
            background: var(--c-orange) !important;
            color: #fff !important;
        }

        .badge-danger {
            background: #8B0000 !important;
        }

        .badge-info {
            background: var(--c-blue) !important;
        }

        .badge-secondary {
            background: var(--c-surface2) !important;
            color: var(--c-text) !important;
        }

        /* ── Alerts ── */
        .alert {
            border-radius: var(--radius) !important;
            border: 1px solid !important;
            font-size: .87rem !important;
        }

        .alert-success {
            background: rgba(39, 174, 96, .1) !important;
            border-color: rgba(39, 174, 96, .3) !important;
            color: #6EE89D !important;
        }

        .alert-danger {
            background: rgba(200, 16, 46, .1) !important;
            border-color: rgba(200, 16, 46, .3) !important;
            color: #F87171 !important;
        }

        .alert-warning {
            background: rgba(240, 124, 28, .1) !important;
            border-color: rgba(240, 124, 28, .3) !important;
            color: #FDB165 !important;
        }

        .alert-info {
            background: rgba(46, 134, 222, .1) !important;
            border-color: rgba(46, 134, 222, .3) !important;
            color: #7EC8F5 !important;
        }

        .alert-heading {
            font-family: var(--font-d) !important;
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            color: inherit !important;
        }

        /* ── Breadcrumb ── */
        .breadcrumb {
            background: var(--c-surface2) !important;
            border-radius: var(--radius) !important;
            padding: .5rem 1rem !important;
        }

        .breadcrumb-item a {
            color: var(--c-orange) !important;
        }

        .breadcrumb-item.active {
            color: var(--c-muted) !important;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: var(--c-muted) !important;
        }

        /* ── Modals ── */
        .modal-content {
            background: var(--c-surface) !important;
            border: 1px solid var(--c-border) !important;
            border-radius: var(--radius) !important;
            color: var(--c-text) !important;
        }

        .modal-header {
            background: var(--c-surface2) !important;
            border-bottom: 1px solid var(--c-border) !important;
            border-radius: var(--radius) var(--radius) 0 0 !important;
        }

        .modal-title {
            font-family: var(--font-d) !important;
            font-weight: 700 !important;
            color: var(--c-white) !important;
            letter-spacing: .05em !important;
            text-transform: uppercase !important;
        }

        .modal-footer {
            border-top: 1px solid var(--c-border) !important;
        }

        .close {
            color: var(--c-muted) !important;
        }

        .close:hover {
            color: var(--c-white) !important;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: var(--c-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--c-surface2);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--c-muted);
        }

        /* ── Footer ── */
        .footer {
            background: var(--c-surface) !important;
            border-top: 1px solid var(--c-border) !important;
            color: var(--c-muted) !important;
            font-size: .78rem !important;
            font-family: var(--font-b) !important;
            padding: .9rem 1.5rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: .4rem !important;
        }

        .footer::before {
            content: '⚙';
            color: var(--c-red);
            font-size: .85rem;
        }

        .footer a {
            color: var(--c-orange) !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            transition: color .18s !important;
        }

        .footer a:hover {
            color: var(--c-yellow) !important;
        }
        /* ════════════════════════════════════════
           ANIMATIONS
        ════════════════════════════════════════ */
        @keyframes fade-in {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes slide-down {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes scale-in {
            from { opacity: 0; transform: scale(0.95); }
            to   { opacity: 1; transform: scale(1); }
        }
        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 var(--c-red); }
            70%  { box-shadow: 0 0 0 10px transparent; }
            100% { box-shadow: 0 0 0 0 transparent; }
        }
        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .anm-fade { animation: fade-in 0.4s ease both; }
        .anm-up   { animation: slide-up 0.4s ease both; }
        .anm-dn   { animation: slide-down 0.35s ease both; }
        .anm-scale { animation: scale-in 0.35s ease both; }

        .anm-d1 { animation-delay: 0.05s; }
        .anm-d2 { animation-delay: 0.1s; }
        .anm-d3 { animation-delay: 0.15s; }
        .anm-d4 { animation-delay: 0.2s; }
        .anm-d5 { animation-delay: 0.25s; }

        .reveal {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Sidebar link indicator animation */
        .sidebar-link {
            position: relative;
        }
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 3px;
            height: 0;
            background: var(--c-red);
            border-radius: 0 2px 2px 0;
            transition: height 0.25s ease, top 0.25s ease;
        }
        .sidebar-item:hover .sidebar-link::before,
        .sidebar-item.selected .sidebar-link::before {
            height: 60%;
            top: 20%;
        }

        /* Card hover lift */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4) !important;
        }
        [data-theme="light"] .card:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.1) !important;
        }

        /* Bell notification pulse */
        .nav-link i.mdi-bell-outline {
            animation: pulse-ring 2s ease infinite;
        }

        /* Button press */
        .btn:active {
            transform: scale(0.97);
        }

        /* Preloader fade */
        .preloader {
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        /* Stat card entrance (dashboard) */
        .stat-card {
            animation: slide-up 0.4s ease both;
        }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.12s; }
        .stat-card:nth-child(3) { animation-delay: 0.19s; }
        .stat-card:nth-child(4) { animation-delay: 0.26s; }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper">

        <!-- ══════════ TOPBAR ══════════ -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    {{-- Logo brand (CSS-injected, images hidden) --}}
                    <a class="navbar-brand" href="{{ route('backend.beranda') }}"></a>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-left mr-auto" style="align-items:center;">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar">
                                <i class="mdi mdi-menu font-24"></i>
                            </a>
                        </li>
        
                    </ul>

                    <ul class="navbar-nav float-right" style="align-items:center;gap:.2rem;">
                        {{-- Theme Toggle --}}
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link theme-toggle-btn-admin" onclick="toggleBackendTheme()"
                                title="Ganti tema" style="padding:.5rem .7rem;display:flex;align-items:center;gap:6px;">
                                <i class="mdi mdi-weather-night" id="theme-icon-backend" style="font-size:1.2rem;"></i>
                                <span id="theme-label-backend" style="font-size:.75rem;font-family:var(--font-b);color:var(--c-muted);">Gelap</span>
                            </a>
                        </li>
                        {{-- Bell notif --}}
                        <li class="nav-item dropdown" style="position:relative;">
                            <a href="javascript:void(0)" class="nav-link" id="notifDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="padding:.5rem .7rem;position:relative;">
                                <i class="mdi mdi-bell-outline" style="font-size:1.2rem;"></i>
                                <span id="notif-badge"
                                    style="position:absolute;top:5px;right:5px;min-width:16px;height:16px;
                                             background:var(--c-red);border-radius:50%;
                                             border:2px solid var(--c-surface);
                                             font-size:9px;line-height:12px;text-align:center;color:#fff;
                                             font-weight:700;display:none;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"
                                style="width:340px;background:var(--c-surface2);border:1px solid var(--c-border);border-top:2px solid var(--c-red);border-radius:0 0 var(--radius) var(--radius);box-shadow:0 10px 32px rgba(0,0,0,.55);padding:0;">
                                <div
                                    style="display:flex;align-items:center;justify-content:space-between;padding:.7rem 1rem;border-bottom:1px solid var(--c-border);">
                                    <span
                                        style="font-family:var(--font-d);font-weight:700;font-size:.85rem;color:var(--c-white);text-transform:uppercase;letter-spacing:.08em;">Notifikasi</span>
                                    <a href="javascript:void(0)" id="markAllRead"
                                        style="font-size:.7rem;color:var(--c-orange);text-decoration:none;font-weight:500;">Tandai dibaca</a>
                                </div>
                                <div id="notif-list"
                                    style="max-height:320px;overflow-y:auto;padding:.4rem 0;">
                                    <div style="padding:1.2rem;text-align:center;color:var(--c-muted);font-size:.82rem;">
                                        Memuat...
                                    </div>
                                </div>
                            </div>
                        </li>
                        {{-- Divider --}}
                        <li style="width:1px;height:22px;background:var(--c-border);margin:0 .2rem;"></li>
                        {{-- User --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                                href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="display:flex;align-items:center;gap:.5rem;padding:.4rem .7rem;">
                                @if (Auth::guard('admin')->user()->foto)
                                    <img src="{{ asset('storage/img-user/' . Auth::guard('admin')->user()->foto) }}" alt="user"
                                        class="rounded-circle" width="32" height="32">
                                @else
                                    <img src="{{ asset('storage/img-user/img-default.jpg') }}" alt="user"
                                        class="rounded-circle" width="32" height="32">
                                @endif
                                <span class="d-none d-md-block"
                                    style="font-size:.83rem;font-weight:500;color:var(--c-text);font-family:var(--font-b);">{{ Auth::guard('admin')->user()->nama }}</span>
                                <i class="mdi mdi-chevron-down d-none d-md-block"
                                    style="font-size:.95rem;color:var(--c-muted);"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <div style="padding:.7rem 1.2rem .55rem;border-bottom:1px solid var(--c-border);">
                                    <div
                                        style="font-family:var(--font-d);font-weight:700;font-size:.95rem;color:var(--c-white);">
                                        {{ Auth::guard('admin')->user()->nama }}</div>
                                    <div style="font-size:.7rem;color:var(--c-muted);margin-top:.1rem;">
                                        @if (Auth::guard('admin')->user()->role == 1)
                                            Super Admin
                                        @else
                                            Admin
                                        @endif
                                    </div>
                                </div>
                                <a class="dropdown-item" href="{{ route('backend.user.edit', Auth::guard('admin')->user()->id) }}">
                                    <i class="ti-user m-r-5 m-l-5"></i> Profil Saya
                                </a>
                                <a class="dropdown-item" href=""
                                    onclick="event.preventDefault(); document.getElementById('keluar-app').submit();">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i> Keluar
                                </a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- ══════════ LEFT SIDEBAR ══════════ -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-20">

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('backend.beranda') }}"
                                aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="hide-menu">Beranda</span>
                            </a>
                        </li>

                        <li class="nav-small-cap"><span>Master Data</span></li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark" href="{{ route('backend.user.index') }}"
                                aria-expanded="false">
                                <i class="mdi mdi-account-key"></i>
                                <span class="hide-menu">User</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark"
                                href="{{ route('backend.customer.index') }}" aria-expanded="false">
                                <i class="mdi mdi-account-multiple"></i>
                                <span class="hide-menu">Customer</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark"
                                href="{{ route('backend.voucher.index') }}" aria-expanded="false">
                                <i class="mdi mdi-ticket-percent"></i>
                                <span class="hide-menu">Voucher</span>
                            </a>
                        </li>

                        <li class="nav-small-cap"><span>Katalog</span></li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-wrench"></i>
                                <span class="hide-menu">Data Produk</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('backend.kategori.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">Kategori</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('backend.produk.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">Produk</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-small-cap"><span>Transaksi</span></li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-cart"></i>
                                <span class="hide-menu">Pesanan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('pesanan.proses') }}" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">Pesanan Proses</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('pesanan.selesai') }}" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">Pesanan Selesai</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('retur.admin.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">Retur</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-small-cap"><span>Laporan</span></li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-chart-bar"></i>
                                <span class="hide-menu">Laporan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('backend.laporan.formuser') }}" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">User</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('backend.laporan.formproduk') }}" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">Produk</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('laporan.proses') }}" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">Pesanan Proses</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('laporan.selesai') }}" class="sidebar-link">
                                        <i class="mdi mdi-chevron-right"></i>
                                        <span class="hide-menu">Pesanan Selesai</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>

            {{-- User chip -- bottom of sidebar --}}
            <div class="sidebar-footer">
                <div class="sf-avatar">{{ strtoupper(substr(Auth::guard('admin')->user()->nama, 0, 1)) }}</div>
                <div>
                    <div class="sf-name">{{ Auth::guard('admin')->user()->nama }}</div>
                    <div class="sf-role">
                        @if (Auth::guard('admin')->user()->role == 1)
                            Super Admin
                        @else
                            Admin
                        @endif
                    </div>
                </div>
                <div class="sf-dot"></div>
            </div>
        </aside>

        <!-- ══════════ PAGE WRAPPER ══════════ -->
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>

            <footer class="footer text-center">
                MaztechGarage &mdash; Toko Sparepart Mobil Online &nbsp;|&nbsp;
                <a href="https://bsi.ac.id/" target="_blank">Kuliah? BSI Aja !!!</a>
            </footer>
        </div>

    </div>
    <!-- End Main wrapper -->

    <form id="keluar-app" action="{{ route('backend.logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- Scripts -->
    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('backend/dist/js/waves.js') }}"></script>
    <script src="{{ asset('backend/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/multicheck/datatable-checkbox-init.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/multicheck/jquery.multicheck.js') }}"></script>
    <script src="{{ asset('backend/extra-libs/DataTables/datatables.min.js') }}"></script>

    <script>
        $('#dataTable').DataTable();
    </script>

    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                background: getComputedStyle(document.documentElement).getPropertyValue('--c-surface').trim() || '#1C2C40',
                color: getComputedStyle(document.documentElement).getPropertyValue('--c-text').trim() || '#D8E6F3',
                confirmButtonColor: '#C8102E'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                background: getComputedStyle(document.documentElement).getPropertyValue('--c-surface').trim() || '#1C2C40',
                color: getComputedStyle(document.documentElement).getPropertyValue('--c-text').trim() || '#D8E6F3',
                confirmButtonColor: '#C8102E'
            });
        </script>
    @endif

    <script>
        function swalTheme() {
            return {
                background: getComputedStyle(document.documentElement).getPropertyValue('--c-surface').trim() || '#1C2C40',
                color: getComputedStyle(document.documentElement).getPropertyValue('--c-text').trim() || '#D8E6F3',
            };
        }
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var konfdelete = $(this).data("konf-delete");
            event.preventDefault();
            var t = swalTheme();
            Swal.fire({
                title: 'Konfirmasi Hapus Data?',
                html: "Data <strong>" + konfdelete + "</strong> tidak dapat dikembalikan!",
                icon: 'warning',
                background: t.background,
                color: t.color,
                showCancelButton: true,
                confirmButtonColor: '#C8102E',
                cancelButtonColor: '#253447',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var t2 = swalTheme();
                    Swal.fire({
                            title: 'Terhapus!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            background: t2.background,
                            color: t2.color,
                            confirmButtonColor: '#C8102E'
                        })
                        .then(() => {
                            form.submit();
                        });
                }
            });
        });
    </script>

    <script>
        function previewFoto() {
            const foto = document.querySelector('input[name="foto"]');
            const fotoPreview = document.querySelector('.foto-preview');
            fotoPreview.style.display = 'block';
            const fotoReader = new FileReader();
            fotoReader.readAsDataURL(foto.files[0]);
            fotoReader.onload = function(e) {
                fotoPreview.src = e.target.result;
                fotoPreview.style.width = '100%';
            }
        }
    </script>

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        if (document.querySelector('#ckeditor')) {
            ClassicEditor.create(document.querySelector('#ckeditor'))
                .catch(error => {
                    console.error(error);
                });
        }
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ── NOTIFIKASI SYSTEM ──
        function getNotifUrl(path) {
            return '{{ url("backend/notifikasi") }}' + path;
        }

        function loadNotifikasi() {
            $.get(getNotifUrl(''), function(res) {
                var list = $('#notif-list');
                var badge = $('#notif-badge');
                if (!res.notifikasis || res.notifikasis.length === 0) {
                    list.html('<div style="padding:1.5rem;text-align:center;color:var(--c-muted);font-size:.82rem;">Belum ada notifikasi.</div>');
                    badge.hide();
                    return;
                }
                var html = '';
                $.each(res.notifikasis, function(i, n) {
                    var icons = { stok: '📦', pesanan: '🛒', retur: '🔄' };
                    var icon = icons[n.type] || '🔔';
                    var bg = n.is_read ? 'transparent' : 'rgba(200,16,46,.07)';
                    html += '<a href="' + (n.url || 'javascript:void(0)') + '" class="notif-item" data-id="' + n.id + '" style="display:flex;gap:.7rem;padding:.65rem 1rem;text-decoration:none;color:var(--c-text);font-size:.8rem;font-family:var(--font-b);border-bottom:1px solid var(--c-border);transition:background .15s;background:' + bg + ';" onmouseover="this.style.background=\'rgba(255,255,255,.04)\'" onmouseout="this.style.background=\'' + bg + '\'">';
                    html += '<span style="font-size:1.1rem;flex-shrink:0;margin-top:2px;">' + icon + '</span>';
                    html += '<div style="flex:1;min-width:0;">';
                    html += '<div style="font-weight:600;color:var(--c-white);font-size:.82rem;">' + n.judul + '</div>';
                    html += '<div style="color:var(--c-muted);font-size:.74rem;margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' + n.pesan + '</div>';
                    html += '<div style="font-size:.65rem;color:var(--c-muted);margin-top:3px;">' + n.created_at + '</div>';
                    html += '</div>';
                    if (!n.is_read) {
                        html += '<span class="notif-dot" style="width:7px;height:7px;border-radius:50%;background:var(--c-red);flex-shrink:0;margin-top:6px;"></span>';
                    }
                    html += '</a>';
                });
                list.html(html);

                if (res.unread_count > 0) {
                    badge.text(res.unread_count).show();
                } else {
                    badge.hide();
                }
            });
        }

        $(document).on('click', '.notif-item', function() {
            var id = $(this).data('id');
            if (id) {
                $.ajax({ url: getNotifUrl('/' + id + '/read'), type: 'PUT' });
            }
        });

        $('#markAllRead').on('click', function() {
            $.ajax({ url: getNotifUrl('/read-all'), type: 'PUT' }).done(function() {
                loadNotifikasi();
            });
        });

        $(document).ready(function() {
            loadNotifikasi();
            setInterval(loadNotifikasi, 30000);
        });
    </script>

    <script>
        // ── SCROLL REVEAL ──
        (function() {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
            document.querySelectorAll('.reveal').forEach(function(el) {
                observer.observe(el);
            });
        })();

        // ── BACKEND THEME TOGGLE ──
        function toggleBackendTheme() {
            var html = document.documentElement;
            var current = html.getAttribute('data-theme');
            var next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', next);
            localStorage.setItem('backend_theme', next);
            var icon = document.getElementById('theme-icon-backend');
            var label = document.getElementById('theme-label-backend');
            if (icon) {
                icon.className = next === 'light' ? 'mdi mdi-weather-sunny' : 'mdi mdi-weather-night';
            }
            if (label) {
                label.textContent = next === 'light' ? 'Terang' : 'Gelap';
            }
        }
        (function() {
            var theme = localStorage.getItem('backend_theme') || 'dark';
            var icon = document.getElementById('theme-icon-backend');
            var label = document.getElementById('theme-label-backend');
            if (icon) {
                icon.className = theme === 'light' ? 'mdi mdi-weather-sunny' : 'mdi mdi-weather-night';
            }
            if (label) {
                label.textContent = theme === 'light' ? 'Terang' : 'Gelap';
            }
        })();
    </script>

</body>

</html>
