
function tosearch(){
        location.hash="txt2";
        location.hash="url";
        scroll(0,0);
    }
        
var getjsiscc=0;
function selectasearch(){
    /*if(getjsiscc==0){
        
        $.message({title:"艺术长廊",message:"面板已加载",type:"info"})
            doneswitchOptionPb();
            getjsiscc=1;
    }else{
        doneswitchOptionPb();
    }*/
    if(document.getElementById("search_input").value==""){
        $.message({title:"艺术长廊",message:"先输点什么吧",type:"error"})
        switchDoneP('全局');
        return ;
    }
    //document.getElementById("pbtt").innerHTML="正在搜索中";
    $.message({title:"艺术长廊",message:"正在为你搜索 "+decodeURIComponent(document.getElementById("search_input").value),type:"info"})
    speccAll();
}

function doneswitchOptionPb(){
    var mie = new $.flavr({ 
    buttonDisplay : 'stacked', 
    
    content : '您想搜索哪一方面？',

    buttons : {
        primary1 : { text: '各类视频', style: 'primary', action: function(){ switchDoneP("影视"); } }, 
        success1 : { text: 'Rss订阅网址', style: 'success', action: function(){ switchDoneP("信息流"); } }, 
        info1 : { text: '视频精确ID号',style: 'info', action: function(){ switchDoneP("ID"); } }, 
        warning1 : { text: '各类音乐', style: 'warning', action: function(){ switchDoneP("音乐");} }, 
        danger1 : { text: '古代文学作品', style: 'danger', action: function(){ switchDoneP("古诗文"); } }, 
        primary3 : { text: '密钥', style: 'info', action: function(){ switchDoneP("密钥"); } }, 
        warning3 : { text: '谷歌搜索', style: 'warning', action: function(){ switchDoneP("谷歌");} }, 
        success2 : { text: '博客文章', style: 'success', action: function(){ switchDoneP("博客文章"); } }, 
        danger4 : { text: '点歌台', style: 'danger', action: function(){ switchDoneP("点歌"); } }, 
        closeX : { text: '我不搜了', style:'default' } } 
    });
}



function speccAll(){
    var haveSearch=document.getElementById("search_input").value;
    setCookie("CCSS",haveSearch,666);
    var jumpto="https://www.6zgm.com/video.html?mytype=result&qc="+encodeURIComponent(haveSearch)+"&t="+encodeURIComponent(haveSearch);
    document.getElementById("search_input").value="";
    $("#whatashit").attr("href",jumpto);
    $("#whatashit")[0].click();
}

function happynewyear(){
    var hey = new $.flavr({ 
        content : '<iframe width="420" height="315" src="https://www.17sucai.com/preview/945243/2018-02-15/firework/index.html" frameborder="0" allowfullscreen></iframe>', 
        buttons : { close : {} } });
}

var OriginTitile = document.title;
var titleTime;
document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            document.title = '别走远了哟 | ' + OriginTitile;
            clearTimeout(titleTime);
        }
        else {
            document.title = '' + OriginTitile;
            $.message({title:"艺术长廊",message:"欢迎回来！",type:"success"})
            titleTime = setTimeout(function() {
                document.title = OriginTitile;
            }, 2000);
        }
    });
    
function showDDs13(){
    var ev = (typeof event!= 'undefined') ? window.event : e;
    if(ev.keyCode == 13) {
        selectasearch();
    }
}

function showDDs(){
    selectasearch();
}

    



function isIE() { //ie?
    if (!!window.ActiveXObject || "ActiveXObject" in window){ 
        return true; 
    }
    else{ 
        return false; 
    }
    
}
$('.needtochangepic').error(function(){
    $(this).attr('src',"https://www.6zgm.com/pinterest_profile_image.png");
})

$(document).ready(function() { 
    $('.img-responsive').error(function(){
    $(this).attr('src',"https://www.6zgm.com/youtube/thumbnail.php?type=mqdefault&vid=NLx0eiSd4Kk");
})
    if(isIE()){
        var r=confirm("来自 6zgm.com 的提醒 ：你使用的是IE浏览器，艺术长廊加入了相当多的优质动画，我们建议您下载现代的浏览器来体验它们。是否前往下载？");
	    if (r==true){
		var url="https://www.google.cn/intl/zh-CN/chrome/";
        window.location.href=url;
	    }
	    else{
		$.message({title:"艺术长廊",message:"非常抱歉，您不能享受我们提供的优质服务！",type:"error"})
	    }
    }
    
});

function jinrishiciLoad () {
        var xhr = new XMLHttpRequest();
        xhr.open('get', 'https://v2.jinrishici.com/one.json');
        xhr.withCredentials = true;
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            var data = JSON.parse(xhr.responseText);
            // 处理示例
            var gushici = document.getElementById('jinrishici-sentence');
            gushici.innerHTML = data.data.content;
            /*var gushiciTag = document.getElementById('jinrishici-tag');
            if (data.data.matchTags.length > 0) {
                gushiciTag.innerHTML = data.data.matchTags[0];
            } else {
                gushiciTag.innerHTML = data.data.origin.author;
            }*/
          }
        };
        xhr.send();
    }


function showTips(str){
    if (str.length==0)
    { 
        document.getElementById("showtittle").innerHTML = "艺术长廊";
        document.getElementById("showTips").innerHTML="";
        return;
    }
    if (window.XMLHttpRequest)
    {
        // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行的代码
        xmlhttp=new XMLHttpRequest();
    }
    else
    {    
        //IE6, IE5 浏览器执行的代码
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            if($('#choice').val()==1){
            document.getElementById("showtittle").innerHTML = "您可优先加载缓存资源";
            document.getElementById("showTips").innerHTML=xmlhttp.responseText;
            }
            
        }
    }
    xmlhttp.open("GET","https://www.6zgm.com/zgm/searchout.php?q="+str,true);
    xmlhttp.send();
}
$("#url").bind("input propertychange",function(event){
        // showTips($("#url").val());
       
});

function myrefresh()
{
       var stayhere = "https://www.6zgm.com/video.html";
        $(".pt-3").load(stayhere + " .pt-3");
} //指定1秒刷新一次

$(document).ready(function() {
    
});
 




function Dplayers(url){
    $("#HLScc")[0].click();
   /* alert(url);*/
   
    $("#dpp").load(url);
}

function infoend(url){
    $("#whatashit").attr("href",url);
    $("#whatashit")[0].click();
}

function infoendForHistory(url){
    
    $("#historyButtonSwitch")[0].click();
    $("#whatashit").attr("href",url);
    $("#whatashit")[0].click();
}

function clickurl(url){
   
    $("#Go").attr("href",url);
    $("#Go")[0].click();
}
    
var countttttter=1;
if(countttttter>10){
    countttttter=5;
    console.log(countttttter);
}
$(".form-controlsOOGG").bind("click", function() {
			$(".form-controlsOOGG").autocomplete({
    source: function(request, response){

        var a = $('.form-controlsOOGG').val();

        $.ajax({
            url: "https://www.6zgm.com/youtube/ajax/autocomplete.php?q="+a,
            dataType: 'jsonp',
            success: function(data, textStatus, request) {
               response( $.map( data[1], function(item) {
                    return {
                        label: item[0],
                        value: item[0]
                    }
                }));
            }
        });
    },

});
		});


function cantstart(){
	var thisurl=window.location.href;
	$(".my-infoc").load(thisurl + " .my-infoc");
	if (typeof Prism !== 'undefined') {
	    (function($){
	var isIE;
	$.fn.tw_input_placeholder = function(option){
		isIE = (navigator.appName == 'Microsoft Internet Explorer');
		var opt = $.extend({
			speed: 100,
			delay: 2000,
			keywords: ['keywords'],
		}, (option||{}));
		if(typeof opt.keywords=='string'){
			opt.keywords = [opt.keywords];
		}
		return this.each(function(){
			var input = $(this);
			var input_element = input.get(0);
			var keywordsx, inputx, keywords;
			//var input = input;
			function st(){
				keywordsx = inputx = 0;
				keywords = opt.keywords[keywordsx];
				input.show();
				tw();
			}
			input.focus(function(){
				if(!isIE){
				$(input).attr("placeholder",'');
				}else{
					input.val("")
				}
				var ti = $.data(input_element, 'tw_input');
				if(ti){
					clearTimeout(ti);
					$.data(input_element, 'tw_input', false);
				}else{
					$(this).select();
				}
			});
			input.blur(function(){
				if(input.val()==''){st();}
			});
			function tw(){
				if(!isIE){
					$(input).attr("placeholder",keywords.substring(0, inputx++)+'|');
				}else{
					input.val(keywords.substring(0, inputx++)+'|');
				}
				if(inputx > keywords.length){
					$.data(input_element, 'tw_input', setTimeout(function(){
						if(++keywordsx >= opt.keywords.length){keywordsx=0;}
						keywords = opt.keywords[keywordsx];
						inputx = 0;
						tw();
					}, opt.delay));
				}else{
					$.data(input_element, 'tw_input', setTimeout(tw, opt.speed));
				}
			}
			if(!input.val()){st();}
		});
	}
})(jQuery);
        
	    $('.form-controls').tw_input_placeholder({
            speed: 100,
            delay: 2000,
            keywords: ['想看点啥?','您可以输入一个视频关键词', '致我们暖暖的小时光','小猪佩奇','亲爱的，热爱的','也可以输入一个Youtube视频链接','https://www.youtube.com/watch?v=3qrsX5PIUn4', '或者是输入一个分类',
                    'Music']
        });
	}
	
	countttttter++;	        
}

function lunbo() {
  //initialize swiper when document ready
  var mySwiper = new Swiper ('.swiper-container', {
    // Optional parameters
    autoplay: {
    delay: 3572,
     },
    direction: 'horizontal',
    loop: true,
    effect: 'slide',
    // If we need pagination
    /*pagination: {
      el: '.swiper-pagination',
    },*/

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  })
};

// var time_range = function (beginTime, endTime) {
//      var strb = beginTime.split (":");
//      if (strb.length != 2) {
//          return false;
//      }
 
//      var stre = endTime.split (":");
//      if (stre.length != 2) {
//          return false;
//      }
 
//      var b = new Date ();
//      var e = new Date ();
//      var n = new Date ();
 
//      b.setHours (strb[0]);
//      b.setMinutes (strb[1]);
//      e.setHours (stre[0]);
//      e.setMinutes (stre[1]);
 
//      if (n.getTime () - b.getTime () > 0 && n.getTime () - e.getTime () < 0) {
//          return true;
//      } else {
//          alert ("当前时间是：" + n.getHours () + ":" + n.getMinutes () + "，不在该时间范围内！");
//          return false;
//      }
//  }
// time_range ("22:30", "6:00");

		
function bach(){
    $("#1234567")[0].click();
    //
    history.back(-1);
}

function pjaxsearch(){
    $(".form-controls").autocomplete({
    source: function(request, response){

        var a = $('.form-controls').val();

        $.ajax({
            url: "https://www.6zgm.com/youtube/ajax/autocomplete.php?q="+a,
            dataType: 'jsonp',
            success: function(data, textStatus, request) {
               response( $.map( data[1], function(item) {
                    return {
                        label: item[0],
                        value: item[0]
                    }
                }));
            }
        });
    },

});
}

function swifts(){
    $("#12345")[0].click();
}

$("#doplayers").bind("click", function() {
			play3()
			
		});

$("#choice").change(function(){
    var ppi = $("#choice").val();
    if(ppi==3){
        /*location.hash="musicconer";*/
    }
})

	

$("#playtest").bind("click", function() {
            var a = $('#url').val();
            a=encodeURIComponent(a);
            var jumpto = "https://www.6zgm.com/video.html?qc="+a+"&t="+a;
            if(a==""){
                /*$(".hellomytxt").load(jumpto + " .hellomytxt");*/
                $.message({title:"艺术长廊",message:"你需要输入关键词",type:"error"})
            }else{
                if($('#choice').val()==1){
                    setCookie("ArtMovie",a,1);
                    $("#ckvip").hide();
                    showHint(a);
                    $("#Go").attr("href",jumpto);
                    $("#Go")[0].click();
                }else if($('#choice').val()==2){
			        setCookie("ArtMovie",a,1);
                    $("#ckvip").hide();
                    showHint(a);
                    jumpto=jumpto+"#jiexi";
                    $("#Go").attr("href",jumpto);
                    $("#Go")[0].click();
			    }else if($('#choice').val()==3){
			        var jumpto ='https://www.6zgm.com/video.html?mytype=music&t='+a+'&i='+a;
			     //   document.getElementById('muccin').data-src=a;
			        //$("#Go").attr("href",jumpto);
			        window.open(jumpto);
                    //$("#Go")[0].click();
            /*$("#Go").attr("href",jumpto);
            $("#Go")[0].click();*/
                    /*$.message({title:"正在获取数据",message: "正在为你搜索"+a+"，搜索完成后我们会自动呈现",type:"info"})
                    $(".neteaser").load(jumpto);*/
			    }else if($('#choice').val()==4){
			        jumpto = "https://www.6zgm.com/video.html?id="+a;
			        $("#Go").attr("href",jumpto);
                    $("#Go")[0].click();
			    }else if($('#choice').val()==5){
			        jumpto = "https://www.6zgm.com/video.html?&plus=1&key=rss&rss="+a;
			        $("#Go").attr("href",jumpto);
                    $("#Go")[0].click();
			    }
                
            }
			
/*// 			$(".row").load(jumpto + " .row");
// 			$(".hhh").load(jumpto + " .hhh");
// 			$(".videocontentrow").load(jumpto + " .videocontentrow");
// 			$("#videocontent").load(jumpto + " #videocontent");
// 			$.pjax.reload('#jumpcontainer');
            $("#videocontent").load(a);*/
			
		});	
		
		
function changepic(){
    var jumpto = "https://www.6zgm.com/video.html";
    $(".hellomytxt").load(jumpto + " .hellomytxt");
}		
function play3() {
			var a = $('#url').val();
			a=encodeURIComponent(a);
			if($('#choice').val()==1){
			    if ($('#url').val() == "") {
				$(".search_input").attr("placeholder","属性值");
				//alert('输入框不合法！');
				$('#url').focus();
				return (false)
			}
// 			$('#my-info').load("/youtube.html?q="+ a +  ' #my-info');
// 			$('#my-info').load("/youtube.html?q="+ a +  ' #videocontent');
// 			$('#my-info').load("/youtube.html?q="+ a +  ' .col-xs-6 col-sm-6 col-md-4 col-lg-4');
// 			$("#my-info").load("/youtube.html?q="+ a+" #my-info>*","");
			window.location.replace("https://www.6zgm.com/video.html?q="+a);
			}
			if($('#choice').val()==2){
			    window.open("http://wow.6zgm.com/?v="+a);
			}
			
		}

	

function ifkey13Search(){
	var ev = (typeof event!= 'undefined') ? window.event : e;
	if(ev.keyCode == 13) {
				// play3()
			var a = $('#url').val();
            var jumpto = "https://www.6zgm.com/video.html?qc=" +a+"&t="+a;
            if(a==""){
                /*$(".hellomytxt").load(jumpto + " .hellomytxt");*/
                $.message({title:"艺术长廊",message:"你需要输入关键词",type:"error"})
            }else{
                if($('#choice').val()==1){
                    setCookie("ArtMovie",a,1);
                    $("#ckvip").hide();
                    showHint(a);
                    $("#Go").attr("href",jumpto);
                    $("#Go")[0].click();
                }else if($('#choice').val()==2){
			        setCookie("ArtMovie",a,1);
                    $("#ckvip").hide();
                    showHint(a);
                    jumpto=jumpto+"#jiexi";
                    $("#Go").attr("href",jumpto);
                    $("#Go")[0].click();
			    }else if($('#choice').val()==3){
			        /*var jumpto = "https://searchsong.6zgm.com/?name=" +a+"&type=netease";*/
			        var jumpto ='https://www.6zgm.com/video.html?mytype=music&t='+a+'&i='+a;
			     //   document.getElementById('muccin').data-src=a;
			        window.open(jumpto);
            /*$("#Go").attr("href",jumpto);
            $("#Go")[0].click();*/
                    /*$.message({title:"正在获取数据",message: "正在为你搜索"+a+"，搜索完成后我们会自动呈现",type:"info"})
                    $(".neteaser").load(jumpto);*/
			    }else if($('#choice').val()==4){
			        jumpto = "https://www.6zgm.com/video.html?id="+a;
			        $("#Go").attr("href",jumpto);
                    $("#Go")[0].click();
			    }else if($('#choice').val()==5){
			        jumpto = "https://www.6zgm.com/video.html?&plus=1&key=rss&rss="+a;
			        $("#Go").attr("href",jumpto);
                    $("#Go")[0].click();
			    }
                
            }
                return false;
	}
}

function getQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	var r = window.location.search.substr(1).match(reg);
	if (r != null) {
		return decodeURI(r[2]);
	} 
	return null;
}



function showHint(str)
{
    if (str.length==0)
    { 
        document.getElementById("txtHint").innerHTML="";
        return;
    }
    if (window.XMLHttpRequest)
    {
        // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行的代码
        xmlhttp=new XMLHttpRequest();
    }
    else
    {    
        //IE6, IE5 浏览器执行的代码
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","https://www.6zgm.com/zgm/develop.php?q="+str,true);
    xmlhttp.send();
}

function changeRealUrlOfPic(){
    var alist = document.getElementsByClassName("needtochangepic");
        if(alist){
            for(var idx = 0; idx < alist.length; idx ++){
                var mya = alist[idx];
                if(mya.src!=mya.getAttribute("data-src") && isInViewPortOfOne(mya)){
                    mya.src=mya.getAttribute("data-src");
                }
               
                
            }
    }
}

function LoadAllchangeRealUrlOfPic(){
    var alist = document.getElementsByClassName("needtochangepic");
        if(alist){
            for(var idx = 0; idx < alist.length; idx ++){
                var mya = alist[idx];
                if(mya.src!=mya.getAttribute("data-src")){
                    mya.src=mya.getAttribute("data-src");
                }
               
                
            }
    }
}


 function getElementTopLeft(obj) {
        var top = 0;
        var left = 0;

        while(obj){
            top += obj.offsetTop;
            left += obj.offsetLeft;

            obj = obj.offsetParent;
        }

        return {top:top,left:left};
    }
    
function isInViewPortOfOne (element) {
   if (getElementTopLeft(element).top + element.clientHeight > window.pageYOffset && window.pageYOffset + window.innerHeight > getElementTopLeft(element).top) {
            return true;
        } else {
            return false;
    }
}

function setCookie(cname,cvalue,exdays)
{
  var d = new Date();
  d.setTime(d.getTime()+(exdays*24*60*60*1000));
  var expires = "expires="+d.toGMTString();
  document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname)
{
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i=0; i<ca.length; i++) 
  {
    var c = ca[i].trim();
    if (c.indexOf(name)==0) return c.substring(name.length,c.length);
  }
  return "";
}

function nobarSS(){
    var Bars=getCookie("noSbar");
    
    
    if(Bars=="" || Bars!="1"){
        var r = confirm("是否确认切换到宽屏版？(仅桌面端有效)");
        if (r == true) {
            setCookie("noSbar","1",666);
            location.reload();
        } else {
            
        }
        
    }else{
        var r = confirm("是否确认切换到聚屏版？(仅桌面端有效)");
        if (r == true) {
            setCookie("noSbar","0",666);
            location.reload();
        } else {
            
        }
        
    }
    
}

function changeStyle(){
    addSettingOption("number-setting-1","fat","","聚焦/宽广","nobarSS()");
    addSettingOption("number-setting-2","night","","全局反色(不稳定)","switchNightMode()");
    addSettingOption("number-setting-3","dark","","低亮度(夜间适用)","ToDark()");
    $("#settingSwitch")[0].click();
}


function myRecommend(url,tittle){
    if(tittle==""){
        $.message({title:"艺术长廊",message:"非常抱歉，当前位置不适合被推荐。",type:"error"})
        return;
    }else{
        var fd = new FormData();
        fd.append('url',url);
        fd.append('tittle',tittle);
        fd.append('recommend',1);
        $.ajax({
    url: 'https://www.6zgm.com/usr/themes/handsome/videoCenter/upperdb.php',
    type: 'POST',
    cache: false,
    data: fd,
    processData: false,
    contentType: false
            }).done(function(res) {
        /*document.getElementById("Furl").value=res;*/
        $.message({title:"艺术长廊",message:"已加入推荐名单",type:"success"})
        

    }).fail(function(res) {
        $.message({title:"艺术长廊",message:"网络错误,请重试！",type:"error"})
        //document.getElementById("commentfile").value="创建失败，请重试";
    });
    }
}


function chuxiye(){
    $.fancybox.open({
	src  : "https://www.17sucai.com/preview/945243/2018-02-15/firework/index.html",
	type : 'iframe',
	opts : '新年快乐！'
    });
    setTimeout('$.fancybox.close();',29599);
}

function modelchoice(id,name,check,text,onclick){
    var appendChoice1='<div id="'+id+'" class="m-b-sm">'+
    '<label class="i-switch bg-info pull-right">'+
        '<input type="checkbox" name="'+name+'" value="1" '+check+' onclick="'+onclick+'">'+
            '<i></i>'+
    '</label>'+
    text+
'</div>';
    return appendChoice1;
}

//$( "#options-Panel-choices" ).prepend(modelchoice("fat","","聚焦/宽广","nobarSS()"));

function addSettingOption(id,name,check,text,onclick){
     if(document.getElementById(id)){} 
     else {$( "#options-Panel-choices" ).prepend(modelchoice(id,name,check,text,onclick));}
    
}

$("#settingSwitch").bind("click", function() {
    addSettingOption("number-setting-1","fat","","聚焦/宽广","nobarSS()");
    addSettingOption("number-setting-2","night","","全局反色(不稳定)","switchNightMode()");
    addSettingOption("number-setting-3","dark","","低亮度(夜间适用)","ToDark()");
})

function belongmyTop(){
    if(document.documentElement.scrollTop>0){
        $("#goToTop")[0].click();
   document.getElementById("goToTop").click();
    }
     
}


function switchDoneP(type){
    type=encodeURIComponent(type);
    var haveSearch=document.getElementById("search_input").value;
    if(haveSearch==""){
        haveSearch=getQueryString("qc");
    }
    var jumpto="https://www.6zgm.com/video.html?mytype=search&sort="+type+"&value="+haveSearch;
    document.getElementById("search_input").value="";
    $("#whatashit").attr("href",jumpto);
    $("#whatashit")[0].click();
}