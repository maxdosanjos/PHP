var VehicleTravelingBean=function(){var a=false;var b="";var j=60;var d=new Array();var i=false;var n="";var m=-1;var e=null;var p=Address.getInstance();this.initBean=function(){f();o()};this.initQueryOpen=function(){h()};var l=function(){$("#dialog-result").dialog({autoOpen:false,closeOnEscape:false,width:640,height:240,modal:true,open:function(q,r){$(this).parent().children().children(".ui-dialog-titlebar-close").hide()},buttons:{OK:function(){$(this).dialog("close")}}});$("#dialog-working").dialog({width:420,height:220,modal:true,autoOpen:false,draggable:false,resizable:false,closeOnEscape:false,open:function(q,r){$(this).parent().children().children(".ui-dialog-titlebar-close").hide()}})};var c=function(){$("#vehicle_captcha").val("");var q=new Date();$("#img_captcha").attr("src",$("img").attr("src")+"?a="+q.getMilliseconds())};var g=function(){if(a){a=false;$("#dialog-working").dialog("close");var q="O sistema esta indispon�vel no momento. <br/>Tempo limite de execu��o de "+j+" segundos atingido, tente cadastrar novamente mais tarde.";$("#dialog-result\\.messageText").html(q);$("#dialog-result").dialog("open")}};var o=function(){if($("#person_pj").attr("checked")){$("#div_fields_pf").toggle(false);$("#div_fields_pf input").val("");$("#div_fields_pj").toggle(true)}else{if($("#person_pf").attr("checked")){$("#div_fields_pf").toggle(true);$("#div_fields_pj").toggle(false);$("#div_fields_pj input").val("")}}};var k=function(){p.eventCEP(function(){$("#vehicle_address").val("");$("#vehicle_number").val("");$("#vehicle_city").val("");$("#vehicle_neighborhood").val("");$("#vehicle_region").val("");$("#vehicle_region_nm").val("")},$("#vehicle_zipcode"),function(q){if(q.result==1){$("#vehicle_address").val(q.data.address);$("#vehicle_number").val(q.data.addressNumber);$("#vehicle_city").val(q.data.city);$("#vehicle_neighborhood").val(q.data.neighborhood);$("#vehicle_region").val(q.data.UF);$("#vehicle_region_nm").val(q.data.UF_NM)}/*else{$("#vehicle_zipcode").val("");System.showMessageDialog(q.message)}*/})};var h=function(){System.zebra("tbody_query");pagination=new Pagination();pagination.init($("#vehicle_query_open"));$("#vehicle_dt_init").datepicker(System.getDatePickerOp());$("#vehicle_dt_init").datepicker("option","defaultDate","+1w");$("#vehicle_dt_init").datepicker("option","onClose",function(q){$("#vehicle_dt_end").datepicker("option","minDate",q)});$("#vehicle_dt_end").datepicker(System.getDatePickerOp());$("#vehicle_dt_end").datepicker("option","defaultDate","+1w");$("#vehicle_dt_end").datepicker("option","onClose",function(q){$("#vehicle_dt_init").datepicker("option","maxDate",q)});k();l();$("#view_details").dialog({autoOpen:false,closeOnEscape:true,width:640,height:550,modal:true});$("#button_search").button().click(function(q){q.preventDefault();$("#pag").val("1");$("#vehicle_query_open").submit()});$("#button_reset").button().click(function(q){q.preventDefault();$("#vehicle_query_open .input_clear").val("")});$("#button_csv").button().click(function(e){$a=$("#vehicle_query_open").attr("action");e.preventDefault();$("#vehicle_query_open").attr("action","../VehicleQueryCtrl.ctrlExt/exportCSV");$("#vehicle_query_open").attr("target","_blank");$("#vehicle_query_open").submit();$("#vehicle_query_open").attr("action",$a);$("#vehicle_query_open").removeAttr("target");});$("tr.tr_hover td").click(function(u){var q=System.CONTEXT+"VehicleQueryCtrl.ctrlExt/viewDetail";var t=$(this).parent();m=$("tr.tr_hover").index(t);if(m>-1){var r=$("input.trav_hidden_id").eq(m).val();var s=$("#view_type").val();if(r>0){$("#vehicle_id_detail").val(r);$("#view_type_detail").val(s);$("#form_view_detail").submit()}else{$("#span_loc_msg").notify("Nenhum resultado encontrado!!!","error")}}});$("#form_view_detail").submit(function(q){if(a){q.preventDefault();return false}a=true;$("#dialog-working").dialog("open");e=window.setTimeout(function(){g()},j*1000);return true});$("#detail_vec_iframe").load(function(){$("#vehicle_id_detail").val("");$("#view_type_detail").val("");if(a){a=false;$("#dialog-working").dialog("close");window.clearInterval(e);e=null;var u="";try{var s=$(this).contents().text();var q=$.parseJSON(s);if(q.result=="sucess"){var r="Detalhes: Registro "+q.id;$("#div_vehicle_id").html(q.id);$("#trav_hidden_id_sel").val(q.id);$("#trav_hidden_id_sel_add").val(q.addr_id);$("#div_vehicle_dt_proc").html(q.dt_proc);$("#div_vehicle_type").html(q.type_id+" - "+q.type_nm);$("#div_vehicle_cep").html(q.cep);$("#div_vehicle_city").html(q.city);$("#div_vehicle_state").html(q.state);$("#div_vehicle_contact_phone").html(q.contact_phone);$("#div_vehicle_contact_name").html(q.contact_name);$("#div_vehicle_source").html(q.source);if(q.dt_used!=""){$("#label_vehicle_dt_used").toggle(true);$("#div_vehicle_dt_used").toggle(true);$("#div_vehicle_dt_used").html(q.dt_used)}else{$("#label_vehicle_dt_used").toggle(false);$("#div_vehicle_dt_used").toggle(false)}if(n!=q.sts){$("#div_vehicle_sts").removeClass(n);$("#div_vehicle_sts").addClass(q.sts).html(q.sts_nm);n=q.sts}if(q.sts==VehicleTravelingBean.NONE){$("#button_check_cancel").css("display","inline")}else{$("#button_check_cancel").css("display","none")}$("#view_details").dialog({title:r});$("#view_details").dialog("open")}else{throw q}}catch(t){System.setImgMessage("error");u="Erro ao realizar registro<br/><br/>";u+="O sistema esta indispon�vel no momento, aguarde e tente novamente mais tarde. <br/><br/>";u+="Detalhes t�cnicos: "+t.message;$("#dialog-result\\.messageText").html(u);$("#dialog-result").dialog("open")}}});$("#button_check_view").button().click(function(t){t.preventDefault();var s=$("#trav_hidden_id_sel").val();var r=$("#trav_hidden_id_sel_add").val();var q="../VehicleQueryCtrl.ctrlExt/setStsUtilized";if(s>0){$(this).css("display","none");$("#form_setsts").attr("action",q);$("#vehicle_id_setsts").val(s);$("#address_id_setsts").val(r);$("#form_setsts").submit()}else{$("#span_loc_msg").notify("Nenhum resultado encontrado!!!","error")}});$("#button_check_cancel").button().click(function(u){u.preventDefault();var t=$("#trav_hidden_id_sel").val();var s=$("#trav_hidden_id_sel_add").val();var r="../VehicleQueryCtrl.ctrlExt/setStsCancel";var q=confirm("Deseja cancelar o registro "+t+"?");if(q&&t>0){$(this).css("display","none");$("#form_setsts").attr("action",r);$("#vehicle_id_setsts").val(t);$("#address_id_setsts").val(s);$("#form_setsts").submit()}else{$("#span_loc_msg").notify("Nenhum resultado encontrado!!!","error")}});$("#button_close_detail").button().click(function(q){q.preventDefault();$("#view_details").dialog("close")});$("#form_setsts").submit(function(q){if(a){q.preventDefault();return false}a=true;$("#dialog-working").dialog("open");e=window.setTimeout(function(){g()},j*1000);return true});$("#setsts_vec_iframe").load(function(){$("#vehicle_id_setsts").val("");$("#address_id_setsts").val("");if(a){a=false;$("#dialog-working").dialog("close");window.clearInterval(e);e=null;var t="";try{var r=$(this).contents().text();var q=$.parseJSON(r);if(q.result=="sucess"){$("#view_details").dialog("close");$("#msg_type").val("info");$("#msg_txt").val("Obrigado por nos informar!!!");$("#span_loc_msg").notify($("#msg_txt").val(),$("#msg_type").val());$("input.trav_hidden_id").eq(m).val("");$("#button_search").click()}else{throw q}}catch(s){System.setImgMessage("error");t="Erro ao realizar registro<br/><br/>";t+="O sistema esta indispon�vel no momento, aguarde e tente novamente mais tarde. <br/><br/>";t+="Detalhes t�cnicos: "+s.message;$("#dialog-result\\.messageText").html(t);$("#dialog-result").dialog("open")}}})};var f=function(){$("#button_save").button().click(function(q){q.preventDefault();$("#vehicle_form").submit()});$("#button_back").button().click(function(q){q.preventDefault();window.location=System.CONTEXT});$("#button_new").button().click(function(q){q.preventDefault();window.location=System.CONTEXT+"cad_veiculo.html"});$("#tabs").tabs();$("#person_pj").live("click",function(){o()});$("#person_pf").live("click",function(){o()});k();b=$("#vehicle_form").serialize();$("#vehicle_form").submit(function(){var q=$(this).serialize();if(i&&b==q){System.showMessageDialog("Voc� n�o alterou nenhuma informa��o para salvar!");return false}b=q;if(a){return false}a=true;$("#dialog-working").dialog("open");e=window.setTimeout(function(){c();g()},j*1000);return true});$("#vehicle_iframe").load(function(){if(a){a=false;$("#dialog-working").dialog("close");window.clearInterval(e);e=null;var w="";try{var v=$(this).contents().text();var y=$.parseJSON(v);System.setImgMessage(y.result);w=y.message;var t=new Array();for(var x in d){var q=d[x];$(q).css("background","#FFFFFF")}d=new Array();if(y.result=="error"){if(y.validationException.length>0){w+="<br/></br>";for(var x in y.validationException){var s=y.validationException[x];var r=(s.id!="");s.id="#"+(s.id.replace(/\./g,"\\."));if(r){$(s.id).css("background","#FFC1C1")}d.push(s.id);t.push(s.message)}w+=t.join("<br/>")}}else{$("#vehicle_form .input_clear").val("")}}catch(u){System.setImgMessage("error");w="Erro ao realizar registro<br/><br/>";w+="O sistema esta indispon�vel no momento, aguarde e tente novamente mais tarde. <br/><br/>";w+="Detalhes t�cnicos: "+u.message}c();$("#dialog-result\\.messageText").html(w);$("#dialog-result").dialog("open")}});l();$("#btn_new_captcha").click(function(q){q.preventDefault();c();});}};VehicleTravelingBean.instance=null;VehicleTravelingBean.getInstance=function(){if(VehicleTravelingBean.intance==null){VehicleTravelingBean.instance=new VehicleTravelingBean()}return VehicleTravelingBean.instance};VehicleTravelingBean.ONLY_VIEW="ONLY_VIEW";VehicleTravelingBean.UTILIZED="UTILIZED";VehicleTravelingBean.NONE="NONE";VehicleTravelingBean.CANCEL="CANCEL";