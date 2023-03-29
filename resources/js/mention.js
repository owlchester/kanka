import Tribute from "tributejs";


export default function dynamicMentions() {

    var remoteUrl;
    var fields;
    const SELECTOR = '.kanka-mentions'; //:not(.kanka-mentions-tribute)';

    fields = $(SELECTOR);
    if (fields.length === 0) {
        return;
    }
    remoteUrl = fields.first().data('remote');

    var tribute = new Tribute({
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

    tribute.attach(document.querySelectorAll(SELECTOR));
    //$(SELECTOR).addClass('kanka-mentions-tribute');

    function remoteSearch(text, cb) {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
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


