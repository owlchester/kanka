(()=>{"use strict";function e(){$.each($(".delete-confirm"),(function(){$(this).click((function(e){var a=$(this).data("name"),n=$(this).data("delete-target"),i=$(this).data("target");$(i).find(".target-name").text(a),$(this).data("mirrored")?$("#delete-confirm-mirror").show():$("#delete-confirm-mirror").hide(),$(this).data("recoverable")?($(i).find(".permanent").hide(),$(i).find(".recoverable").show()):($(i).find(".recoverable").hide(),$(i).find(".permanent").show()),n&&$(".delete-confirm-submit").data("target",n)}))})),$.each($(".delete-confirm-submit"),(function(e){$(this).unbind("click"),$(this).click((function(e){var a=$(this).data("target");a?($("#"+a+" input[name=remove_mirrored]").val($("#delete-confirm-mirror-checkbox").is(":checked")?1:0),$("#"+a).submit()):$("#delete-confirm-form").submit()}))}))}var a,n,i,o,t,r,d,l,c,m,s,p;function h(){$(".map-legend-marker").click((function(e){e.preventDefault(),window.map.panTo(L.latLng($(this).data("lat"),$(this).data("lng"))),window[$(this).data("id")].openPopup()})),$("a.sidebar-toggle").click((function(){u()}))}function u(){setTimeout((function(){window.map.invalidateSize()}),500)}$(document).ready((function(){window.map.invalidateSize(),window.map.on("popupopen",(function(a){e()})),$('a[href="#marker-pin"]').click((function(e){$('input[name="shape_id"]').val(1),$("#map-marker-bg-colour").show()})),$('a[href="#marker-label"]').click((function(e){$('input[name="shape_id"]').val(2),$("#map-marker-bg-colour").hide()})),$('a[href="#marker-circle"]').click((function(e){$('input[name="shape_id"]').val(3),$("#map-marker-bg-colour").show()})),$('a[href="#marker-poly"]').click((function(e){$('input[name="shape_id"]').val(5),$("#map-marker-bg-colour").show()})),$('a[href="#form-markers"]').click((function(e){window.map.invalidateSize()})),function(){if(0===(a=$("#map-body")).length)return;n=$("#sidebar-map"),i=$("#sidebar-marker"),o=$("#map-marker-modal"),r=$("#map-marker-modal-title"),t=$("#map-marker-modal-content"),window.markerDetails=function(d){!function(){if(window.kankaIsMobile.matches)return t.find(".spinner").show(),t.find(".content").hide(),void o.modal("toggle");a.removeClass("sidebar-collapse").addClass("sidebar-open"),n.hide(),i.html("").show(),i.parent().find(".spinner").show(),u()}(),window.kankaIsMobile.matches&&(d+="?mobile=1"),$.ajax({url:d,type:"GET",async:!0,success:function(o){o&&(window.kankaIsMobile.matches?(r.html(o.name),t.find(".content").html(o.body).show(),t.find(".spinner").hide()):(i.html(o.body).show().parent().find(".spinner").hide(),$(".marker-close").click((function(e){i.hide(),n.show()})),a.addClass("sidebar-open")),e())}})},h()}(),function(){$('select[name="size_id"]').change((function(e){6==this.value?($(".map-marker-circle-helper").hide(),$(".map-marker-circle-radius").show()):($(".map-marker-circle-radius").hide(),$(".map-marker-circle-helper").show())})),$('input[name="custom_icon"]').on("paste",(function(e){var a;if(e.preventDefault(),e.clipboardData||e.originalEvent.clipboardData?a=(e.originalEvent||e).clipboardData.getData("text/plain"):window.clipboardData&&(a=window.clipboardData.getData("Text")),a.startsWith('<i class="fa')||a.startsWith('<i class="ra')){var n=$(a).attr("class");if(n)return void $(this).val(n)}$(this).val(a)}));var e=$("#map-marker-form");if(0===$("#entity-form").length&&0===$(".map-marker-edit-form").length)return;e.unbind("submit").on("submit",(function(){window.entityFormHasUnsavedChanges=!1})),h()}(),$(".map-marker-entry-click").click((function(e){e.preventDefault(),$(this).parent().hide(),$(".map-marker-entry-entry").show()})),$("#start-drawing-polygon").on("click",(function(e){e.preventDefault(),window.drawingPolygon=!0,window.showToast($(this).data("toast")),$("body").addClass("map-drawing-mode"),$("#marker-modal").modal("hide")})),(d=$("#reset-polygon")).click((function(e){e.preventDefault(),window.polygon&&window.map.removeLayer(window.polygon),$('textarea[name="custom_shape"]').val(""),d.hide()})),$(".btn-mode-enable").click((function(e){e.preventDefault(),window.exploreEditMode=!0,$("body").addClass("map-edit-mode")})),$(".btn-mode-disable").click((function(e){e.preventDefault(),window.exploreEditMode=!1,$("body").removeClass("map-edit-mode")})),$(".btn-mode-drawing").click((function(e){e.preventDefault(),window.drawingPolygon=!1,$("body").removeClass("map-drawing-mode"),$("#marker-modal").modal("show")}))})),window.addPolygonPosition=function(e,a){var n=$('textarea[name="custom_shape"]'),i=n.val();i.length>0&&(i+=" "),n.val(i+e+","+a);var o=n.val().trim(" ").split(" "),t=[];o.forEach((function(e){var a=e.split(",");t.push([a[0],a[1]])}),t),window.polygon&&window.map.removeLayer(window.polygon),function(){(!(c=$('input[name="polygon_style[stroke]"]').val())||c.length<7)&&(c="red");m=$('input[name="polygon_style[stroke-opacity]"]').val(),isNaN(m)||!m?m=1:m/=100;(!(s=$('input[name="colour"]').val())||s.length<7)&&(s="red");p=$('input[name="opacity"]').val(),isNaN(p)?p=.5:p/=100;l=$('input[name="polygon_style[stroke-width]"]').val(),(isNaN(l)||!l)&&(l=1)}(),window.polygon=L.polygon(t,{weight:l,color:c,opacity:m,fillColor:s,fillOpacity:p,linecap:"round",linejoin:"round"}),window.polygon.addTo(window.map),d.show()}})();
//# sourceMappingURL=map-v3.js.map