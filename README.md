# PMPortfolio

> Premium bilingual WordPress portfolio theme built from scratch.

A production-grade WordPress theme demonstrating senior-level PHP architecture,
advanced technical SEO, and modern frontend practices — built without paid plugins
or page builders.

## Tech Stack

- **PHP 8.2** — OOP with namespaces, PSR-4 autoloader (no Composer)
- **WordPress 6.4+** — Custom Post Types, Meta Boxes, Settings API
- **Bootstrap 5.3** — CDN, grid system, utility classes
- **CSS Variables** — complete dark/light design system
- **Vanilla JS ES6+** — no jQuery on the frontend

## Features

- Bilingual PT-BR / EN-US without Polylang or WPML
- Advanced technical SEO: Schema JSON-LD, hreflang, canonical, Open Graph
- Dark mode with anti-flash script (localStorage persistence)
- Conditional asset loading per page (Lighthouse 95+ target)
- Custom Post Types for Portfolio and Services
- Admin options panel via Settings API

## Architecture
inc/

├── core/          # Autoloader, Theme, Asset Manager, Theme Support

├── seo/           # Schema, Meta Tags, Open Graph, hreflang

├── multilingual/  # Language Manager, Language Router

├── cpt/           # Portfolio CPT, Service CPT

└── admin/         # Options Page, SEO Meta Box

## Local Development

Requirements: PHP 8.2+, WordPress 6.4+, WAMP/XAMPP

1. Clone into `wp-content/themes/pmportfolio`
2. Activate theme in WordPress admin
3. Done — no build step required

## Author

**Paulo Marcelo** — Software Engineer & Marketing Tech Lead
- Available for remote work worldwide
- [paulomarcelo.dev](https://paulomarcelo.dev)