
function debugkey13Center(){
    var ev = (typeof event!= 'undefined') ? window.event : e;
	if(ev.keyCode != 13) {
	    return ;
	}
	var oj=document.getElementById("thisaremypubliciframeCenter");
	var a = $('#tipsCenter').val();
    if($('#debugchoiceCenter').val()==1){
        oj.src=a;
    }
   
}

function ClickWhereA(oj){
    $("#"+oj)[0].click();
    if(document.documentElement.scrollTop>0){
        belongmyTop();
    }
    
}
function ClickWhereAA(oj){
    $("#"+oj)[0].click();
    
}

