const r=document.querySelector(".character-organisations"),i=document.querySelector("#add_organisation"),c=document.querySelector("#template_organisation"),s=()=>{r&&(i.addEventListener("click",function(n){var e;n.preventDefault();const t=document.createElement("div");return t.classList.add("parent-row"),t.innerHTML=c.innerHTML,r.append(t),(e=r.querySelectorAll(".tmp-org"))==null||e.forEach(a=>{a.classList.remove("tmp-org"),a.classList.add("select2")}),o(),window.triggerEvent(),!1}),o())},o=()=>{const n=document.querySelectorAll(".member-delete");n==null||n.forEach(t=>{t.dataset.init!=="1"&&(t.dataset.init="1",t.addEventListener("click",e=>{e.preventDefault(),t.closest(t.dataset.target).remove()}),t.addEventListener("keydown",e=>{e.key==="Enter"&&t.click()}))}),window.initSortable(),window.initForeignSelect()};s();
