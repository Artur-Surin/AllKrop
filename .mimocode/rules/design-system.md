# Design System — Kropyvnytskyi City Portal

## Typography

- **Body font**: Manrope (sans-serif) — all body text, UI elements, navigation
- **Heading font**: Playfair Display (serif) — h1, h2, h3 and display text
- **Monospace**: system monospace stack for code blocks
- Base size: `16px` / `1rem`; body text: `text-sm` (`0.875rem`)
- Line height: `leading-relaxed` (1.625) for body, `leading-tight` (1.25) for headings
- Load fonts via Google Fonts `<link>` or `@fontsource` packages

## Colors

- Use `oklch` color space for all theme colors
- Three themes: **light**, **dark**, **contrast**
- Define tokens as CSS custom properties on `:root` / `@theme`:

```
--color-primary       oklch(0.55 0.15 250)    /* brand blue */
--color-primary-foreground  oklch(0.98 0.01 250)
--color-secondary     oklch(0.70 0.12 180)    /* teal accent */
--color-accent        oklch(0.65 0.18 45)     /* warm gold */
--color-background    oklch(0.99 0.005 100)   /* near-white */
--color-card          oklch(1.00 0 0)          /* pure white */
--color-foreground    oklch(0.15 0.02 260)     /* dark text */
--color-muted-foreground  oklch(0.55 0.03 260) /* secondary text */
--color-border        oklch(0.88 0.01 260)     /* subtle borders */
```

- Dark theme overrides via `[data-theme="dark"]` or `.dark` class on `<html>`
- Contrast theme for accessibility: high-contrast ratios (WCAG AAA)

## Components

### Buttons

- `rounded-full` for pill shape, `px-6 py-3` for standard size
- `bg-primary text-primary-foreground` for primary
- `hover:scale-[1.02] transition-transform` for micro-interaction
- `active:scale-[0.98]` for press feedback
- Variants: `primary`, `secondary` (outline), `ghost`, `destructive`

### Cards

- `rounded-2xl border border-border bg-card`
- `p-6` padding, `shadow-sm` for subtle elevation
- Hover state: `hover:shadow-md transition-shadow`
- Group cards with `gap-5` or `gap-6`

### Navigation

- `sticky top-0 z-50 bg-background/80 backdrop-blur-md`
- Active link: `text-primary font-semibold`
- Mobile: hamburger with Alpine.js `x-data="{ open: false }"`
- Breadcrumb: `text-sm text-muted-foreground` with `/` separators

### Forms

- Inputs: `rounded-lg border border-border bg-background px-4 py-2`
- Focus ring: `focus:ring-2 focus:ring-primary/40 focus:border-primary`
- Labels: `text-sm font-medium text-foreground mb-1`
- Error state: `border-destructive text-destructive`

## Layout

- Max content width: `max-w-6xl mx-auto`
- Grid system: `grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5`
- Container padding: `px-4 sm:px-6`
- Section spacing: `py-16 sm:py-24`
- Section dividers: `border-t border-border` between sections

## Icons

- SVG inline, sizes: `h-4 w-4` (sm), `h-5 w-5` (md), `h-6 w-6` (lg)
- Stroke-based: `stroke="currentColor" fill="none" stroke-width="1.5"`
- Decorative icons: `aria-hidden="true"`
- Interactive icons: paired with visible text label

## Responsive Breakpoints

| Prefix | Min-width | Typical use |
|--------|-----------|-------------|
| `sm`   | 640px     | 2-col grid, larger padding |
| `md`   | 768px     | sidebar layouts, nav changes |
| `lg`   | 1024px    | 3-col grid, full nav |
| `xl`   | 1280px    | max-width containers |

## Spacing & Rhythm

- Vertical rhythm: `space-y-8` for stacked content blocks
- Card gaps: `gap-5` (grid), `gap-6` (flex)
- Section padding: `py-16 sm:py-24`
- Container: `px-4 sm:px-6 lg:px-8`
- Inline elements: `gap-2` or `gap-3`

## Borders & Dividers

- Card borders: `border border-border`
- Section dividers: `border-t border-border` or `border-b border-border`
- Subtle separators: `divide-y divide-border`
- No heavy shadows — prefer border-based separation

## Motion

- Transitions: `transition-all duration-200 ease-out`
- Hover transforms: `hover:scale-[1.02] hover:shadow-md`
- Focus transitions: `focus:ring-2 focus:ring-primary/40`
- Reduced motion: `@media (prefers-reduced-motion: reduce)` disables animations

## Accessibility Tokens

- Focus visible: `outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2`
- Color contrast: all text meets WCAG AA (4.5:1 body, 3:1 large text)
- Touch targets: minimum `44x44px` for interactive elements
