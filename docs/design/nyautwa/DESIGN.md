---
name: NyautWa
colors:
  surface: '#f0fcf6'
  surface-dim: '#d0ddd7'
  surface-bright: '#f0fcf6'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eaf7f0'
  surface-container: '#e4f1ea'
  surface-container-high: '#deebe5'
  surface-container-highest: '#d9e5df'
  on-surface: '#131e1a'
  on-surface-variant: '#3d4a41'
  inverse-surface: '#28332f'
  inverse-on-surface: '#e7f4ed'
  outline: '#6d7a70'
  outline-variant: '#bccabf'
  surface-tint: '#006d44'
  primary: '#006a42'
  on-primary: '#ffffff'
  primary-container: '#008655'
  on-primary-container: '#f6fff6'
  inverse-primary: '#62dd9e'
  secondary: '#56615e'
  on-secondary: '#ffffff'
  secondary-container: '#d7e2de'
  on-secondary-container: '#5a6562'
  tertiary: '#535f59'
  on-tertiary: '#ffffff'
  tertiary-container: '#6b7772'
  on-tertiary-container: '#f5fff9'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#80fab9'
  primary-fixed-dim: '#62dd9e'
  on-primary-fixed: '#002111'
  on-primary-fixed-variant: '#005232'
  secondary-fixed: '#dae5e1'
  secondary-fixed-dim: '#bec9c5'
  on-secondary-fixed: '#131d1c'
  on-secondary-fixed-variant: '#3e4946'
  tertiary-fixed: '#d9e5df'
  tertiary-fixed-dim: '#bdc9c3'
  on-tertiary-fixed: '#131e1a'
  on-tertiary-fixed-variant: '#3d4944'
  background: '#f0fcf6'
  on-background: '#131e1a'
  surface-variant: '#d9e5df'
typography:
  display:
    fontFamily: Geist
    fontSize: 36px
    fontWeight: '600'
    lineHeight: 44px
    letterSpacing: -0.025em
  display-mobile:
    fontFamily: Geist
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Geist
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
    letterSpacing: -0.02em
  headline-lg-mobile:
    fontFamily: Geist
    fontSize: 22px
    fontWeight: '600'
    lineHeight: 30px
    letterSpacing: -0.015em
  headline-md:
    fontFamily: Geist
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
    letterSpacing: -0.015em
  headline-sm:
    fontFamily: Geist
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
    letterSpacing: -0.01em
  body-lg:
    fontFamily: Geist
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
    letterSpacing: 0em
  body-md:
    fontFamily: Geist
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
    letterSpacing: 0em
  body-sm:
    fontFamily: Geist
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 18px
    letterSpacing: 0.005em
  label-md:
    fontFamily: Geist
    fontSize: 13px
    fontWeight: '500'
    lineHeight: 18px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Geist
    fontSize: 11px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.02em
  code-md:
    fontFamily: JetBrains Mono
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 20px
    letterSpacing: -0.01em
  code-sm:
    fontFamily: JetBrains Mono
    fontSize: 11px
    fontWeight: '400'
    lineHeight: 16px
    letterSpacing: 0em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1rem
  gutter-mobile: 0.75rem
  margin: 1.5rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
---

## Brand & Style

This design system embodies a developer-first, mission-critical infrastructure aesthetic tailored for the modern Indonesian enterprise and engineering ecosystem. The visual language blends high-reliability technical precision with the friendly familiarity of regional conversational commerce.

- **Brand Personality**: Engineered, authoritative, responsive, and approachable. It speaks with the clarity of a high-throughput network engine while remaining accessible to product teams, growth managers, and engineers building WhatsApp-driven workflows.
- **Design Movement**: Modern Technical Minimalism combined with Utility-Dense SaaS ergonomics. It leans heavily on clean structured tabular arrangements, delicate 1px low-contrast dividing lines, high-density metric indicators, and crisp geometric data blocks.
- **Voice & Tone Balance**: Technical elements and developer touchpoints (HTTP verbs, webhook events, status tokens, API schemas) remain in international technical English. All contextual guidance, product workflows, billing modules, onboarding, and platform UI copy are rendered in clear, polite, and contemporary business-grade Bahasa Indonesia.

## Colors

The palette centers on an unmistakably conversational yet restrained green foundation, anchored by deep slate charcoal and high-legibility mist neutrals.

- **Primary Canvas & Surfaces**:
  - Main App Canvas: `#F6F8F7` provides an ergonomic, non-fatiguing backdrop behind active workspace cards.
  - Card & Container Surface: `#FFFFFF` for absolute content separation and data isolation.
  - Soft Active Accent Tint: `#EAF7F0` used for badge containers, active sidebar indicators, table row selections, and payload highlighters.
- **Typography & Content Contrast**:
  - Primary Content / Headings: `#17211F` provides near-black legibility without the harshness of pure black.
  - Secondary / Supportive Text: `#697570` for metadata, timestamps, input placeholders, and inactive labels.
- **Brand & Interaction**:
  - Primary Brand Accent: `#16A36A` for primary triggers, connected status indicators, and key operational paths.
  - Interactive Hover: `#128557` applied on pressed/hover states.
  - Technical Contrast Dark: `#17211F` serves as an alternate dark sidebar surface, code container frame, and console output background.
- **System States & Telemetry**:
  - Success / Live: `#16865A` (e.g., Session Connected, 200 OK, Webhook Delivered).
  - Warning / Throttle: `#D99124` (e.g., Queue Full, 429 Rate Limited, Low Balance).
  - Error / Failure: `#D84B4B` (e.g., Disconnected, 500 Error, Invalid API Key).
- **Structural Lines**:
  - Hairline Border: `#E4EAE6` used consistently across card boundaries, inputs, and split views at a 1px weight.

## Typography

The typographic hierarchy is calibrated for scanability, precise numerical parsing, and clear technical debugging.

- **Primary Face (`Geist`)**: Used across all marketing, dashboard surfaces, navigation, tabular data, and operational copy. Selected for its cold geometric structure, crisp legibility at small sizes, and neutral modernism.
- **Monospace Face (`JetBrains Mono`)**: Applied to all technical artifacts: API endpoints (`POST /v1/messages/send`), bearer tokens, device session hashes, phone numbers with country code formats (`+628...`), delivery latency values (`24ms`), and raw JSON blocks.
- **Numeral Handling**: Tabular figures (`tnum`) must be forced on financial balances, delivery success percentages, and API request charts to prevent layout jittering during real-time streaming updates.

## Layout & Spacing

The layout operates on a strict **8px baseline grid rhythm** (with 4px half-steps for micro-alignments in badges and icon locks).

- **Grid Architecture**:
  - **Desktop (>= 1280px)**: 12-column responsive fluid grid inside fixed app containers. Standard left sidebar width is fixed at `256px` (or `64px` collapsed) with flex-grow main canvas.
  - **Tablet (768px - 1279px)**: 8-column layout. The primary navigation collapses into an off-canvas drawer or top toolbar.
  - **Mobile (< 768px)**: 4-column layout with collapsed padding (`margin-mobile` of `1rem`). High-density data tables transform into stacked horizontal cards.
- **Layout Tokens**:
  - `space-xs` (4px): Gap between icon and adjacent label, status dot spacing.
  - `space-sm` (8px): Padding within input elements, button horizontal spacing, chip inner gaps.
  - `space-md` (16px): Internal padding for standard table cells, metric blocks, and dropdown panels.
  - `space-lg` (24px): Standard card container internal padding, stack spacing between form groups.
  - `space-xl` (32px): Distance separating major operational modules, header action bars, and metric summary sections.

## Elevation & Depth

To preserve an authentic developer tool aesthetic, depth is established using **low-contrast borders (`#E4EAE6`) and subtle tonal surfaces** rather than dramatic drop shadows.

- **Surface Tiers**:
  - **Base Canvas**: `#F6F8F7` acts as the recessed floor of the application.
  - **Flat Container Level**: `#FFFFFF` backed by a 1px solid `#E4EAE6` outline. Zero shadow. Used for dashboard cards, code playground frames, and metrics grids.
  - **Interactive Surface (Hover/Lift)**: `box-shadow: 0 1px 3px 0 rgba(23, 33, 31, 0.04), 0 1px 2px -1px rgba(23, 33, 31, 0.02)`. Barely perceptible ambient shadow to signal clickability.
  - **Overlay Level (Dropdowns, Popovers, Date Pickers)**: `#FFFFFF` with `box-shadow: 0 4px 16px -2px rgba(23, 33, 31, 0.08), 0 2px 6px -2px rgba(23, 33, 31, 0.04)` paired with border `#E4EAE6`.
  - **Modal / Command Palette Level**: `box-shadow: 0 20px 25px -5px rgba(23, 33, 31, 0.12), 0 8px 10px -6px rgba(23, 33, 31, 0.04)` over a dim backdrop overlay (`#17211F` at 40% opacity with `backdrop-filter: blur(4px)`).
- **Code Consoles & Sidebars**:
  - Dark-variant sidebar surfaces use solid `#17211F` with a crisp right border (`rgba(255, 255, 255, 0.08)`) to maintain absolute architectural separation without shadow bleeds.

## Shapes

The design system standardizes on a disciplined `8px` baseline radius (`roundedness: 2`), delivering a modern, compact, and engineered appearance.

- **Base Radius (`0.5rem` / 8px)**: Inputs, textareas, standard action buttons, status badges, and inline code blocks.
- **Large Radius (`rounded-lg` - `1rem` / 16px)**: Dashboard cards, API test-bed panels, QR code authentication wrappers, and modal windows.
- **Full / Pill (`rounded-full`)**: Session status pips, avatar fallbacks, numeric message counts, and micro-badges.
- **Visual Rhythm**: Avoid combining sharp 0px elements with soft pill surfaces in the same context; all form fields, tables, and buttons within an area should uniformly adhere to the 8px corner treatment.

## Components

All icons used across components must be consistent outline variants (e.g., Lucide style) with a `1.5px` or `1.75px` stroke weight.

### Buttons
- **Primary**: Solid `#16A36A` background, white label, 8px radius, height 40px (desktop) / 36px (compact table action). Hover: `#128557`. Focus: 2px ring of `#16A36A` with 2px offset.
- **Secondary / Outline**: `#FFFFFF` background, `#17211F` text, 1px border `#E4EAE6`. Hover: `#F6F8F7` background, border `#D0D9D4`.
- **Destructive**: `#FFFFFF` background, `#D84B4B` text, 1px border `#F2D0D0`. Hover: `#D84B4B` background with white text.
- **Ghost / Link**: Transparent background, `#697570` text. Hover: `#17211F` text and `#EAF7F0` subtle background tint.

### Badges & Status Chips
- Height 24px, 6px or 8px radius, padding: `2px 8px`. Font: `label-sm` or `code-sm`.
- **Connected / Aktif**: Background `#EAF7F0`, text `#16865A`, accompanied by a 6px pulsating dot.
- **Pending / Antrean**: Background `#FEF6E7`, text `#D99124`.
- **Failed / Terputus**: Background `#FDF0F0`, text `#D84B4B`.
- **HTTP Verbs**: Compact monospace capsules: `POST` (green/subtle tint), `GET` (slate tint), `DELETE` (red tint).

### Form Inputs & Selects
- Height 40px, 8px radius, 1px border `#E4EAE6`, background `#FFFFFF`. Padding `0 12px`.
- Text color `#17211F`, placeholder `#697570`.
- **Focus State**: Border color `#16A36A` with an ambient glow (`box-shadow: 0 0 0 3px rgba(22, 163, 106, 0.15)`).
- **Prefix / Suffix**: Integrated gray container for fixed prefixes (e.g., `+62`, `https://api.nyautwa.com/v1/`).

### Code Blocks & API Playgrounds
- Embedded dark code panels use `#17211F` surface with 8px radius and a 1px border (`rgba(255, 255, 255, 0.08)`).
- Single-line inline API keys use `#F6F8F7` surface, `#17211F` text, 1px border `#E4EAE6`, and a quick "Salin" (Copy) button with tooltip.
- Text selection inside payloads adopts `#16A36A` with 30% alpha.

### Data Tables (Log Pengiriman / Delivery Logs)
- Flush container with top and bottom 1px border `#E4EAE6`.
- Header row: `#F6F8F7` background, uppercase `11px` tracking font, text `#697570`.
- Row height: 48px, interactive hover background `#FAFCFB`.
- Column alignments: Technical identifiers and phone numbers set in Monospace; numeric metrics right-aligned with tabular figures.

### Gateway Instance Card (Device Session Box)
- White card (`#FFFFFF`) framed in 1px `#E4EAE6` with 16px radius (`rounded-lg`).
- Displays WhatsApp session phone number, battery percentage, active webhook URL, and instantaneous latency counter (`< 120ms`).
- Direct action menu positioned top-right for "Restart Session", "Scan QR", and "Putuskan Sambungan".