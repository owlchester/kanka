import Tribute from "tributejs";


export default function dynamicMentions() {

    const SELECTOR = '.kanka-mentions'; //:not(.kanka-mentions-tribute)';
    const firstField = document.querySelector(SELECTOR);
    if (!firstField) {
        return;
    }
    const remoteUrl = firstField.dataset.remote;

    const tribute = new Tribute({
        values: function (text, cb) {
            remoteSearch(text, users => cb(users));
        },
        lookup: 'name',
        menuShowMinLength: 3,
        selectTemplate: function(item) {
            return '[' + item.original.model_type + ':' + item.original.id + ']';
        },
        noMatchTemplate: function () {
            return null;
        },
    });

    let targets = document.querySelectorAll(SELECTOR);
    targets.forEach(el => {
        // Don't attach twice or to templates
        if (el.dataset.mentions === "1") {
            return;
        }
        el.dataset.mentions = 1;
        tribute.attach(el);
    });

    function remoteSearch(text, cb) {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    let data = JSON.parse(xhr.responseText);
                    cb(data);
                } else if (xhr.status === 403) {
                    cb([]);
                }
            }
        };
        let fullUrl = remoteUrl + '?q=' + text;
        xhr.open("GET", fullUrl, true);
        xhr.send();
    }

}


