var AccountBean=function(){var a=false;var b="";var i=60;var d=new Array();var h=false;this.initQuery=function(){g()};this.initBean=function(){e()};var f=function(){if(a){a=false;$("#dialog-working").dialog("close");requestNewCaptcha();var l="O sistema esta indispon�vel no momento. <br/>Tempo limite de execu��o de "+i+" segundos atingido, tente cadastrar novamente mais tarde.";$("#dialog-result\\.messageText").html(l);$("#dialog-result").dialog("open")}};var j=function(){$("#dialog-working").dialog({width:420,height:220,modal:true,autoOpen:false,draggable:false,resizable:false,closeOnEscape:false,open:function(l,m){$(this).parent().children().children(".ui-dialog-titlebar-close").hide()}})};var k=function(){System.zebra("tbody_query");$("#table_installment tr.tr_hover td").click(function(o){var n=$(this).parent();$indexFieldDtl=$("tr.tr_hover").index(n);if($indexFieldDtl>-1){var m=$("input.acc_hidden_id").eq($indexFieldDtl).val();if(m>0){var l="Detalhes de Pagamento: Parcela "+m;var p=$("#installment_status_blk_"+m).val();$("#parc_id").val(m);$("#parc_payment_value_dtl").val($("#installment_payment_value_"+m).val());$("#parc_payment_date_dtl").val($("#installment_payment_date_"+m).val());$("#parc_payment_method_dtl").val($("#installment_payment_method_"+m).val());$("#parc_old_sts_dtl").val($("#installment_status_"+m).val());if(p=="1"){$("#parc_payment_value_dtl").attr("readonly","true").addClass("readonly");$("#parc_payment_date_dtl").attr("readonly","true").addClass("readonly");$("#parc_payment_method_dtl").attr("readonly","true").addClass("readonly");$("#parc_payment_method_dtl option[lang = 0]").show();$("#parc_payment_date_dtl").datepicker("destroy");$("#view_parc").dialog({buttons:[{text:"Fechar",click:function(){$(this).dialog("close")}}]})}else{$("#parc_payment_value_dtl").removeAttr("readonly","true").removeClass("readonly");$("#parc_payment_date_dtl").removeAttr("readonly","true").removeClass("readonly");$("#parc_payment_method_dtl").removeAttr("readonly","true").removeClass("readonly");if($("#parc_payment_value_dtl").val()<=0){$("#parc_payment_value_dtl").val("")}$("#parc_payment_method_dtl option[lang = 0]").hide();$("#parc_payment_date_dtl").datepicker(System.getDatePickerOp());$("#view_parc").dialog({buttons:[{text:"Confirmar",click:function(){var v=$("#parc_id").val();var u=$("#parc_payment_value_dtl").val();var s=$("#parc_payment_date_dtl").val();var q=$("#parc_payment_method_dtl").val();var r=$("#parc_old_sts_dtl").val();if(u<=0||s==""||q==""){alert("Informe os dados obrigat�rios de pagamento!")}else{var t="PAID";$("#installment_payment_value_"+v).val(u);$("#installment_payment_date_"+v).val(s);$("#installment_payment_method_"+v).val(q);$("#installment_status_"+v).val(t);$("#installment_status_nm_"+v).html("Pago");$("#td_installment_"+v).removeClass(r).addClass(t);$(this).dialog("close")}}}]})}$("#view_parc").dialog({title:l});$("#view_parc").dialog("open")}else{$("#span_loc_msg").notify("Nenhum resultado encontrado!!!","error")}}})};var c=function(){$("#btn_match_client").button({icons:{primary:"ui-icon ui-icon-search"},text:false}).click(function(l){var m=new Object();m.width=540;m.height=520;m.fullscreen="no";m.top=100;m.left=100;m.resizable="no";m.toolbar="yes";m.scrollbars="no";System.openDefaultWindow("/mc_client/action=edit&windowPopUp=true","Procurar de Clientes",m,true)});$("#account_client_id").change(function(l){$value=$(this).val().replace(/^\s+|\s+$/g,"");if($value!=""){$("#dialog-working").dialog("open");$.ajax({type:"POST",dataType:"json",url:"../CustumerQueryCtrl.ctrlExt/searchSingleCHK",data:({custumer_id:$value}),error:function(o,m,n){$("#dialog-working").dialog("close");$("#span_account_client_name").html("");$("#account_client_name").val("");$("#account_client_id").val("");System.defaultErrorHandlerJQueryAjax(o,m,n)},success:function(n){$("#dialog-working").dialog("close");try{if(n.error!=undefined&&n.error!=""){$("#span_account_client_name").html("");$("#account_client_name").val("");$("#account_client_id").val("");$("#span_loc_msg").notify(n.error,"error")}else{$("#span_account_client_name").html(n.name);$("#account_client_name").val(n.name)}}catch(m){$("#span_account_client_name").html("");$("#account_client_name").val("");$("#account_client_id").val("");$("#span_loc_msg").notify("Cliente n�o encontrado","error")}}})}else{$("#span_account_client_name").html("");$("#account_client_name").val("")}})};var e=function(){c();$("#button_save").button().click(function(l){l.preventDefault();$("#conta_form").submit()});$("#button_new").button().click(function(m){m.preventDefault();var l="action=edit&windowPopUp=true";window.location=l});$("#button_cancel").button().click(function(l){l.preventDefault();if(confirm("Deseja realmente cancelar esta conta?")){$action=$("#conta_form").attr("action");l.preventDefault();$("#conta_form").attr("action","../AccountRegCtrl.ctrlExt/cancelCont");$("#conta_form").submit();$("#conta_form").attr("action",$action)}});$("#button_ger_parc").button().click(function(l){$action=$("#conta_form").attr("action");l.preventDefault();$("#conta_form").attr("action","../AccountRegCtrl.ctrlExt/incParc");$("#conta_form").submit();$("#conta_form").attr("action",$action)});$("#installment_reg_dt").datepicker(System.getDatePickerOp());$("#tabs").tabs();$("#view_parc").dialog({autoOpen:false,closeOnEscape:true,width:440,height:220,modal:true});k();b=$("#conta_form").serialize();$("#conta_form").submit(function(){var l=$(this).serialize();if(h&&b==l){System.showMessageDialog("Voc� n�o alterou nenhuma informa��o para salvar!");return false}b=l;if(a){return false}a=true;$("#dialog-working").dialog("open");intTimeOut=window.setTimeout(function(){f()},i*1000);return true});$("#conta_iframe").load(function(){if(a){a=false;$("#dialog-working").dialog("close");window.clearInterval(intTimeOut);intTimeOut=null;var s="";try{var r=$(this).contents().text();var u=$.parseJSON(r);System.setImgMessage(u.result);s=u.message;var p=new Array();for(var t in d){var m=d[t];$(m).css("background","#FFFFFF")}d=new Array();if(u.html_inc_installment!=undefined){$("#tbody_installment").html("")}if(u.result=="error"){if(u.validationException.length>0){s+="<br/></br>";for(var t in u.validationException){var o=u.validationException[t];var n=(o.id!="");o.id="#"+(o.id.replace(/\./g,"\\."));if(n){$(o.id).css("background","#FFC1C1")}d.push(o.id);p.push(o.message)}s+=p.join("<br/>")}}else{if(u.html_inc_installment!=undefined){$("#tbody_installment").html(u.html_inc_installment);System.zebra("tbody_query")}else{$("#button_save").toggle(false);if(window.opener!=undefined){$("#button_search",window.opener.document).click()}alert(s);$("#dialog-working").dialog("open");s="";var l="action=edit&windowPopUp=true&account_id="+u.account_id;window.location=l}}}catch(q){System.setImgMessage("error");s="Erro ao realizar registro<br/><br/>";s+="O sistema esta indispon�vel no momento, aguarde e tente novamente mais tarde. <br/><br/>";s+="Detalhes t�cnicos: "+q.message}if(s!=""){$("#dialog-result\\.messageText").html(s);$("#dialog-result").dialog("open")}}});$("#dialog-result").dialog({autoOpen:false,closeOnEscape:false,width:640,height:240,modal:true,open:function(l,m){$(this).parent().children().children(".ui-dialog-titlebar-close").hide()},buttons:{OK:function(){$(this).dialog("close")}}});j()};var g=function(){$("#account_dt_init").datepicker(System.getDatePickerOp());$("#account_dt_init").datepicker("option","defaultDate","+1w");$("#account_dt_init").datepicker("option","onClose",function(l){$("#account_dt_end").datepicker("option","minDate",l)});$("#account_dt_end").datepicker(System.getDatePickerOp());$("#account_dt_end").datepicker("option","defaultDate","+1w");$("#account_dt_end").datepicker("option","onClose",function(l){$("#account_dt_init").datepicker("option","maxDate",l)});j();c();System.zebra("tbody_query");pagination=new Pagination();pagination.init($("#conta_query_open"));$("#button_search").button().click(function(l){l.preventDefault();$("#pag").val("1");$("#conta_query_open").submit()});$("#button_reset").button().click(function(l){l.preventDefault();$("#conta_query_open .input_clear").val("")});$("#button_new").button().click(function(l){l.preventDefault();var m=new Object();m.width=640;m.height=620;m.fullscreen="no";m.top=100;m.left=100;m.resizable="no";m.toolbar="yes";m.scrollbars="no";System.openDefaultWindow("/alt_parc/action=edit&windowPopUp=true","Gerenciamento de Contas",m,true)});$("tr.tr_hover td").click(function(n){var m=$(this).parent();$indexFieldDtl=$("tr.tr_hover").index(m);if($indexFieldDtl>-1){var l=$("input.acc_hidden_id").eq($indexFieldDtl).val();if(l>0){var o=new Object();o.width=640;o.height=620;o.fullscreen="no";o.top=100;o.left=100;o.resizable="no";o.toolbar="yes";o.scrollbars="no";System.openDefaultWindow("/alt_parc/action=edit&account_id="+l+"&windowPopUp=true","Gerenciamento de Parcelas",o,true)}else{$("#span_loc_msg").notify("Nenhum resultado encontrado!!!","error")}}})}};AccountBean.instance=null;AccountBean.getInstance=function(){if(AccountBean.intance==null){AccountBean.instance=new AccountBean()}return AccountBean.instance};