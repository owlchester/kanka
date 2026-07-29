export function upsertPin(pins, pin) {
    const existingIndex = pins.findIndex((existingPin) => existingPin.id === pin.id)

    if (existingIndex === -1) {
        return [...pins, pin]
    }

    return pins.reduce((result, existingPin, index) => {
        if (existingPin.id !== pin.id) {
            result.push(existingPin)
        } else if (index === existingIndex) {
            result.push(pin)
        }

        return result
    }, [])
}
