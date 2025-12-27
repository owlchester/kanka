// language: typescript
type HSL = { h: number; s: number; l: number; a?: number };

function readCssVar(name: string): string {
    return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
}

function hslFromVar(varName: string): HSL | null {
    // Expect var to be like: "215 56% 59%" or possibly "215 56% 59% / 0.9"
    const raw = readCssVar(varName);
    if (!raw) return null;
    // Normalize spaces and split by '/' for alpha if present
    const [main, alpha] = raw.split('/').map(s => s.trim());
    const parts = main.split(/\s+/);
    if (parts.length < 3) return null;
    const h = Number(parts[0]);
    const s = Number(parts[1].replace('%', ''));
    const l = Number(parts[2].replace('%', ''));
    return { h, s, l, a: alpha ? Number(alpha) : undefined };
}

function hslString(hsl: HSL) {
    if (typeof hsl.a === 'number') {
        return `hsl(${hsl.h} ${hsl.s}% ${hsl.l}% / ${hsl.a})`;
    }
    return `hsl(${hsl.h} ${hsl.s}% ${hsl.l}%)`;
}

function tweakHsl(hsl: HSL, { dh = 0, ds = 0, dl = 0, a }: { dh?: number; ds?: number; dl?: number; a?: number } = {}) {
    const clamp = (v: number, lo = 0, hi = 100) => Math.min(hi, Math.max(lo, v));
    return {
        h: (hsl.h + dh + 360) % 360,
        s: clamp(hsl.s + ds),
        l: clamp(hsl.l + dl),
        a: typeof a === 'number' ? a : hsl.a,
    } as HSL;
}


function cssVariable (variable: string){
    const base = hslFromVar(variable);
    if (!base) return `hsl(${readCssVar('--p')})`;
    return hslString(base);
}

export { hslFromVar, hslString, tweakHsl, readCssVar, cssVariable };
