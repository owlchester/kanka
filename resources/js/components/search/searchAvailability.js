export function applySearchAvailability(current, available, message, fallbackMessage = '') {
    if (typeof available !== 'boolean') {
        return current;
    }

    return {
        available,
        message: available ? '' : (typeof message === 'string' && message ? message : fallbackMessage),
    };
}
