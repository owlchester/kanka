let p,h,a,i,c,r,s,f,l,u;const v=document.getElementById("subscribe-confirm"),L=()=>{b(),E(),window.onEvent(function(){y()})},b=()=>{const e=document.getElementById("stripe-token");p=Stripe(e.value),h=p.elements()},y=()=>{var n;if(i=document.querySelector(".subscription-confirm-button"),document.getElementById("card-element")){if(!a){let o={base:{color:"#555555",fontFamily:'"Helvetica Neue", Helvetica, sans-serif',fontSmoothing:"antialiased",fontSize:"14px","::placeholder":{color:"#777777"}},invalid:{color:"#fa755a",iconColor:"#fa755a"}};a=h.create("card",{hidePostalCode:!0,style:o})}a.mount("#card-element")}(n=document.getElementById("subscription-confirm"))==null||n.addEventListener("submit",S),c=document.getElementById("coupon-check"),c&&(r=document.getElementById("coupon-success"),s=document.getElementById("coupon-invalid"),f=document.getElementById("coupon"),l=document.getElementById("coupon-validating"),u=document.querySelector(".paypal-coupon"),c.addEventListener("change",g),c.addEventListener("focusout",g))},g=e=>{const n=e.target,o=n.value,d=n.dataset.url;o||(i.classList.remove("btn-disabled","loading"),i.disabled=!1),l.classList.remove("hidden"),fetch(d+"?coupon="+o).then(t=>t.json()).then(t=>{if(i.classList.remove("btn-disabled","loading"),i.disabled=!1,l.classList.add("hidden"),!t.valid){r.classList.add("hidden"),s.innerHTML=t.error,s.classList.remove("hidden"),f.value="",v.classList.remove("valid-coupon"),u.classList.add("hidden");return}document.getElementById("pricing-now").innerHTML=t.price,s.classList.add("hidden"),r.innerHTML=t.discount,r.classList.remove("hidden"),f.value=t.coupon,v.classList.add("valid-coupon"),u.classList.remove("hidden")}).catch(t=>{l.classList.add("hidden"),t.responseJSON&&(s.innerHTML=t.responseJSON.message,s.classList.remove("hidden")),u.classList.add("hidden")})},S=e=>{const n=e.target;e.preventDefault(),I(e);const o=document.querySelector('input[name="subscription-intent-token"]'),d=document.querySelector(".alert-error");d.classList.add("hidden");const t=document.querySelector('input[name="payment_id"]');if(t.value)return n.submit(),!1;p.confirmCardSetup(o.value,{payment_method:{card:a,billing_details:{name:document.querySelector('input[name="card-holder-name"]').value}}}).then((function(m){if(m.error)return i.classList.remove("disabled","loading"),i.disabled="",d.innerHTML=m.error.message,d.classList.remove("hidden"),!1;t.value=m.setupIntent.payment_method,n.submit()}).bind(globalThis))};function E(){const e=document.getElementById("pricing-overview"),n=document.querySelector('input[name="period"]');n.addEventListener("change",function(){this.checked?(e.classList.remove("period-month"),e.classList.add("period-year")):(e.classList.remove("period-year"),e.classList.add("period-month"))}),n.checked&&(e.classList.remove("period-month"),e.classList.add("period-year"))}const I=e=>{const o=e.target.querySelector(".subscription-confirm-button");return o.classList.add("disabled","loading"),o.disabled=!0,!0};L();