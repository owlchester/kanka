import{c as r,a as t,f as u,F as c,g as m,h as k,p as y,w as h,v as b,j as g,b as i,t as a,q as v}from"./vue.esm-bundler-Dgt_CrCE.js";import{_ as x}from"./_plugin-vue_export-helper-DlAUqK2U.js";const w={data(){return{clients:[],confirmClient:null,createForm:{errors:[],name:"",redirect:""},editForm:{errors:[],name:"",redirect:""}}},ready(){this.prepareComponent()},mounted(){this.prepareComponent()},methods:{prepareComponent(){this.getClients()},getClients(){axios.get("/oauth/clients").then(l=>{this.clients=l.data})},showCreateClientForm(){this.openModal("createModal"),this.$refs.createName.focus()},store(){this.persistClient("post","/oauth/clients",this.createForm,"createModal")},edit(l){this.editForm.id=l.id,this.editForm.name=l.name,this.editForm.redirect=l.redirect,this.openModal("editModal"),this.$refs.editName.focus()},update(){this.persistClient("put","/oauth/clients/"+this.editForm.id,this.editForm,"editModal")},persistClient(l,e,d,p){d.errors=[],axios[l](e,d).then(n=>{this.getClients(),d.name="",d.redirect="",d.errors=[],this.closeModal(p)}).catch(n=>{typeof n.response.data=="object"?d.errors=_.flatten(_.toArray(n.response.data.errors)):d.errors=["Something went wrong. Please try again."]})},destroy(l){axios.delete("/oauth/clients/"+l.id).then(e=>{this.getClients(),window.showToast("OAuth client deleted succesfully.")})},openModal(l){this.$refs[l].showModal(),this.$refs[l].addEventListener("click",function(e){let d=this.getBoundingClientRect();!(d.top<=e.clientY&&e.clientY<=d.top+d.height&&d.left<=e.clientX&&e.clientX<=d.left+d.width)&&e.target.tagName==="DIALOG"&&this.close()})},closeModal(l){this.$refs[l].close()},deleteConfirm(l){if(this.confirmClient&&l.id===this.confirmClient.id)return this.destroy(l);this.confirmClient=l}}},M={class:"card card-default"},T={class:"card-header"},F={class:"flex justify-between items-center"},A={class:"card-body"},N={key:0,class:"mb-0"},S={key:1,class:"table table-borderless mb-0"},I={style:{"vertical-align":"middle"}},j={style:{"vertical-align":"middle"}},D={style:{"vertical-align":"middle"}},L={style:{"vertical-align":"middle"}},R=["onClick"],U={class:"text-right",style:{"vertical-align":"middle"}},Y=["onClick"],V=["onClick"],z={class:"dialog rounded-2xl text-center",id:"modal-create-client",ref:"createModal","aria-modal":"true","aria-labelledby":"modal-create-client-label"},P={class:"text-justify"},O={key:0,class:"rounded p-4 bg-red-100 text-red-800 w-full"},q={class:"mb-5"},B={class:"mb-5"},K={class:"grid grid-cols-2 gap-2 w-full"},E={class:"dialog rounded-2xl text-center",id:"modal-edit-client",ref:"editModal","aria-modal":"true","aria-labelledby":"modal-edit-client-label"},X={class:"text-justify"},W={key:0,class:"alert alert-danger"},G={role:"form",autocomplete:"off"},$={class:"form-group grid grid-cols-2 gap-5"},H={class:"col-md-9"},J={class:"form-group grid grid-cols-2 gap-5"},Q={class:"col-md-9"},Z={class:"grid grid-cols-2 gap-2 w-full"};function ee(l,e,d,p,n,o){return i(),r("div",null,[t("div",M,[t("div",T,[t("div",F,[e[17]||(e[17]=t("span",{class:"text-lg"}," OAuth Clients ",-1)),t("a",{class:"btn2 btn-primary btn-outline btn-sm",tabindex:"-1",onClick:e[0]||(e[0]=(...s)=>o.showCreateClientForm&&o.showCreateClientForm(...s))}," Create New Client ")])]),t("div",A,[n.clients.length===0?(i(),r("p",N," You have not created any OAuth clients. ")):u("",!0),n.clients.length>0?(i(),r("table",S,[e[18]||(e[18]=t("thead",null,[t("tr",null,[t("th",null,"Client ID"),t("th",null,"Name"),t("th",null,"Secret"),t("th"),t("th")])],-1)),t("tbody",null,[(i(!0),r(c,null,m(n.clients,s=>(i(),r("tr",null,[t("td",I,a(s.id),1),t("td",j,a(s.name),1),t("td",D,[t("code",null,a(s.secret),1)]),t("td",L,[t("a",{class:"cursor-pointer",tabindex:"-1",onClick:f=>o.edit(s)}," Edit ",8,R)]),t("td",U,[!this.confirmClient||this.confirmClient.id!=s.id?(i(),r("a",{key:0,class:"btn2 btn-error btn-outline btn-xs",onClick:f=>o.deleteConfirm(s)}," Delete ",8,Y)):(i(),r("a",{key:1,class:"btn2 btn-error btn-xs",onClick:f=>o.deleteConfirm(s)}," Confirm delete ",8,V))])]))),256))])])):u("",!0)])]),t("dialog",z,[t("header",null,[e[20]||(e[20]=t("h4",{id:"modal-create-client-label"}," Create Client ",-1)),t("button",{type:"button",class:"rounded-full",onClick:e[1]||(e[1]=s=>o.closeModal("createModal")),title:"Close"},e[19]||(e[19]=[t("i",{class:"fa-solid fa-times","aria-hidden":"true"},null,-1),t("span",{class:"sr-only"},"Close",-1)]))]),t("article",P,[n.createForm.errors.length>0?(i(),r("div",O,[e[21]||(e[21]=t("p",{class:"mb-0"},[t("strong",null,"Whoops!"),k(" Something went wrong!")],-1)),e[22]||(e[22]=t("br",null,null,-1)),t("ul",null,[(i(!0),r(c,null,m(n.createForm.errors,s=>(i(),r("li",null,a(s),1))),256))])])):u("",!0),t("form",{role:"form",class:"w-full",onSubmit:e[6]||(e[6]=y((...s)=>o.store&&o.store(...s),["prevent"])),autocomplete:"off"},[t("div",q,[e[23]||(e[23]=t("label",{class:"font-extrabold required"},"Client name",-1)),h(t("input",{id:"create-client-name",type:"text",class:"rounded border w-full p-2",name:"name",placeholder:"Name the token","onUpdate:modelValue":e[2]||(e[2]=s=>n.createForm.name=s),onKeyup:e[3]||(e[3]=g((...s)=>o.store&&o.store(...s),["enter"])),ref:"createName"},null,544),[[b,n.createForm.name]]),e[24]||(e[24]=t("span",{class:"text-sm text-muted"}," Something your users will recognize and trust. ",-1))]),t("div",B,[e[25]||(e[25]=t("label",{class:"font-extrabold required"},"Redirect URL",-1)),h(t("input",{type:"text",class:"rounded border w-full p-2",name:"redirect",onKeyup:e[4]||(e[4]=g((...s)=>o.store&&o.store(...s),["enter"])),"onUpdate:modelValue":e[5]||(e[5]=s=>n.createForm.redirect=s)},null,544),[[b,n.createForm.redirect]]),e[26]||(e[26]=t("span",{class:"text-sm text-muted"}," Your application's authorization callback URL. ",-1))])],32),t("form",{role:"form",class:"w-full mb-5",onSubmit:e[7]||(e[7]=y((...s)=>o.store&&o.store(...s),["prevent"])),autocomplete:"off"},null,32),t("div",K,[t("button",{type:"button",class:"btn2 btn-ghost",onClick:e[8]||(e[8]=s=>o.closeModal("createModal"))},"Close"),t("button",{type:"button",class:"btn2 btn-primary",onClick:e[9]||(e[9]=(...s)=>o.store&&o.store(...s))}," Create ")])])],512),t("dialog",E,[t("header",null,[e[28]||(e[28]=t("h4",{id:"modal-edit-client-label"}," Create Client ",-1)),t("button",{type:"button",class:"rounded-full",onClick:e[10]||(e[10]=s=>o.closeModal("editModal")),title:"Close"},e[27]||(e[27]=[t("i",{class:"fa-solid fa-times","aria-hidden":"true"},null,-1),t("span",{class:"sr-only"},"Close",-1)]))]),t("article",X,[n.editForm.errors.length>0?(i(),r("div",W,[e[29]||(e[29]=t("p",{class:"mb-0"},[t("strong",null,"Whoops!"),k(" Something went wrong!")],-1)),e[30]||(e[30]=t("br",null,null,-1)),t("ul",null,[(i(!0),r(c,null,m(n.editForm.errors,s=>(i(),r("li",null,a(s),1))),256))])])):u("",!0),t("form",G,[t("div",$,[e[32]||(e[32]=t("label",{class:"col-md-3 col-form-label"},"Name",-1)),t("div",H,[h(t("input",{id:"edit-client-name",type:"text",class:"w-full",onKeyup:e[11]||(e[11]=g((...s)=>o.update&&o.update(...s),["enter"])),"onUpdate:modelValue":e[12]||(e[12]=s=>n.editForm.name=s),ref:"editName"},null,544),[[b,n.editForm.name]]),e[31]||(e[31]=t("span",{class:"form-text text-muted"}," Something your users will recognize and trust. ",-1))])]),t("div",J,[e[34]||(e[34]=t("label",{class:"col-md-3 col-form-label"},"Redirect URL",-1)),t("div",Q,[h(t("input",{type:"text",class:"w-full",name:"redirect",onKeyup:e[13]||(e[13]=g((...s)=>o.update&&o.update(...s),["enter"])),"onUpdate:modelValue":e[14]||(e[14]=s=>n.editForm.redirect=s)},null,544),[[b,n.editForm.redirect]]),e[33]||(e[33]=t("span",{class:"form-text text-muted"}," Your application's authorization callback URL. ",-1))])])]),t("div",Z,[t("button",{type:"button",class:"btn2 btn-ghost",onClick:e[15]||(e[15]=s=>o.closeModal("editModal"))},"Close"),t("button",{type:"button",class:"btn2 btn-primary",onClick:e[16]||(e[16]=(...s)=>o.update&&o.update(...s))}," Create ")])])],512)])}const te=x(w,[["render",ee]]),se={data(){return{tokens:[]}},ready(){this.prepareComponent()},mounted(){this.prepareComponent()},methods:{prepareComponent(){this.getTokens()},getTokens(){axios.get("/oauth/tokens").then(l=>{this.tokens=l.data})},revoke(l){axios.delete("/oauth/tokens/"+l.id).then(e=>{this.getTokens()})}}},le={key:0},oe={class:"card card-default"},ne={class:"card-body"},re={class:"table table-borderless mb-0"},ie={style:{"vertical-align":"middle"}},de={style:{"vertical-align":"middle"}},ae={key:0},ue={style:{"vertical-align":"middle"}},ce=["onClick"];function me(l,e,d,p,n,o){return i(),r("div",null,[n.tokens.length>0?(i(),r("div",le,[t("div",oe,[e[1]||(e[1]=t("div",{class:"card-header text-lg"},"Authorized Applications",-1)),t("div",ne,[t("table",re,[e[0]||(e[0]=t("thead",null,[t("tr",null,[t("th",null,"Name"),t("th",null,"Scopes"),t("th")])],-1)),t("tbody",null,[(i(!0),r(c,null,m(n.tokens,s=>(i(),r("tr",null,[t("td",ie,a(s.client.name),1),t("td",de,[s.scopes.length>0?(i(),r("span",ae,a(s.scopes.join(", ")),1)):u("",!0)]),t("td",ue,[t("a",{class:"action-link text-error",onClick:f=>o.revoke(s)}," Revoke ",8,ce)])]))),256))])])])])])):u("",!0)])}const pe=x(se,[["render",me],["__scopeId","data-v-73922f67"]]),fe={data(){return{accessToken:null,tokens:[],scopes:[],confirmToken:null,form:{name:"",scopes:[],errors:[]}}},ready(){this.prepareComponent()},mounted(){this.prepareComponent()},methods:{prepareComponent(){this.getTokens(),this.getScopes()},getTokens(){axios.get("/oauth/personal-access-tokens").then(l=>{this.tokens=l.data})},getScopes(){axios.get("/oauth/scopes").then(l=>{this.scopes=l.data})},showCreateTokenForm(){this.openModal("createModal"),this.$refs.createName.focus()},store(){this.accessToken=null,this.form.errors=[],axios.post("/oauth/personal-access-tokens",this.form).then(l=>{this.form.name="",this.form.scopes=[],this.form.errors=[],this.tokens.push(l.data.token),this.showAccessToken(l.data.accessToken)}).catch(l=>{typeof l.response.data=="object"?this.form.errors=_.flatten(_.toArray(l.response.data.errors)):this.form.errors=["Something went wrong. Please try again."]})},toggleScope(l){this.scopeIsAssigned(l)?this.form.scopes=_.reject(this.form.scopes,e=>e==l):this.form.scopes.push(l)},scopeIsAssigned(l){return _.indexOf(this.form.scopes,l)>=0},showAccessToken(l){this.closeModal("createModal"),this.accessToken=l,this.openModal("accessModal")},revoke(l){axios.delete("/oauth/personal-access-tokens/"+l.id).then(e=>{this.getTokens(),window.showToast("API token deleted succesfully.")})},openModal(l){this.$refs[l].showModal(),this.$refs[l].addEventListener("click",function(e){let d=this.getBoundingClientRect();!(d.top<=e.clientY&&e.clientY<=d.top+d.height&&d.left<=e.clientX&&e.clientX<=d.left+d.width)&&e.target.tagName==="DIALOG"&&this.close()})},closeModal(l){this.$refs[l].close()},deleteConfirm(l){if(this.confirmToken&&l.id===this.confirmToken.id)return this.revoke(l);this.confirmToken=l}}},he={class:""},be={class:"flex flex-col gap-5"},ge={class:"flex justify-between items-center"},ke={key:0,class:""},Ce={key:1,class:"table table-borderless mb-0 w-full"},ye={style:{"vertical-align":"middle"}},xe={class:"text-right",style:{"vertical-align":"middle"}},ve=["onClick"],we=["onClick"],Me={class:"dialog rounded-2xl text-center",id:"modal-create-token",ref:"createModal","aria-modal":"true","aria-labelledby":"modal-create-token-label"},Te={class:"text-justify"},_e={key:0,class:"rounded p-4 bg-red-100 text-red-800 w-full"},Fe={key:0,class:"form-group grid grid-cols-2 gap-4"},Ae={class:"col-md-6"},Ne={class:"checkbox"},Se=["onClick","checked"],Ie={class:"grid grid-cols-2 gap-2 w-full"},je={class:"dialog rounded-2xl text-center",id:"modal-access-token",ref:"accessModal","aria-modal":"true","aria-labelledby":"modal-access-token-label"},De={class:"text-justify"},Le={class:"w-full",rows:"10"};function Re(l,e,d,p,n,o){return i(),r("div",he,[t("div",be,[t("div",ge,[e[8]||(e[8]=t("span",{class:"text-lg"}," Personal Access Tokens ",-1)),t("a",{class:"btn2 btn-primary btn-outline btn-sm",tabindex:"-1",onClick:e[0]||(e[0]=(...s)=>o.showCreateTokenForm&&o.showCreateTokenForm(...s))}," Create New Token ")]),n.tokens.length===0?(i(),r("p",ke," You have not created any personal access tokens. ")):u("",!0),n.tokens.length>0?(i(),r("table",Ce,[e[9]||(e[9]=t("thead",null,[t("tr",null,[t("th",null,"Name"),t("th")])],-1)),t("tbody",null,[(i(!0),r(c,null,m(n.tokens,s=>(i(),r("tr",null,[t("td",ye,a(s.name),1),t("td",xe,[!this.confirmToken||this.confirmToken.id!=s.id?(i(),r("a",{key:0,class:"btn2 btn-error btn-outline btn-xs",onClick:f=>o.deleteConfirm(s)}," Delete ",8,ve)):(i(),r("a",{key:1,class:"btn2 btn-error btn-xs",onClick:f=>o.deleteConfirm(s)}," Confirm delete ",8,we))])]))),256))])])):u("",!0)]),t("dialog",Me,[t("header",null,[e[11]||(e[11]=t("h4",{id:"modal-create-token-label"}," Create Token ",-1)),t("button",{type:"button",class:"rounded-full",onClick:e[1]||(e[1]=s=>o.closeModal("createModal")),title:"Close"},e[10]||(e[10]=[t("i",{class:"fa-solid fa-times","aria-hidden":"true"},null,-1),t("span",{class:"sr-only"},"Close",-1)]))]),t("article",Te,[n.form.errors.length>0?(i(),r("div",_e,[e[12]||(e[12]=t("p",{class:"mb-0"},[t("strong",null,"Whoops!"),k(" Something went wrong!")],-1)),e[13]||(e[13]=t("br",null,null,-1)),t("ul",null,[(i(!0),r(c,null,m(n.form.errors,s=>(i(),r("li",null,a(s),1))),256))])])):u("",!0),t("form",{role:"form",class:"w-full mb-5",onSubmit:e[3]||(e[3]=y((...s)=>o.store&&o.store(...s),["prevent"])),autocomplete:"off"},[e[15]||(e[15]=t("label",{class:"font-extrabold required"},"Token name",-1)),h(t("input",{id:"create-token-name",type:"text",class:"rounded border w-full p-2",name:"name",placeholder:"Name the token","onUpdate:modelValue":e[2]||(e[2]=s=>n.form.name=s),ref:"createName"},null,512),[[b,n.form.name]]),n.scopes.length>0?(i(),r("div",Fe,[e[14]||(e[14]=t("label",{class:"col-md-4 col-form-label"},"Scopes",-1)),t("div",Ae,[(i(!0),r(c,null,m(n.scopes,s=>(i(),r("div",null,[t("div",Ne,[t("label",null,[t("input",{type:"checkbox",onClick:f=>o.toggleScope(s.id),checked:o.scopeIsAssigned(s.id)},null,8,Se),k(" "+a(s.id),1)])])]))),256))])])):u("",!0)],32),t("div",Ie,[t("button",{type:"button",class:"btn2 btn-ghost",onClick:e[4]||(e[4]=s=>o.closeModal("createModal"))},"Close"),t("button",{type:"button",class:"btn2 btn-primary",onClick:e[5]||(e[5]=(...s)=>o.store&&o.store(...s))}," Create ")])])],512),t("dialog",je,[t("header",null,[e[17]||(e[17]=t("h4",{id:"modal-access-token-label"}," Personal Access Token ",-1)),t("button",{type:"button",class:"rounded-full",onClick:e[6]||(e[6]=s=>o.closeModal("accessModal")),title:"Close"},e[16]||(e[16]=[t("i",{class:"fa-solid fa-times","aria-hidden":"true"},null,-1),t("span",{class:"sr-only"},"Close",-1)]))]),t("article",De,[e[18]||(e[18]=t("p",{class:"mb-2"}," Here is your new personal access token. This is the only time it will be shown so don't lose it! You may now use this token to make API requests. ",-1)),t("textarea",Le,a(n.accessToken),1),t("button",{type:"button",class:"btn2 btn-ghost",onClick:e[7]||(e[7]=s=>o.closeModal("accessModal"))},"Close")])],512)])}const Ue=x(fe,[["render",Re]]),C=v({});C.component("passport-clients",te);C.component("passport-authorized-clients",pe);C.component("passport-personal-access-tokens",Ue);C.mount("#api");
