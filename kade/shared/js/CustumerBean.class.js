var CustumerBean=function(){var b=false;var c="";var j=60;var e=new Array();var i=false;var f=null;var n=Address.getInstance();this.initQueryOpen=function(){k()};this.initBean=function(){g();m();a()};var k=function(){m();System.zebra("tbody_query");pagination=new Pagination();pagination.init($("#custumer_query_open"));l();$("#person_pj").live("click",function(){m()});$("#person_pf").live("click",function(){m()});$("#person_all").live("click",function(){m()});$("#custumer_ie_isento").click(function(){a()});$("#button_search").button().click(function(o){o.preventDefault();$("#pag").val("1");$("#custumer_query_open").submit()});$("#button_reset").button().click(function(o){o.preventDefault();$("#custumer_query_open .input_clear").val("")});$("#button_csv").button().click(function(o){$action=$("#custumer_query_open").attr("action");o.preventDefault();$("#custumer_query_open").attr("action","../CustumerQueryCtrl.ctrlExt/exportCSV");$("#custumer_query_open").attr("target","_blank");$("#custumer_query_open").submit();$action=$("#custumer_query_open").attr("action",$action);$("#custumer_query_open").removeAttr("target")});$("tr.tr_edit td").click(function(q){var p=$(this).parent();$indexFieldDtl=$("tr.tr_edit").index(p);if($indexFieldDtl>-1){var o=$("input.cust_hidden_id").eq($indexFieldDtl).val();if(o>0){var r=new Object();r.width=640;r.height=620;r.fullscreen="no";r.top=100;r.left=100;r.resizable="no";r.toolbar="yes";r.scrollbars="no";System.openDefaultWindow("/alter_custumer/action=edit&custumer_person_id="+o+"&windowPopUp=true","Gerenciamento de Clientes",r,true)}else{$("#span_loc_msg").notify("Nenhum resultado encontrado!!!","error")}}});$("tr.tr_mc_code td").click(function(p){var o=$(this).parent();$indexFieldDtl=$("tr.tr_mc_code").index(o);if($indexFieldDtl>-1){$input_id=window.opener.$("input.client_id");$input_name=window.opener.$("input.client_name");$span_name=window.opener.$("span.client_name");$input_id.val($("input.cust_hidden_id").eq($indexFieldDtl).val());$input_name.val($("input.cust_hidden_id").eq($indexFieldDtl).val());$span_name.html($("span.span_cli_name_mc").eq($indexFieldDtl).html());window.close()}})};var d=function(){$("#custumer_captcha").val("");var o=new Date();$("#img_captcha").attr("src",$("img").attr("src")+"?a="+o.getMilliseconds())};var h=function(){if(b){b=false;$("#dialog-working").dialog("close");d();var o="O sistema esta indispon�vel no momento. <br/>Tempo limite de execu��o de "+j+" segundos atingido, tente cadastrar novamente mais tarde.";$("#dialog-result\\.messageText").html(o);$("#dialog-result").dialog("open")}};var a=function(){if($("#custumer_ie_isento").prop("checked")){$("#custumer_ie").val("").addClass("readonly").attr("readonly","true")}else{$("#custumer_ie").removeClass("readonly").removeAttr("readonly")}};var m=function(){if($("#person_pj").prop("checked")){$("#div_fields_pj").toggle(true);$("#div_fields_pf").toggle(false);$("#div_fields_pf input.input_per").val("")}else{if($("#person_pf").prop("checked")){$("#div_fields_pf").toggle(true);$("#div_fields_pj").toggle(false);$("#div_fields_pj input.input_per").val("")}else{$("#div_fields_pf").toggle(false);$("#div_fields_pf input.input_per").val("");$("#div_fields_pj").toggle(false);$("#div_fields_pj input.input_per").val("")}}};var l=function(){n.eventCEP(function(){$("#custumer_address").val("");$("#custumer_number").val("");$("#custumer_city").val("");$("#custumer_neighborhood").val("");$("#custumer_region").val("");$("#custumer_region_nm").val("")},$("#custumer_zipcode"),function(o){if(o.result==1){$("#custumer_address").val(o.data.address);$("#custumer_number").val(o.data.addressNumber);$("#custumer_city").val(o.data.city);$("#custumer_neighborhood").val(o.data.neighborhood);$("#custumer_region").val(o.data.UF);$("#custumer_region_nm").val(o.data.UF_NM)}})};var g=function(){$("#button_save").button().click(function(o){o.preventDefault();$("#custumer_form").submit()});$("#button_back").button().click(function(o){o.preventDefault();window.location=System.CONTEXT});$("#button_new").button().click(function(o){o.preventDefault();window.location=System.CONTEXT+"cad_assinante/"});$("#tabs").tabs();$("#person_pj").live("click",function(){m()});$("#person_pf").live("click",function(){m()});$("#custumer_ie_isento").click(function(){a()});l();c=$("#custumer_form").serialize();$("#custumer_form").submit(function(){var o=$(this).serialize();if(i&&c==o){System.showMessageDialog("Voc� n�o alterou nenhuma informa��o para salvar!");return false}c=o;if(b){return false}b=true;$("#dialog-working").dialog("open");f=window.setTimeout(function(){h()},j*1000);return true});$("#custumer_iframe").load(function(){if(b){b=false;$("#dialog-working").dialog("close");window.clearInterval(f);f=null;var u="";try{var t=$(this).contents().text();var w=$.parseJSON(t);System.setImgMessage(w.result);u=w.message;var r=new Array();for(var v in e){var o=e[v];$(o).css("background","#FFFFFF")}e=new Array();if(w.result=="error"){if(w.validationException.length>0){u+="<br/></br>";for(var v in w.validationException){var q=w.validationException[v];var p=(q.id!="");q.id="#"+(q.id.replace(/\./g,"\\."));if(p){$(q.id).css("background","#FFC1C1")}e.push(q.id);r.push(q.message)}u+=r.join("<br/>")}}else{$("#custumer_form .input_clear").val("");if(window.opener!=undefined){$("#button_search",window.opener.document).click()}}}catch(s){System.setImgMessage("error");u="Erro ao realizar registro<br/><br/>";u+="O sistema esta indispon�vel no momento, aguarde e tente novamente mais tarde. <br/><br/>";u+="Detalhes t�cnicos: "+s.message}d();$("#dialog-result\\.messageText").html(u);$("#dialog-result").dialog("open")}});$("#dialog-result").dialog({autoOpen:false,closeOnEscape:false,width:640,height:240,modal:true,open:function(o,p){$(this).parent().children().children(".ui-dialog-titlebar-close").hide()},buttons:{OK:function(){$(this).dialog("close")}}});$("#dialog-working").dialog({width:420,height:220,modal:true,autoOpen:false,draggable:false,resizable:false,closeOnEscape:false,open:function(o,p){$(this).parent().children().children(".ui-dialog-titlebar-close").hide()}});$("#btn_new_captcha").click(function(o){o.preventDefault();d()})}};CustumerBean.instance=null;CustumerBean.getInstance=function(){if(CustumerBean.intance==null){CustumerBean.instance=new CustumerBean()}return CustumerBean.instance};