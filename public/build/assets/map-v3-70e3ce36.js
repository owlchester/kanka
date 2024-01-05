let c,y,p,b,g,w,r,l,i,d,a,h,x,k;const P=window.matchMedia("only screen and (max-width: 760px)");$(document).ready(function(){window.map.invalidateSize(),window.map.on("popupopen",function(e){window.initDialogs()}),$('a[href="#marker-pin"]').click(function(e){$('input[name="shape_id"]').val(1),$("#map-marker-bg-colour").show(),m()}),$('a[href="#marker-label"]').click(function(e){$('input[name="shape_id"]').val(2),$("#map-marker-bg-colour").hide(),m()}),$('a[href="#marker-circle"]').click(function(e){$('input[name="shape_id"]').val(3),$("#map-marker-bg-colour").show(),m()}),$('a[href="#marker-poly"]').click(function(e){$('input[name="shape_id"]').val(5),$("#map-marker-bg-colour").show(),m()}),$('a[href="#presets"]').click(function(e){A($(this).data("presets"))}),$('a[href="#form-markers"]').click(function(e){window.map.invalidateSize()}),S(),F(),O(),z(),B()});function S(){c=$("#map-body"),c.length!==0&&(y=$("#sidebar-map"),p=$("#sidebar-marker"),b=$("#map-marker-modal"),$("#map-marker-modal-title"),g=$("#map-marker-modal-content"),window.markerDetails=function(e){if(U(),P.matches){e=e+"?mobile=1",window.openDialog("map-marker-modal",e);return}fetch(e).then(n=>n.json()).then(n=>{p.html(n.body).show().parent().find(".spinner").hide(),j(),c.addClass("sidebar-open"),$(document).trigger("shown.bs.modal")})},H(),C())}function F(){$('select[name="size_id"]').change(function(n){this.value==6?($(".map-marker-circle-helper").hide(),$(".map-marker-circle-radius").show()):($(".map-marker-circle-radius").hide(),$(".map-marker-circle-helper").show())});let e=$("#map-marker-form");$("#entity-form").length===0&&$(".map-marker-edit-form").length===0||(e.unbind("submit").on("submit",function(){window.entityFormHasUnsavedChanges=!1}),C())}function U(){if(P.matches){g.find(".spinner").show(),g.find(".content").hide(),b.modal("toggle");return}c.removeClass("sidebar-collapse").addClass("sidebar-open"),y.hide(),p.html("").show(),p.parent().find(".spinner").show(),D()}function j(){$(".marker-close").click(function(e){p.hide(),y.show()})}const H=()=>{let e=document.getElementById("ticker-config");h=e.dataset.timeout,x=e.dataset.url,k=e.dataset.ts,setTimeout(M,h)},M=()=>{fetch(x+"?ts="+k).then(e=>e.json()).then(e=>{k=e.ts;for(let n in e.markers){let o=e.markers[n];window["marker"+o.id]&&window["marker"+o.id].setLatLng({lon:o.longitude,lat:o.latitude})}setTimeout(M,h)})},C=()=>{$(".map-legend-marker").click(function(e){e.preventDefault(),window.map.panTo(L.latLng($(this).data("lat"),$(this).data("lng"))),window[$(this).data("id")].openPopup()}),$("a.sidebar-toggle").click(function(){D()})};function D(){setTimeout(()=>{window.map.invalidateSize()},500)}function O(){$(".map-marker-entry-click").click(function(e){e.preventDefault(),$(this).parent().hide(),$(".map-marker-entry-entry").show()})}function B(){$(".btn-mode-enable").click(function(e){e.preventDefault(),window.exploreEditMode=!0,$("body").addClass("map-edit-mode")}),$(".btn-mode-disable").click(function(e){e.preventDefault(),window.exploreEditMode=!1,$("body").removeClass("map-edit-mode"),window.polygon&&window.map.removeLayer(window.polygon)}),$(".btn-mode-drawing").click(function(e){e.preventDefault(),E()})}function E(){window.drawingPolygon=!1,$("body").removeClass("map-drawing-mode"),window.openDialog("marker-modal")}function z(){$("#start-drawing-polygon").on("click",function(e){e.preventDefault(),window.exploreEditMode=!1,window.startNewPolygon(),window.showToast($(this).data("toast")),$("body").addClass("map-drawing-mode"),window.closeDialog("marker-modal")}),w=$("#reset-polygon"),w.click(function(e){e.preventDefault(),window.polygon&&window.map.removeLayer(window.polygon),$('textarea[name="custom_shape"]').val(""),w.hide(),window.startNewPolygon()}),window.map.on("editable:editing",function(e){_()&&(N(),e.layer.setStyle({weight:r,color:l,opacity:i,fillColor:d,fillOpacity:a}))})}window.startNewPolygon=function(){window.polygon=window.map.editTools.startPolygon();let e=!0;window.polygon.on("editable:dragend",window.markerUpdateHandler),window.polygon.on("editable:vertex:new",window.markerUpdateHandler),window.polygon.on("editable:vertex:dragend",window.markerUpdateHandler),window.polygon.on("editable:vertex:dragend",window.markerUpdateHandler),window.polygon.on("editable:drawing:end",function(n){e=!1}),window.polygon.on("click",function(n){e||E()})};window.setPolygonPosition=function(e){$('textarea[name="custom_shape"]').val(e)};window.markerUpdateHandler=function(e){_()?W(e):I()&&q(e)};const W=e=>{let n=e.target.getLatLngs();if(n.length===0)return;let o=[];n[0].forEach(t=>{o.push(t.lat.toFixed(3)+","+t.lng.toFixed(3))}),window.setPolygonPosition(o.join(" "))},q=e=>{let n=e.target._latlng;n&&($("#marker-latitude").val(n.lat.toFixed(3)),$("#marker-longitude").val(n.lng.toFixed(3)))},_=()=>{let e=document.getElementsByName("shape_id");return Number(e[0].value)===5},I=()=>{let e=document.getElementsByName("shape_id");return Number(e[0].value)===2};window.addPolygonPosition=function(e,n){let o=$('textarea[name="custom_shape"]'),t=o.val();t.length>0&&(t+=" "),o.val(t+e+","+n);let s=o.val().trim(" ").split(" "),f=[];s.forEach(T=>{let v=T.split(",");f.push([v[0],v[1]])},f),window.polygon&&window.map.removeLayer(window.polygon),N(),window.polygon=L.polygon(f,{weight:r,color:l,opacity:i,fillColor:d,fillOpacity:a,linecap:"round",linejoin:"round"}),window.polygon.addTo(window.map),w.show()};function N(){l=$('input[name="polygon_style[stroke]"]').val(),(!l||l.length<7)&&(l="red"),i=$('input[name="polygon_style[stroke-opacity]"]').val(),isNaN(i)||!i?i=1:i=i/100,d=$('input[name="colour"]').val(),(!d||d.length<7)&&(d="red"),a=$('input[name="opacity"]').val(),isNaN(a)?a=.5:a=a/100,r=$('input[name="polygon_style[stroke-width]"]').val(),(isNaN(r)||!r)&&(r=1)}function m(){$("#marker-main-fields").show(),$("#marker-footer").show()}function A(e){$("#marker-main-fields").hide(),$("#marker-footer").hide(),$(".marker-preset-list .fa-spinner").length!==0&&fetch(e).then(n=>n.text()).then(n=>{$(".marker-preset-list").html(n),G()})}function G(){$(".preset-use").on("click",function(e){e.preventDefault();let n=$(this).data("url");$(this).find(".fa-spin").show(),$.ajax({url:n,context:this}).done(function(o){$(this).find(".fa-spin").hide(),Object.keys(o.preset).forEach(t=>{let u=o.preset[t],s=$('[name="'+t+'"]');s.length!==0&&(t.endsWith("colour")?(s.val(u),document.querySelector('[name="'+t+'"]').dispatchEvent(new Event("input"))):s.val(u))}),$('a[href="#marker-pin"]').click()})})}const J=e=>{if(!window.exploreEditMode)return;let n=e.latlng,o=n.lat.toFixed(3),t=n.lng.toFixed(3);if(window.drawingPolygon){window.addPolygonPosition(o,t);return}$("#marker-latitude").val(o),$("#marker-longitude").val(t),window.openDialog("marker-modal")};window.handleExploreMapClick=J;