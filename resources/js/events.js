const defaultKey = 'kanka.default';
window.triggerEvent = function (key) {
    key = key || defaultKey;
    const event = new Event(key);
    document.dispatchEvent(event);
};

window.onEvent = function(callback, key) {
    key = key || defaultKey;
    document.addEventListener(key, callback);
};

// Sometimes we want assets to finish loading, like an image
window.onReady = function (fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
};
