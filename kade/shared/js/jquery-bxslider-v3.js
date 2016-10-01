(function(b){b.fn.bxSlider=function(aY){function a(i,o,n,m){var l=[];var k=n;var j=false;if(m=="backward"){i=b.makeArray(i);i.reverse()}while(k>0){b.each(i,function(c,e){if(k>0){if(!j){if(c==o){j=true;l.push(b(this).clone());k--}}else{l.push(b(this).clone());k--}}else{return false}})}return l}function aa(){var c=aR.outerHeight()*aY.displaySlideQty;return c}function ab(){var c=aR.outerWidth()*aY.displaySlideQty;return c}function ac(e,g){if(g=="left"){var f=b(".pagerslide",aS).eq(e).position().left}else{if(g=="top"){var f=b(".pagerslide",aS).eq(e).position().top}}return f}function ad(){if(!aY.infiniteLoop&&aY.hideControlOnEnd){if(aC==au){b(".bx-prev",aS).hide()}else{b(".bx-prev",aS).show()}if(aC==at){b(".bx-next",aS).hide()}else{b(".bx-next",aS).show()}}}function ae(j,i,h,d){aK=b('<a href="" class="bx-start"></a>');if(j=="text"){aI=i}else{aI='<img src="'+i+'" />'}if(h=="text"){aH=d}else{aH='<img src="'+d+'" />'}if(aY.autoControlsSelector){b(aY.autoControlsSelector).append(aK)}else{aS.append('<div class="bx-auto"></div>');b(".bx-auto",aS).html(aK)}aK.click(function(){if(aY.ticker){if(b(this).hasClass("stop")){aW.stopTicker()}else{if(b(this).hasClass("start")){aW.startTicker()}}}else{if(b(this).hasClass("stop")){aW.stopShow(true)}else{if(b(this).hasClass("start")){aW.startShow(true)}}}return false})}function af(){var d=b("img",aT.eq(aC)).attr("title");if(d!=""){if(aY.captionsSelector){b(aY.captionsSelector).html(d)}else{b(".bx-captions",aS).html(d)}}else{if(aY.captionsSelector){b(aY.captionsSelector).html(" ")}else{b(".bx-captions",aS).html(" ")}}}function ag(l){var k=aT.length;if(aY.moveSlideQty>1){if(aT.length%aY.moveSlideQty!=0){k=Math.ceil(aT.length/aY.moveSlideQty)}else{k=aT.length/aY.moveSlideQty}}var h="";if(aY.buildPager){for(var g=0;g<k;g++){h+=aY.buildPager(g,aT.eq(g*aY.moveSlideQty))}}else{if(l=="full"){for(var g=1;g<=k;g++){h+='<a href="" class="pager-link pagerslide-'+g+'">'+g+"</a>"}}else{if(l=="short"){h='<span class="bx-pager-current">'+(aY.startingSlide+1)+"</span> "+aY.pagerShortSeparator+' <span class="bx-pager-total">'+aT.length+"<span>"}}}if(aY.pagerSelector){b(aY.pagerSelector).append(h);aM=b(aY.pagerSelector)}else{var d=b('<div class="bx-pager"></div>');d.append(h);if(aY.pagerLocation=="top"){aS.prepend(d)}else{if(aY.pagerLocation=="bottom"){aS.append(d)}}aM=b(".bx-pager",aS)}aM.children().click(function(){if(aY.pagerType=="full"){var c=aM.children().index(this);if(aY.moveSlideQty>1){c*=aY.moveSlideQty}aW.goToSlide(c)}return false})}function ah(n,m,l,k){var h=b('<a href="" class="bx-next"></a>');var d=b('<a href="" class="bx-prev"></a>');if(n=="text"){h.html(m)}else{h.html('<img src="'+m+'" />')}if(l=="text"){d.html(k)}else{d.html('<img src="'+k+'" />')}if(aY.prevSelector){b(aY.prevSelector).append(d)}else{aS.append(d)}if(aY.nextSelector){b(aY.nextSelector).append(h)}else{aS.append(h)}h.click(function(){aW.goToNextSlide();return false});d.click(function(){aW.goToPreviousSlide();return false})}function ai(d){if(aY.pagerType=="full"&&aY.pager){b("a",aM).removeClass(aY.pagerActiveClass);b("a",aM).eq(d).addClass(aY.pagerActiveClass)}else{if(aY.pagerType=="short"&&aY.pager){b(".bx-pager-current",aM).html(aC+1)}}}function aj(){aT.not(":eq("+aC+")").fadeTo(aY.speed,0).css("zIndex",98);aT.eq(aC).css("zIndex",99).fadeTo(aY.speed,1,function(){av=false;if(jQuery.browser.msie){aT.eq(aC).get(0).style.removeAttribute("filter")}aY.onAfterSlide(aC,aT.length,aT.eq(aC))})}function ak(){aV.hover(function(){if(aG){aW.stopTicker(false)}},function(){if(aG){aW.startTicker(false)}})}function al(){aS.find(".bx-window").hover(function(){if(aG){aW.stopShow(false)}},function(){if(aG){aW.startShow(false)}})}function am(){if(aY.startImage!=""){startContent=aY.startImage;startType="image"}else{startContent=aY.startText;startType="text"}if(aY.stopImage!=""){stopContent=aY.stopImage;stopType="image"}else{stopContent=aY.stopText;stopType="text"}ae(startType,startContent,stopType,stopContent)}function an(e,g,f){if(aY.mode=="horizontal"){if(aY.tickerDirection=="next"){aV.animate({left:"-="+g+"px"},f,"linear",function(){aV.css("left",e);an(e,az,aY.tickerSpeed)})}else{if(aY.tickerDirection=="prev"){aV.animate({left:"+="+g+"px"},f,"linear",function(){aV.css("left",e);an(e,az,aY.tickerSpeed)})}}}else{if(aY.mode=="vertical"){if(aY.tickerDirection=="next"){aV.animate({top:"-="+g+"px"},f,"linear",function(){aV.css("top",e);an(e,ay,aY.tickerSpeed)})}else{if(aY.tickerDirection=="prev"){aV.animate({top:"+="+g+"px"},f,"linear",function(){aV.css("top",e);an(e,ay,aY.tickerSpeed)})}}}}}function ao(){if(aY.auto){if(!aY.infiniteLoop){if(aY.autoDirection=="next"){aL=setInterval(function(){aC+=aY.moveSlideQty;if(aC>at){aC=aC%aT.length}aW.goToSlide(aC,false)},aY.pause)}else{if(aY.autoDirection=="prev"){aL=setInterval(function(){aC-=aY.moveSlideQty;if(aC<0){negativeOffset=aC%aT.length;if(negativeOffset==0){aC=0}else{aC=aT.length+negativeOffset}}aW.goToSlide(aC,false)},aY.pause)}}}else{if(aY.autoDirection=="next"){aL=setInterval(function(){aW.goToNextSlide(false)},aY.pause)}else{if(aY.autoDirection=="prev"){aL=setInterval(function(){aW.goToPreviousSlide(false)},aY.pause)}}}}else{if(aY.ticker){aY.tickerSpeed*=10;b(".pagerslide",aS).each(function(c){az+=b(this).width();ay+=b(this).height()});if(aY.tickerDirection=="prev"&&aY.mode=="horizontal"){aV.css("left","-"+(az+aB)+"px")}else{if(aY.tickerDirection=="prev"&&aY.mode=="vertical"){aV.css("top","-"+(ay+aA)+"px")}}if(aY.mode=="horizontal"){ax=parseInt(aV.css("left"));an(ax,az,aY.tickerSpeed)}else{if(aY.mode=="vertical"){aw=parseInt(aV.css("top"));an(aw,ay,aY.tickerSpeed)}}if(aY.tickerHover){ak()}}}}function ap(){if(aY.nextImage!=""){nextContent=aY.nextImage;nextType="image"}else{nextContent=aY.nextText;nextType="text"}if(aY.prevImage!=""){prevContent=aY.prevImage;prevType="image"}else{prevContent=aY.prevText;prevType="text"}ah(nextType,nextContent,prevType,prevContent)}function aq(){if(aY.mode=="horizontal"||aY.mode=="vertical"){var l=a(aT,0,aY.moveSlideQty,"backward");b.each(l,function(c){aV.prepend(b(this))});var k=aT.length+aY.moveSlideQty-1;var j=aT.length-aY.displaySlideQty;var g=k-j;var e=a(aT,0,g,"forward");if(aY.infiniteLoop){b.each(e,function(c){aV.append(b(this))})}}}function ar(){aq(aY.startingSlide);if(aY.mode=="horizontal"){aV.wrap('<div class="'+aY.wrapperClass+'" style="width:'+aO+'px; position:relative;"></div>').wrap('<div class="bx-window" style="position:relative; overflow:hidden; width:'+aO+'px;"></div>').css({width:"999999px",position:"relative",left:"-"+aB+"px"});aV.children().css({width:aQ,"float":"left",listStyle:"none"});aS=aV.parent().parent();aT.addClass("pagerslide")}else{if(aY.mode=="vertical"){aV.wrap('<div class="'+aY.wrapperClass+'" style="width:'+aE+'px; position:relative;"></div>').wrap('<div class="bx-window" style="width:'+aE+"px; height:"+aN+'px; position:relative; overflow:hidden;"></div>').css({height:"999999px",position:"relative",top:"-"+aA+"px"});aV.children().css({listStyle:"none",height:aD});aS=aV.parent().parent();aT.addClass("pager")}else{if(aY.mode=="fade"){aV.wrap('<div class="'+aY.wrapperClass+'" style="width:'+aE+'px; position:relative;"></div>').wrap('<div class="bx-window" style="height:'+aD+"px; width:"+aE+'px; position:relative; overflow:hidden;"></div>');aV.children().css({listStyle:"none",position:"absolute",top:0,left:0,zIndex:98});aS=aV.parent().parent();aT.not(":eq("+aC+")").fadeTo(0,0);aT.eq(aC).css("zIndex",99)}}}if(aY.captions&&aY.captionsSelector==null){aS.append('<div class="bx-captions"></div>')}}var aX={mode:"horizontal",infiniteLoop:true,hideControlOnEnd:false,controls:true,speed:500,easing:"swing",pager:false,pagerSelector:null,pagerType:"full",pagerLocation:"bottom",pagerShortSeparator:"/",pagerActiveClass:"pager-active",nextText:"next",nextImage:"",nextSelector:null,prevText:"prev",prevImage:"",prevSelector:null,captions:false,captionsSelector:null,auto:false,autoDirection:"next",autoControls:false,autoControlsSelector:null,autoStart:true,autoHover:false,autoDelay:0,pause:3000,startText:"start",startImage:"",stopText:"stop",stopImage:"",ticker:false,tickerSpeed:5000,tickerDirection:"next",tickerHover:false,wrapperClass:"bx-wrapper",startingSlide:0,displaySlideQty:1,moveSlideQty:1,randomStart:false,onBeforeSlide:function(){},onAfterSlide:function(){},onLastSlide:function(){},onFirstSlide:function(){},onNextSlide:function(){},onPrevSlide:function(){},buildPager:null};var aY=b.extend(aX,aY);var aW=this;var aV="";var aU="";var aT="";var aS="";var aR="";var aQ="";var aP="";var aO="";var aN="";var aM="";var aL="";var aK="";var aJ="";var aI="";var aH="";var aG=true;var aF=false;var aE=0;var aD=0;var aC=0;var aB=0;var aA=0;var az=0;var ay=0;var ax=0;var aw=0;var av=false;var au=0;var at=aT.length-1;this.goToSlide=function(d,e){if(!av){av=true;aC=d;aY.onBeforeSlide(aC,aT.length,aT.eq(aC));if(typeof e=="undefined"){var e=true}if(e){if(aY.auto){aW.stopShow(true)}}slide=d;if(slide==au){aY.onFirstSlide(aC,aT.length,aT.eq(aC))}if(slide==at){aY.onLastSlide(aC,aT.length,aT.eq(aC))}if(aY.mode=="horizontal"){aV.animate({left:"-"+ac(slide,"left")+"px"},aY.speed,aY.easing,function(){av=false;aY.onAfterSlide(aC,aT.length,aT.eq(aC))})}else{if(aY.mode=="vertical"){aV.animate({top:"-"+ac(slide,"top")+"px"},aY.speed,aY.easing,function(){av=false;aY.onAfterSlide(aC,aT.length,aT.eq(aC))})}else{if(aY.mode=="fade"){aj()}}}ad();if(aY.moveSlideQty>1){d=Math.floor(d/aY.moveSlideQty)}ai(d);af()}};this.goToNextSlide=function(d){if(typeof d=="undefined"){var d=true}if(d){if(aY.auto){aW.stopShow(true)}}if(!aY.infiniteLoop){if(!av){var i=false;aC=aC+aY.moveSlideQty;if(aC<=at){ad();aY.onNextSlide(aC,aT.length,aT.eq(aC));aW.goToSlide(aC)}else{aC-=aY.moveSlideQty}}}else{if(!av){av=true;var i=false;aC=aC+aY.moveSlideQty;if(aC>at){aC=aC%aT.length;i=true}aY.onNextSlide(aC,aT.length,aT.eq(aC));aY.onBeforeSlide(aC,aT.length,aT.eq(aC));if(aY.mode=="horizontal"){var g=aY.moveSlideQty*aP;aV.animate({left:"-="+g+"px"},aY.speed,aY.easing,function(){av=false;if(i){aV.css("left","-"+ac(aC,"left")+"px")}aY.onAfterSlide(aC,aT.length,aT.eq(aC))})}else{if(aY.mode=="vertical"){var e=aY.moveSlideQty*aD;aV.animate({top:"-="+e+"px"},aY.speed,aY.easing,function(){av=false;if(i){aV.css("top","-"+ac(aC,"top")+"px")}aY.onAfterSlide(aC,aT.length,aT.eq(aC))})}else{if(aY.mode=="fade"){aj()}}}if(aY.moveSlideQty>1){ai(Math.ceil(aC/aY.moveSlideQty))}else{ai(aC)}af()}}};this.goToPreviousSlide=function(h){if(typeof h=="undefined"){var h=true}if(h){if(aY.auto){aW.stopShow(true)}}if(!aY.infiniteLoop){if(!av){var g=false;aC=aC-aY.moveSlideQty;if(aC<0){aC=0;if(aY.hideControlOnEnd){b(".bx-prev",aS).hide()}}ad();aY.onPrevSlide(aC,aT.length,aT.eq(aC));aW.goToSlide(aC)}}else{if(!av){av=true;var g=false;aC=aC-aY.moveSlideQty;if(aC<0){negativeOffset=aC%aT.length;if(negativeOffset==0){aC=0}else{aC=aT.length+negativeOffset}g=true}aY.onPrevSlide(aC,aT.length,aT.eq(aC));aY.onBeforeSlide(aC,aT.length,aT.eq(aC));if(aY.mode=="horizontal"){var e=aY.moveSlideQty*aP;aV.animate({left:"+="+e+"px"},aY.speed,aY.easing,function(){av=false;if(g){aV.css("left","-"+ac(aC,"left")+"px")}aY.onAfterSlide(aC,aT.length,aT.eq(aC))})}else{if(aY.mode=="vertical"){var d=aY.moveSlideQty*aD;aV.animate({top:"+="+d+"px"},aY.speed,aY.easing,function(){av=false;if(g){aV.css("top","-"+ac(aC,"top")+"px")}aY.onAfterSlide(aC,aT.length,aT.eq(aC))})}else{if(aY.mode=="fade"){aj()}}}if(aY.moveSlideQty>1){ai(Math.ceil(aC/aY.moveSlideQty))}else{ai(aC)}af()}}};this.goToFirstSlide=function(c){if(typeof c=="undefined"){var c=true}aW.goToSlide(au,c)};this.goToLastSlide=function(){if(typeof c=="undefined"){var c=true}aW.goToSlide(at,c)};this.getCurrentSlide=function(){return aC};this.getSlideCount=function(){return aT.length};this.stopShow=function(c){clearInterval(aL);if(typeof c=="undefined"){var c=true}if(c&&aY.autoControls){aK.html(aI).removeClass("stop").addClass("start");aG=false}};this.startShow=function(c){if(typeof c=="undefined"){var c=true}ao();if(c&&aY.autoControls){aK.html(aH).removeClass("start").addClass("stop");aG=true}};this.stopTicker=function(c){aV.stop();if(typeof c=="undefined"){var c=true}if(c&&aY.ticker){aK.html(aI).removeClass("stop").addClass("start");aG=false}};this.startTicker=function(e){if(aY.mode=="horizontal"){if(aY.tickerDirection=="next"){var k=parseInt(aV.css("left"));var j=az+k+aT.eq(0).width()}else{if(aY.tickerDirection=="prev"){var k=-parseInt(aV.css("left"));var j=k-aT.eq(0).width()}}var i=j*aY.tickerSpeed/az;an(ax,j,i)}else{if(aY.mode=="vertical"){if(aY.tickerDirection=="next"){var g=parseInt(aV.css("top"));var j=ay+g+aT.eq(0).height()}else{if(aY.tickerDirection=="prev"){var g=-parseInt(aV.css("top"));var j=g-aT.eq(0).height()}}var i=j*aY.tickerSpeed/ay;an(aw,j,i);if(typeof e=="undefined"){var e=true}if(e&&aY.ticker){aK.html(aH).removeClass("start").addClass("stop");aG=true}}}};this.initShow=function(){aV=b(this);aU=aV.clone();aT=aV.children();aS="";aR=aV.children(":first");aQ=aR.width();aE=0;aP=aR.outerWidth();aD=0;aO=ab();aN=aa();av=false;aM="";aC=0;aB=0;aA=0;aL="";aK="";aJ="";aI="";aH="";aG=true;aF=false;az=0;ay=0;ax=0;aw=0;au=0;at=aT.length-1;aT.each(function(c){if(b(this).outerHeight()>aD){aD=b(this).outerHeight()}if(b(this).outerWidth()>aE){aE=b(this).outerWidth()}});if(aY.randomStart){var d=Math.floor(Math.random()*aT.length);aC=d;aB=aP*(aY.moveSlideQty+d);aA=aD*(aY.moveSlideQty+d)}else{aC=aY.startingSlide;aB=aP*(aY.moveSlideQty+aY.startingSlide);aA=aD*(aY.moveSlideQty+aY.startingSlide)}ar();if(aY.pager&&!aY.ticker){if(aY.pagerType=="full"){ag("full")}else{if(aY.pagerType=="short"){ag("short")}}}if(aY.controls&&!aY.ticker){ap()}if(aY.auto||aY.ticker){if(aY.autoControls){am()}if(aY.autoStart){setTimeout(function(){aW.startShow(true)},aY.autoDelay)}else{aW.stopShow(true)}if(aY.autoHover&&!aY.ticker){al()}}if(aY.moveSlideQty>1){ai(Math.ceil(aC/aY.moveSlideQty))}else{ai(aC)}ad();if(aY.captions){af()}aY.onAfterSlide(aC,aT.length,aT.eq(aC))};this.destroyShow=function(){clearInterval(aL);b(".bx-next, .bx-prev, .bx-pager, .bx-auto",aS).remove();aV.unwrap().unwrap().removeAttr("style");aV.children().removeAttr("style").not(".pagerslide").remove();aT.removeClass("pagerslide")};this.reloadShow=function(){aW.destroyShow();aW.initShow()};this.each(function(){if(b(this).children().length>0){aW.initShow()}});return this};jQuery.fx.prototype.cur=function(){if(this.elem[this.prop]!=null&&(!this.elem.style||this.elem.style[this.prop]==null)){return this.elem[this.prop]}var c=parseFloat(jQuery.css(this.elem,this.prop));return c}})(jQuery);