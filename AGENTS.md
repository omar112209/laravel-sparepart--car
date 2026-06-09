# Tokosparepart Mobil — Frontend Polish

## Stack
- Tailwind CSS v4.3.0 + Vite 8.0.16 + Laravel 10
- All views use `@vite(['resources/css/app.css', 'resources/js/app.js'])`
- Dark automotive theme: red primary (`#c8102e`), Barlow (display), Roboto Mono (mono)

## Polish Summary

### Build
`npm run build` produces ~39KB CSS + ~41KB JS

### `resources/css/app.css`
- Full `@import "tailwindcss"` with `@theme` block defining `--font-display`, `--font-mono`, `--color-*` (dark-2, dark-3, steel, red-primary, red-dark, border, border-red, text, text-2, text-3)
- `:root` CSS variable aliases for backward compat (`--text`, `--red`, `--border`, etc.)
- Component classes: `btn-primary`, `btn-outline`, `product-card`, `glass`, `status-badge`
- Custom scrollbar, selection colors, 4 keyframe animations: `fadeUp`, `slideUp`, `float`, `shimmer`
- Utility classes: `animate-fade-up`, `animate-slide-up`, `animate-float`, `animate-shimmer`

### Layout (`v_layouts/app.blade.php`)
- Fixed: duplicate `id="responsive-nav"` split into `id="responsive-nav"` (desktop) + `id="mobile-nav"` (mobile)
- Smooth max-height toggle with `bars`/`times` icon swap on hamburger
- Scroll progress bar at top of page

### Product Grid Pattern (beranda, produk/index, produk/search, produk/kategori)
- Staggered `animate-fade-up` per card via `animation-delay:{{ $i*0.05 }}s`
- Image `group-hover:scale-105` zoom on card hover
- Overlay detail button: `opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0`
- Detail icon button: red background on hover

### Product Detail (`v_produk/detail.blade.php`)
- Image `group-hover:scale-105` zoom
- Thumbnail gallery: hover scale(1.08) + red border
- Stat boxes (stok/berat/kategori): lift on hover + red border glow
- Staggered fade-up on columns

### Customer Views (`login`, `register`, `edit`)
- Modernized with glassmorphism: gradient border glow cards (`absolute -inset-[1px]` + `rounded-2xl`)
- Input fields: icons inside, rounded-xl, red focus glow with `boxShadow`
- Login: brand icon header, "ATAU" divider with circular badge, hover effects on Google button and register link
- Register: same glass card pattern, icons on each input, consistent with login
- Edit Profile: two-column grid layout, avatar with `group-hover` overlay for upload, live preview via FileReader, gradient accent border on card

### Order Views (`cart`, `select_shipping`, `selectpayment`, `success`, `history`, `retur_index`, `retur_form`)
- Staggered `animate-fade-up` on row items and section cards
- Hover border color transitions on cards
- Empty states get hover border glow

### Tests
- 38/39 pass (1 pre-existing failure in `BackendAuthTest` — guard mismatch, unrelated)

## Key Decisions
- Keep Tailwind v4 infrastructure (all 13+ blade files overwritten with Tailwind classes, originals unrecoverable — no git)
- CSS variable aliases in `:root` for backward compat with any old-style references
- `public/frontend/css/` (bootstrap, slick, nouislider, font-awesome) remain loaded via `<link>` in layout

## Caveats
- No `tailwind.config.js` needed (Tailwind v4 is CSS-first)
- No git history (conversion was done before repo was initialized)
