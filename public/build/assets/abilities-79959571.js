import{b as t,c as i,a as s,n as b,e as a,F as u,r as _,g as x,h as f,i as y,p as v}from"./vue.esm-bundler-77726dd6.js";import{m as k}from"./mitt-f7ef348c.js";import{_ as h}from"./_plugin-vue_export-helper-c27b6911.js";const p={props:["ability","permission","meta","trans"],data(){return{details:!1}},computed:{hasAttribute:function(){return this.ability.attributes.length>0},canDelete:function(){return this.permission},backgroundImage:function(){return this.ability.images.thumb?{backgroundImage:"url("+this.ability.images.thumb+")"}:{}}},methods:{updateAbility:function(n){window.openDialog("abilities-dialog",n.actions.edit)},remainingNumber:function(){return this.ability.charges-this.ability.used_charges},remainingText:function(){return this.ability.i18n.left.replace(/:amount/,"")},useCharge:function(n,c){c>n.used_charges?n.used_charges+=1:n.used_charges-=1,axios.post(n.actions.use,{used:n.used_charges}).then(e=>{e.data.success||(n.used_charges-=1)}).catch(()=>{n.used_charges-=1})}}},T=["data-tags"],L={class:"ability-box p-4 rounded bg-box shadow-xs flex flex-col md:flex-row items-center md:items-start gap-2 md:gap-4"},H={key:0,class:""},M=["href"],w={class:"flex flex-col gap-4 w-full"},C={class:"flex gap-2 md:gap-4 items-center w-full"},A={class:"flex gap-2 items-center text-xl grow"},I=["href","innerHTML"],B=["title"],N=["title"],j=["title"],D=["title"],z=["title"],F=["innerHTML"],P={key:1,class:""},V=["title"],E=s("i",{class:"fa-solid fa-pencil text-xl","aria-hidden":"true"},null,-1),S=["innerHTML"],q={key:0,class:"visible md:hidden"},G=["innerHTML"],J=["innerHTML"],K={key:2,class:"flex gap-2 items-center"},O=["href","innerHTML"],Q=["innerHTML"],R={key:4,class:"flex gap-2 md:gap-4 ability-charges w-full items-end"},U={class:"flex gap-1 flex-wrap grow"},W=["onClick"],X=["innerHTML"],Y={class:"flex-none"},Z=["innerHTML"],$=["innerHTML"];function ee(n,c,e,g,d,o){return t(),i("div",{class:"ability","data-tags":e.ability.class},[s("div",L,[e.ability.images.has?(t(),i("div",H,[s("a",{class:"ability-image rounded-xl block w-40 h-40 cover-background",href:e.ability.images.url,style:b(o.backgroundImage)},null,12,M)])):a("",!0),s("div",w,[s("div",C,[s("div",A,[s("a",{href:e.ability.actions.view,class:"ability-name text-2xl",innerHTML:e.ability.name},null,8,I),e.ability.visibility_id===2?(t(),i("i",{key:0,class:"fa-solid fa-lock",title:e.ability.visibility},null,8,B)):a("",!0),e.ability.visibility_id===3?(t(),i("i",{key:1,class:"fa-solid fa-user-lock",title:e.ability.visibility},null,8,N)):a("",!0),e.ability.visibility_id===5?(t(),i("i",{key:2,class:"fa-solid fa-users",title:e.ability.visibility},null,8,j)):a("",!0),e.ability.visibility_id===4?(t(),i("i",{key:3,class:"fa-solid fa-user-secret",title:e.ability.visibility},null,8,D)):a("",!0),e.ability.visibility_id===1?(t(),i("i",{key:4,class:"fa-solid fa-eye",title:e.ability.visibility},null,8,z)):a("",!0)]),e.ability.type?(t(),i("div",{key:0,class:"hidden md:inline bg-base-200 p-2 rounded-xl flex-none",innerHTML:e.ability.type},null,8,F)):a("",!0),e.permission?(t(),i("div",P,[this.canDelete?(t(),i("a",{key:0,role:"button",onClick:c[0]||(c[0]=l=>o.updateAbility(e.ability)),class:"btn2 btn-ghost btn-sm",title:e.ability.i18n.edit},[E,s("span",{class:"sr-only",innerHTML:e.ability.i18n.edit},null,8,S)],8,V)):a("",!0)])):a("",!0)]),e.ability.type?(t(),i("div",q,[s("div",{class:"inline-block bg-base-200 p-2 rounded-xl",innerHTML:e.ability.type},null,8,G)])):a("",!0),e.ability.entry?(t(),i("div",{key:1,class:"entity-content",innerHTML:e.ability.entry},null,8,J)):a("",!0),e.ability.tags?(t(),i("div",K,[(t(!0),i(u,null,_(e.ability.tags,l=>(t(),i("a",{class:"rounded-lg bg-base-200 text-xs py-1 px-2 text-base-content",href:l.url,innerHTML:l.name},null,8,O))),256))])):a("",!0),e.ability.note?(t(),i("div",{key:3,class:"entity-content",innerHTML:e.ability.note},null,8,Q)):a("",!0),e.ability.charges&&e.permission?(t(),i("div",R,[s("div",U,[(t(!0),i(u,null,_(e.ability.charges,l=>(t(),i("div",{class:x(["charge cursor-pointer rounded-full p-2 hover:bg-accent hover:text-accent-content w-8 h-8 flex items-center justify-center",{"bg-base-200 charge-used":e.ability.used_charges>=l}]),onClick:r=>o.useCharge(e.ability,l)},[s("span",{innerHTML:l},null,8,X)],10,W))),256))]),s("div",Y,[s("span",{class:"text-2xl",innerHTML:o.remainingNumber()},null,8,Z),s("span",{innerHTML:o.remainingText()},null,8,$)])])):a("",!0)])])],8,T)}const te=h(p,[["render",ee]]),ie={components:{Ability:te},props:["group","permission","meta"],data(){return{collapsed:!1}},computed:{backgroundImage:function(){return this.group.has_image?{backgroundImage:"url("+this.group.image+")"}:{}}},methods:{click:function(n){this.collapsed=!this.collapsed}}},se={class:"ability-parent flex flex-col gap-5 w-full"},ne={class:"parent-head flex gap-2 md:gap-5 items-center"},ae={class:"flex flex-col gap-1 grow overflow-hidden"},le={key:0},oe=["href","innerHTML"],ce=["innerHTML"],re=["innerHTML"],de={class:"flex-none self-end"},ue={key:0,"aria-hidden":"true",class:"fa-thin fa-chevron-circle-up fa-2x"},_e={key:1,"aria-hidden":"true",class:"fa-thin fa-chevron-circle-down fa-2x"},he={key:0,class:"parent-abilities flex flex-col gap-5"};function me(n,c,e,g,d,o){const l=y("ability");return t(),i("div",se,[s("div",ne,[e.group.has_image?(t(),i("div",{key:0,class:"parent-image rounded-full w-12 h-12 md:w-16 md:h-16 cover-background flex-none",style:b(o.backgroundImage)},null,4)):a("",!0),s("div",ae,[e.group.url?(t(),i("div",le,[s("a",{href:e.group.url,innerHTML:e.group.name,class:"parent-name text-xl md:text-2xl"},null,8,oe)])):(t(),i("span",{key:1,class:"parent-name text-xl md:text-2xl",innerHTML:e.group.name},null,8,ce)),s("p",{class:"md:text-lg truncate",innerHTML:e.group.type},null,8,re)]),s("div",de,[s("span",{role:"button",onClick:c[0]||(c[0]=r=>o.click(e.group)),class:"cursor-pointer inline-block"},[this.collapsed?(t(),i("i",_e)):(t(),i("i",ue))])])]),this.collapsed?a("",!0):(t(),i("div",he,[(t(!0),i(u,null,_(e.group.abilities,r=>(t(),f(l,{key:r.id,ability:r,permission:e.permission,meta:e.meta},null,8,["ability","permission","meta"]))),128))]))])}const ge=h(ie,[["render",me]]),be={props:["id","api","permission"],components:{Parent:ge},data(){return{groups:[],meta:[],loading:!0,waiting:!1}},methods:{getAbilities:function(){fetch(this.api).then(n=>n.json()).then(n=>{this.groups=n.data.groups,this.meta=n.data.meta,this.loading=!1,this.waiting=!1})}},mounted(){this.getAbilities()},updated(){window.ajaxTooltip()}},fe={class:"viewport box-abilities relative flex flex-col gap-5"},ye={key:0,class:"load more text-center text-2xl"},xe=s("i",{class:"fa-solid fa-spin fa-spinner","aria-hidden":"true"},null,-1),ve=[xe],ke={class:"flex gap-5 flex-wrap"};function pe(n,c,e,g,d,o){const l=y("parent");return t(),i("div",fe,[d.loading?(t(),i("div",ye,ve)):a("",!0),s("div",ke,[(t(!0),i(u,null,_(d.groups,r=>(t(),f(l,{key:r.id,group:r,permission:e.permission,meta:d.meta},null,8,["group","permission","meta"]))),128))])])}const Te=h(be,[["render",pe]]),Le=k(),m=v({});m.config.globalProperties.emitter=Le;m.component("abilities",Te);m.mount("#abilities");
