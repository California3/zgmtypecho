function showbroswer(){
            if((!!window.ActiveXObject || "ActiveXObject" in window)){
                $.message({title:"通知",message:"当前正使用IE浏览器访问",type:"success"})
            }
            else if(navigator.userAgent.indexOf("Firefox")!=-1){
                //alert('Firefox');//火狐浏览器
                $.message({title:"通知",message:"当前正使用Firefox浏览器访问",type:"success"})
            }
            else if(navigator.userAgent.indexOf("Chrome")!=-1){
                //alert("Chrome");//Chrome内核浏览器
                $.message({title:"通知",message:"当前正使用Chrome浏览器访问",type:"success"})
            }
            else if(navigator.userAgent.indexOf("Safari")!=-1){
                //alert("Safari");//Safari浏览器
                $.message({title:"通知",message:"当前正使用Safari浏览器访问",type:"success"})
            }
}

document.body.oncopy = function(){$.message({title:"拷贝提醒",message:"复制成功！",type:"success"})}

function switchNightMode(){
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || '0';
    if(night == '0' ){
        document.querySelector('link[title="dark"]').disabled = true;
        document.querySelector('link[title="dark"]').disabled = false;
        document.cookie = "night=1;path=/"
        console.log('夜间模式开启');
        $.message({title:"Css提醒:请轻触一下使用",message:"已开启夜间模式！(实验室功能)",type:"success"})
        $("#ngng span").click();
    }else{
        document.querySelector('link[title="dark"]').disabled = true;
        document.cookie = "night=0;path=/"
        console.log('夜间模式关闭');
       $.message({title:"Css提醒",message:"已恢复至日间模式！",type:"success"})
       $("#ngng span").click();
    }
}

function addNumber(a) {
    var length = document.getElementById("comment").value.length;
    if(length> 0){
        document.getElementById("comment").focus()
        document.getElementById("comment").value += '\n' + a + new Date
    }else{
        document.getElementById("comment").focus()
        document.getElementById("comment").value += a + new Date
    }
}

function appendcc(a) {
    var length = document.getElementById("comment").value.length;
    if(length> 0){
        document.getElementById("comment").focus()
        document.getElementById("comment").value += '\n' + a + '\n';
    }else{
        document.getElementById("comment").focus()
        document.getElementById("comment").value += a + '\n';
    }
}



function changecheck(id) {
    var obj = document.getElementById(id);
	var value = obj.checked;
	//alert("hello");// 若选中，则返回true，否则返回false
	if(obj.checked == true){
		obj.checked = false
		$.message({title:"评论提醒",message:"已设为公开评论！",type:"success"})
	}else{
		obj.checked = true
		$.message({title:"评论提醒",message:"已设为私密评论！",type:"success"})
	}
	
}

function ac1(id) {
    var obj = document.getElementById(id);
	var value = obj.checked;
	//alert("hello");// 若选中，则返回true，否则返回false
	if(obj.checked == true){
		switchNightMode();
	}else{
		switchNightMode();
	}
	
}


function fileuploader(){
	$.message({title:"评论提醒",message:"已设为公开评论！",type:"success"})
	window.open("https://native.6zgm.com/index.php?share/folder&user=1&sid=TIcxFQ7K","_blank");
	addNumber('附件上传：[ 请在这里输入你的文件名 ](https://sss.6zgm.com/svXjKM) #时间是：')
}

function openbox(){
	var paypal = "https://www.6zgm.com/tools/p2p.html#post-panel";
	window.open(paypal,"_blank","toolbar=no,scrollbars=yes,visible=none,width=350,height=620")
}

function scanqr(){
	var paypal = "https://pay.6zgm.com/";
	window.open(paypal,"_blank","toolbar=no,scrollbars=yes,visible=none,width=350,height=620")
}

$("#ac1").change(function() {
$("#ngng span").click();
});





/*
var xmlHttple;
var kill = "a";
function showTips(a){
    if (window.XMLHttpRequest)
    {
        // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行的代码
        xmlhttple=new XMLHttpRequest();
    }
    else
    {    
        //IE6, IE5 浏览器执行的代码
        xmlhttple=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttple.onreadystatechange=function(){
        if (xmlhttple.readyState==4 && xmlhttple.status==200)
        {
            if(xmlhttple.responseText=='a'){
                addUser(a);
            }else{
                $.message({title:"请先支付！",message:"支付成功后我们会启动验证程序。",type:"error"})
            }
            }    
    }
    xmlhttple.open("GET","https://www.6zgm.com/zgm/find.php?q="+a,true);
    xmlhttple.send();
}
function submitmyReq(a){
    showTips(a);
}
function addUser(a) {
    var length = document.getElementById("comment").value.length;
    /*if(length> 0){
        document.getElementById("comment").focus()
        document.getElementById("comment").value += '\n' + "https://www.6zgm.com/iii/user.php?uid=" + a +"#vpn-0-8" 
    }else{
        document.getElementById("comment").focus()
        document.getElementById("comment").value += "https://www.6zgm.com/iii/user.php?uid=" + a +"#vpn-0-8" 
    }*/
   /* var url = "https://sc.ftqq.com/SCU50697T715acd21122d55ae371029c79140c2dd5ccecda1174b0.send?text=" + a + "申请VPN&desp=https://www.6zgm.com/zgm/give.php?u=" +a;
	document.getElementById("cc").src=url;
	document.getElementById("comment").value += "我提交了VPN授权申请。本人："+a;
	start3();
	$('#mysortclose').click();
	
	
	$.message({title:"已提交申请",message:"您已成功提交申请，请确保评论区已经留下支付截图。",type:"success"})
	
	
}*/






/*<div class="panel-heading">
                  <?php _me("功能设置") ?>	
          </div>
          
          <div class="panel-body">
                      <div class="m-b-sm">
                          <label class="i-switch bg-info pull-right">
                              <input type="checkbox" id="ac1" value="1">
                                  <i></i>
                          </label>
                          低亮度模式
            			</div>
          </div>
          
          </div>*/
          

