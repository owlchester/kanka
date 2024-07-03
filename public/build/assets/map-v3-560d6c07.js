const f=document.querySelector("#map-body"),S=document.querySelector("#sidebar-map"),d=document.querySelector("#sidebar-marker");document.querySelector("#map-marker-modal");let g,s,u,r,m,a,k,q,h;const b=window.matchMedia("only screen and (max-width: 760px)"),p=document.querySelector('input[name="shape_id"]'),N=()=>{var t,o;const e=document.querySelector('a[href="#marker-pin"]');e&&(e.addEventListener("click",function(){p.value=1,document.querySelector("#map-marker-bg-colour").classList.remove("hidden"),y()}),document.querySelector('a[href="#marker-label"]').addEventListener("click",function(){p.value=2,document.querySelector("#map-marker-bg-colour").classList.add("hidden"),y()}),document.querySelector('a[href="#marker-circle"]').addEventListener("click",function(){p.value=3,document.querySelector("#map-marker-bg-colour").classList.remove("hidden"),y()}),document.querySelector('a[href="#marker-poly"]').addEventListener("click",function(){p.value=5,document.querySelector("#map-marker-bg-colour").classList.remove("hidden"),y()}),(t=document.querySelector('a[href="#presets"]'))==null||t.addEventListener("click",function(n){G(n.target.dataset.presets)}),(o=document.querySelector('a[href="#form-markers"]'))==null||o.addEventListener("click",function(){window.map.invalidateSize()}))},F=()=>{f&&(window.markerDetails=function(e){if(_(),b.matches){e=e+"?mobile=1",window.openDialog("map-marker-modal",e);return}fetch(e).then(t=>t.json()).then(t=>{d.innerHTML=t.body,d.classList.remove("hidden"),d.parentNode.querySelector(".spinner").classList.add("hidden"),U(),f.classList.add("sidebar-open"),window.triggerEvent()})},z(),x(),$(document).on("expanded.pushMenu collapsed.pushMenu",function(){window.map.invalidateSize()}))},C=()=>{N(),H(),B();const e=document.querySelector("#map-marker-form"),t=document.querySelector(".map-marker-edit-form");!e&&!t||(e.onsubmit=function(){window.entityFormHasUnsavedChanges=!1},x())},H=()=>{const e=document.querySelector('select[name="size_id"]');e&&e.addEventListener("change",function(t){e.value==6?(document.querySelector(".map-marker-circle-helper").classList.add("hidden"),document.querySelector(".map-marker-circle-radius").classList.remove("hidden")):(document.querySelector(".map-marker-circle-radius").classList.add("hidden"),document.querySelector(".map-marker-circle-helper").classList.remove("hidden"))})},_=()=>{b.matches||(f.classList.remove("sidebar-collapse"),f.classList.add("sidebar-open"),S.classList.add("hidden"),d.innerHTML="",d.classList.remove("hidden"),d.parentNode.querySelector(".spinner").classList.remove("hidden"),P())},U=()=>{var e;(e=document.querySelector(".marker-close"))==null||e.addEventListener("click",function(){d.classList.add("hidden"),S.classList.remove("hidden")})},z=()=>{const e=document.getElementById("ticker-config");k=e.dataset.timeout,q=e.dataset.url,h=e.dataset.ts,setTimeout(E,k)},E=()=>{fetch(q+"?ts="+h).then(e=>e.json()).then(e=>{h=e.ts;for(let t in e.markers){let o=e.markers[t];window["marker"+o.id]&&window["marker"+o.id].setLatLng({lon:o.longitude,lat:o.latitude})}setTimeout(E,k)})},x=()=>{var e,t;(e=document.querySelectorAll(".map-legend-marker"))==null||e.forEach(o=>{o.addEventListener("click",function(n){n.preventDefault(),window.map.panTo(L.latLng(o.dataset.lat,o.dataset.lng)),window[o.dataset.id].openPopup()})}),(t=document.querySelector("a.sidebar-toggle"))==null||t.addEventListener("click",function(){P()})},P=()=>{setTimeout(()=>{window.map.invalidateSize()},500)},O=()=>{var e;(e=document.querySelector(".map-marker-entry-click"))==null||e.addEventListener("click",function(t){t.preventDefault(),t.target.parentNode.classList.add("hidden"),document.querySelector(".map-marker-entry-entry").classList.remove("hidden")})},j=()=>{const e=document.querySelector(".btn-mode-enable");e&&(e.addEventListener("click",function(t){t.preventDefault(),window.exploreEditMode=!0,document.querySelector("body").classList.add("map-edit-mode")}),document.querySelector(".btn-mode-disable").addEventListener("click",function(t){t.preventDefault(),window.exploreEditMode=!1,document.querySelector("body").classList.remove("map-edit-mode"),window.polygon&&window.map.removeLayer(window.polygon)}),document.querySelector(".btn-mode-drawing").addEventListener("click",function(t){t.preventDefault(),M()}))},M=()=>{window.drawingPolygon=!1,document.querySelector("body").classList.remove("map-drawing-mode"),window.openDialog("marker-modal")},B=()=>{const e=document.querySelector("#start-drawing-polygon");e&&(e.addEventListener("click",function(t){t.preventDefault(),window.exploreEditMode=!1,window.startNewPolygon(),window.showToast(t.target.dataset.toast),document.querySelector("body").classList.add("map-drawing-mode"),window.closeDialog("marker-modal")}),g=document.querySelector("#reset-polygon"),g.addEventListener("click",function(t){t.preventDefault(),window.polygon&&window.map.removeLayer(window.polygon),document.querySelector('textarea[name="custom_shape"]').value="",g.classList.add("hidden"),window.startNewPolygon()}),window.map.on("editable:editing",function(t){D()&&(T(),t.layer.setStyle({weight:s,color:u,opacity:r,fillColor:m,fillOpacity:a}))}))};window.startNewPolygon=function(){window.polygon=window.map.editTools.startPolygon();let e=!0;window.polygon.on("editable:dragend",window.markerUpdateHandler),window.polygon.on("editable:vertex:new",window.markerUpdateHandler),window.polygon.on("editable:vertex:dragend",window.markerUpdateHandler),window.polygon.on("editable:vertex:dragend",window.markerUpdateHandler),window.polygon.on("editable:drawing:end",function(t){e=!1}),window.polygon.on("click",function(t){e||M()})};window.setPolygonPosition=function(e){let t=document.querySelector('textarea[name="custom_shape"]');t.value=e};window.markerUpdateHandler=function(e){D()?A(e):I()&&W(e)};const A=e=>{let t=e.target.getLatLngs();if(t.length===0)return;let o=[];t[0].forEach(n=>{o.push(n.lat.toFixed(3)+","+n.lng.toFixed(3))}),window.setPolygonPosition(o.join(" "))},W=e=>{let t=e.target._latlng;t&&(document.querySelector("#marker-latitude").value=t.lat.toFixed(3),document.querySelector("#marker-longitude").value=t.lng.toFixed(3))},D=()=>Number(p.value)===5,I=()=>Number(p.value)===2;window.addPolygonPosition=function(e,t){const o=document.querySelector('textarea[name="custom_shape"]');let n=o.value;n.length>0&&(n+=" "),o.value=n+e+","+t;let l=o.value.trim(" ").split(" "),c=[];l.forEach(w=>{let v=w.split(",");c.push([v[0],v[1]])},c),window.polygon&&window.map.removeLayer(window.polygon),T(),window.polygon=L.polygon(c,{weight:s,color:u,opacity:r,fillColor:m,fillOpacity:a,linecap:"round",linejoin:"round"}),window.polygon.addTo(window.map),g.classList.remove("hidden")};const T=()=>{var e;u=(e=document.querySelector('input[name="polygon_style[stroke]"]'))==null?void 0:e.value,(!u||u.length<7)&&(u="red"),r=document.querySelector('input[name="polygon_style[stroke-opacity]"]').value,isNaN(r)||!r?r=1:r=r/100,m=document.querySelector('input[name="colour"]').value,(!m||m.length<7)&&(m="red"),a=document.querySelector('input[name="opacity"]').value,isNaN(a)?a=.5:a=a/100,s=document.querySelector('input[name="polygon_style[stroke-width]"]').value,(isNaN(s)||!s)&&(s=1)},y=()=>{var e,t;(e=document.querySelector("#marker-main-fields"))==null||e.classList.remove("hidden"),(t=document.querySelector("#marker-footer"))==null||t.classList.remove("hidden")},G=e=>{var o,n;(o=document.querySelector("#marker-main-fields"))==null||o.classList.add("hidden"),(n=document.querySelector("#marker-footer"))==null||n.classList.add("hidden");const t=document.querySelector(".marker-preset-list");t.dataset.loaded!=="1"&&(t.dataset.loaded="1",fetch(e).then(i=>i.text()).then(i=>{t.innerHTML=i,J()}))},J=()=>{var e;(e=document.querySelectorAll(".preset-use"))==null||e.forEach(t=>{t.addEventListener("click",function(o){o.preventDefault();let n=t.dataset.url;t.classList.add("loading"),axios.get(n).then(i=>{t.classList.remove("loading"),Object.keys(i.data.preset).forEach(l=>{let c=i.data.preset[l],w=document.querySelector('[name="'+l+'"]');w&&(l.endsWith("colour")?(w.value=c,document.querySelector('[name="'+l+'"]').dispatchEvent(new Event("input"))):w.value=c)}),document.querySelector('a[href="#marker-pin"]').click()})})})};function K(e){if(!window.exploreEditMode)return;let t=e.latlng,o=t.lat.toFixed(3),n=t.lng.toFixed(3);if(window.drawingPolygon){window.addPolygonPosition(o,n);return}document.querySelector("#marker-latitude").value=o,document.querySelector("#marker-longitude").value=n,window.openDialog("marker-modal")}window.handleExploreMapClick=K;window.map.invalidateSize();window.map.on("popupopen",function(e){window.initDialogs()});F();C();O();j();
