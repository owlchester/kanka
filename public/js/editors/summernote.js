(()=>{var e,t=!1;function a(t,a){$.ajax({url:e.data("mention")+"?q="+t+"&new=1",type:"get",dataType:"json",async:!0}).done(a)}function n(e){var t=e.type?" ("+e.type+")":"";return e.image?'<div class="entity-hint">'+e.image+'<div class="entity-hint-name">'+e.fullname+t+"</div></div>":e.fullname+t}function r(a){if(a.id){var n="["+a.model_type+":"+a.id+a.fullname+"]",r="["+a.model_type+":"+a.id+a.advanced_mention+"]";return a.alias_id?(n="["+a.model_type+":"+a.id+a.advanced_mention+"|alias:"+a.alias_id+a.advanced_mention_alias+"]",$("<span>"+n+"</span>")[0]):e.data("advanced-mention")||t?$("<span>"+r+"</span>")[0]:$("<a />",{text:a.fullname,href:"#",class:"mention","data-name":a.fullname,"data-mention":"["+a.model_type+":"+a.id+"]"})[0]}return a.url?a.tooltip?$("<a />",{text:a.fullname,href:a.url,title:a.tooltip.replace(/["]/g,"'"),"data-toggle":"tooltip","data-html":"true"})[0]:$("<a />",{text:a.fullname,href:a.url})[0]:a.inject?a.inject:a.fullname}function o(e){return e?"he"==e?"he-IL":"ca"==e?"ca-ES":"el"==e?"el-GR":"en"==e?"en-US":e+"-"+e.toUpperCase():"en-US"}$(document).ready((function(){(e=$("#summernote-config")).length>0&&window.initSummernote()})),window.initSummernote=function(){var i=$(".html-editor").summernote({height:"300px",maximumImageFileSize:1024*parseInt(e.data("filesize")),lang:o(e.data("locale")),hintSelect:"next",placeholder:e.data("placeholder"),dialogsInBody:1===e.data("dialogs"),toolbar:[["style",["style"]],["font",["bold","italic","underline","strikethrough","clear"]],["color",["color"]],["aroba",["aroba"]],["para",["ul","ol","kanka-indent","kanka-outdent","paragraph"]],["table",["table","spoiler","tableofcontent"]],["insert",["link","picture","video","embed","hr"]],["view",["fullscreen","codeview","help"]],""!==e.data("gallery")?["extensions",["summernoteGallery"]]:null],popover:{table:[["add",["addRowDown","addRowUp","addColLeft","addColRight"]],["delete",["deleteRow","deleteCol","deleteTable"]],["custom",["tableHeaders"]],["custom",["tableStyles"]]],image:[["image",["resizeFull","resizeHalf","resizeQuarter","resizeNone"]],["float",["floatLeft","floatRight","floatNone"]],["remove",["removeMedia"]],["custom",["imageAttributes"]]]},callbacks:{onImageUpload:function(t){!function(t,a){var n=$("#campaign-imageupload-modal");if(!e.data("gallery-upload"))return n.modal(),void console.warn("Campaign isn't superboosted");formData=new FormData,formData.append("file",a),formData.append("_token",$('meta[name="csrf-token"]').attr("content")),$.ajax({url:e.data("gallery-upload"),data:formData,cache:!1,contentType:!1,processData:!1,type:"POST",success:function(e){t.summernote("insertImage",e,(function(t){t.attr("src",e)}))},error:function(e,t,a){var r=$("#campaign-imageupload-error"),o=$("#campaign-imageupload-boosted"),i=$("#campaign-imageupload-permission");r.hide(),o.hide(),i.hide(),422===e.status?r.text(function(e){var t="";for(var a in e)e.hasOwnProperty(a)&&(t+=e[a]+"\n");return t}(e.responseJSON.errors)).show():403===e.status?i.show():o.show(),n.modal()}})}(i,t[0])},onChange:function(){window.entityFormHasUnsavedChanges=!0},onChangeCodeview:function(e,t){$(this).summernote("code",e)}},summernoteGallery:{source:{url:e.data("gallery"),responseDataKey:"data",nextPageKey:"links.next"},modal:{loadOnScroll:!0,maxHeight:350,title:e.data("gallery-title"),close_text:e.data("gallery-close"),ok_text:e.data("gallery-add"),selectAll_text:e.data("gallery-select-all"),deselectAll_text:e.data("gallery-deselect-all"),noImageSelected_msg:e.data("gallery-error")}},hint:[{match:/\B@(\S*)$/,search:function(e,t){return e.length<3?[]:a(e,t)},template:function(e){return n(e)},content:function(e){return t=!1,r(e)}},{match:/\B\[(\S[^:]*)$/,search:function(e,t){return e.length<3?[]:a(e,t)},template:function(e){return n(e)},content:function(e){return t=!0,r(e)}},{match:/\B\#(\S*)$/,search:function(t,a){return function(t,a){$.ajax({url:e.data("months")+"?q="+t,type:"get",dataType:"json",async:!0}).done(a)}(t,a)},template:function(e){return n(e)},content:function(e){return t=!1,r(e)}},{match:/\B{(\S[^:]*)$/,search:function(t,a){return function(t,a){if(!e.data("attributes"))return!1;$.ajax({url:e.data("attributes")+"?q="+t,type:"get",dataType:"json",async:!0}).done(a)}(t,a)},template:function(e){return function(e){return e.name+(e.value?" ("+e.value+")":"")}(e)},content:function(t){return function(t){if(e.data("advanced-mention"))return"{attribute:"+t.id+"}";return $("<a />",{href:"#",class:"attribute attribute-mention",text:"{"+t.name+"}","data-attribute":"{attribute:"+t.id+"}"})[0]}(t)}}],keyMap:{pc:{ESC:"escape",ENTER:"insertParagraph","CTRL+Z":"undo","CTRL+Y":"redo",TAB:"tab","SHIFT+TAB":"untab","CTRL+B":"bold","CTRL+I":"italic","CTRL+U":"underline","CTRL+SHIFT+I":"strikethrough","CTRL+BACKSLASH":"removeFormat","CTRL+SHIFT+L":"justifyLeft","CTRL+SHIFT+E":"justifyCenter","CTRL+SHIFT+R":"justifyRight","CTRL+SHIFT+J":"justifyFull","CTRL+SHIFT+NUM7":"insertUnorderedList","CTRL+SHIFT+NUM8":"insertOrderedList","CTRL+LEFTBRACKET":"outdent","CTRL+RIGHTBRACKET":"indent","CTRL+NUM0":"formatPara","CTRL+NUM1":"formatH1","CTRL+NUM2":"formatH2","CTRL+NUM3":"formatH3","CTRL+NUM4":"formatH4","CTRL+NUM5":"formatH5","CTRL+NUM6":"formatH6","CTRL+ENTER":"insertHorizontalRule","CTRL+K":"linkDialog.show"},mac:{ESC:"escape",ENTER:"insertParagraph","CMD+Z":"undo","CMD+SHIFT+Z":"redo",TAB:"tab","SHIFT+TAB":"untab","CMD+B":"bold","CMD+I":"italic","CMD+U":"underline","CMD+SHIFT+I":"strikethrough","CMD+BACKSLASH":"removeFormat","CMD+SHIFT+L":"justifyLeft","CMD+SHIFT+E":"justifyCenter","CMD+SHIFT+R":"justifyRight","CMD+SHIFT+J":"justifyFull","CMD+SHIFT+NUM7":"insertUnorderedList","CMD+SHIFT+NUM8":"insertOrderedList","CMD+LEFTBRACKET":"outdent","CMD+RIGHTBRACKET":"indent","CMD+NUM0":"formatPara","CMD+NUM1":"formatH1","CMD+NUM2":"formatH2","CMD+NUM3":"formatH3","CMD+NUM4":"formatH4","CMD+NUM5":"formatH5","CMD+NUM6":"formatH6","CMD+ENTER":"insertHorizontalRule","CMD+K":"linkDialog.show"}}})}})();
//# sourceMappingURL=summernote.js.map