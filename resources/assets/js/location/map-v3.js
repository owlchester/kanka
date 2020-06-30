var map;
var source;
var base;
var bounds;
var baseMaps;
var icons = {};
var layers = {};
var mapLayers = [];

$(document).ready(function() {



    window.map.invalidateSize();

    // Event fired when clicking on an existing map point

    $('a[href="#marker-pin"]').click(function (e) {
        $('input[name="shape_id"]').val(1);
    });
    $('a[href="#marker-label"]').click(function (e) {
        $('input[name="shape_id"]').val(2);
    });
    $('a[href="#marker-circle"]').click(function (e) {
        $('input[name="shape_id"]').val(3);
    });
    $('a[href="#marker-poly"]').click(function (e) {
        $('input[name="shape_id"]').val(5);
    });


});
