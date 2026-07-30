export function initialMarkerPanelState(pin, variant) {
    return {
        name: pin?.name || "",
        detailLevel: variant === "edit" ? "full" : "light",
        isDraggable: !!pin?.isDraggable,
        cssClass: pin?.css || "",
    };
}
