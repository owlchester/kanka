// Mirrors MapMarker::icon code values (app/Models/MapMarker.php) — kept in sync with the
// icon buttons in ShapePicker.vue so preset badges can render the same glyph without a pin.
export const PIN_ICON_SHAPES = [
    { key: "pin", icon: 1, fa: "fa-solid fa-map-pin" },
    { key: "question", icon: 2, fa: "fa-solid fa-question" },
    { key: "exclamation", icon: 3, fa: "fa-solid fa-exclamation" },
    { key: "square", icon: 6, fa: "fa-solid fa-square" },
    { key: "circle", icon: 7, fa: "fa-solid fa-circle" },
    { key: "diamond", icon: 8, fa: "fa-solid fa-diamond" },
    { key: "triangle", icon: 9, fa: "fa-solid fa-caret-up" },
];

export const DEFAULT_PIN_ICON_FA = "fa-solid fa-map-pin";

export function pinIconFa(iconCode, customIcon) {
    if (customIcon) {
        return customIcon;
    }

    return PIN_ICON_SHAPES.find((shape) => shape.icon === Number(iconCode))?.fa || DEFAULT_PIN_ICON_FA;
}

// Maps App\Enums\MapMarkerShape ids to the same fa-regular icons Toolbar.vue uses for its
// mode buttons, so a non-pin preset's badge matches how you'd draw that shape from the toolbar.
export const SHAPE_ICON_BY_ID = {
    2: "fa-regular fa-font",
    3: "fa-regular fa-circle",
    5: "fa-regular fa-draw-polygon",
    6: "fa-regular fa-route",
};

// Reverse of App\Enums\MapMarkerShape — a preset's config.shape_id (int) back to the shape
// string pin.shape already uses everywhere in this app (see MapMarkerShape.php's case names).
export const SHAPE_STRING_BY_ID = {
    1: "marker",
    2: "label",
    3: "circle",
    5: "poly",
    6: "path",
};
