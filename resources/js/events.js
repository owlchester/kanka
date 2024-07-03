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
