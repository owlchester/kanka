

$(document).ready(function() {
    $('.summernote').summernote({
        hint: [{
            match: /\B@(\w*)$/,
            mentions: function(keyword, callback) {
                $.ajax({
                    url: $('#mention-route-entities').val() + '?q=' + keyword,
                    type: 'get',
                    async: true
                }).done(callback);
            },
            search: function (keyword, callback) {
                this.mentions(keyword, callback);
            },
            content: function (item) {
                if (item.url) {
                    if (item.tooltip) {
                        var str = '<a href="' + item.url + '" title="' + item.tooltip.replace(/["]/g, '\'') + '" data-toggle="tooltip" data-html="true" >' + item.fullname + '</a>';
                        return $(str)[0];
                    }
                    return $('<a href="' + item.url + '">' + item.fullname + '</a>')[0];
                }
                return item.fullname;
            },
            template: function (item) {
                return '' + (item.image ? item.image : '') + item.fullname + ' (' + item.type + ')';
            }
        },{
            match: /\B#(\w*)$/,
            mentions: function(keyword, callback) {
                $.ajax({
                    url: $('#mention-route-months').val() + '?q=' + keyword,
                    type: 'get',
                    async: true
                }).done(callback);
            },
            search: function (keyword, callback) {
                this.mentions(keyword, callback);
            },
            content: function (item) {
                return item.fullname;
            },
            template: function (item) {
                return item.fullname;
            }
        }],

    });
});


