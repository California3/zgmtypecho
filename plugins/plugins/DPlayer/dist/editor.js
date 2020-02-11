$(function () {
    if ($('#wmd-button-row').length > 0) {
        $('#wmd-button-row').append('<li class="wmd-button" id="wmd-dplayer-button" style="" title="插入视频"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABGUlEQVQ4T6XTvyuFURgH8M9lkTKYlMGiRDKIxSQDkcFgYVAmi8WPwY+Uxa8FhWQmWdgMiAxmf4BYpFAGSRkY6K1z6tJ1vTdnfc/zOU/P830z/nkyoX4GIyjHHKrQjyXUoh3raEQT9nGDjQQowjk6cYcBnOIJHbjCY4DecYtK7KIrAUqwiNHweh16sRa+DWEbD5jAIS5QgekIJB0cB3kwgNXowTLq0YpNNKMB92iLwALGCpznSnYHP4EyvP4B5gX6wlaGcfkL9Cewh0/sYDIMMdtKBcSCN4xjK0tIDXyE6c/ipVAg2Xmynescc/jWQQxSvNeCUpzl2cQqpmKUj0JsC4nCSRL/+DMl66rBcwqhGN04wHwEUtTlvvIFs5ZDZeiythMAAAAASUVORK5CYII="/></li>');
    }

    $(document).on('click', '#wmd-dplayer-button', function () {
        $('body').append(
            '<div id="DPlayer-Panel">' +
            '<div class="wmd-prompt-background" style="position: absolute; top: 0px; z-index: 1000; opacity: 0.5; height: 875px; left: 0px; width: 100%;"></div>' +
            '<div class="wmd-prompt-dialog">' +
            '<div>' +
            '<p><b>插入视频</b></p>' +
            '<p>在下方输入参数</p>' +
            '<p><input type="text" id="DP-url" value="" placeholder="链接"></input></p>' +
            '<p><input type="text" id="DP-pic" value="" placeholder="封面图"></input></p>' +
            '<p><input type="text" id="DP-addition" value="" placeholder="额外弹幕源"></input></p>' +
            '<p><input type="checkbox" id="DP-danmu" checked>开启弹幕</input></p>' +
            '<p><input type="checkbox" id="DP-autoplay">自动播放</input></p>' +
            '</div>' +
            '<form>' +
            '<button type="button" class="btn btn-s primary" id="ok2">确定</button>' +
            '<button type="button" class="btn btn-s" id="cancel">取消</button>' +
            '</form>' +
            '</div>' +
            '</div>');
    });
    //cancel
    $(document).on('click', '#cancel', function () {
        $('#DPlayer-Panel').remove();
        $('textarea').focus();
    });
    //ok
    $(document).on('click', '#ok2', function () {
        var DP_url = document.getElementById('DP-url').value,
            DP_pic = document.getElementById('DP-pic').value,
            DP_danmu = document.getElementById('DP-danmu').checked ? true : false,
            DP_autoplay = document.getElementById('DP-autoplay').checked ? true : false,
            DP_addition = document.getElementById('DP-addition').value;
        var tag = '[dplayer url="' + DP_url + '" pic="' + DP_pic + '" ';
        if (!DP_danmu) tag += 'danmu="' + DP_danmu + '" ';
        if (DP_autoplay) tag += 'autoplay="' + DP_autoplay + '" ';
        if (DP_addition) tag += 'addition="' + DP_addition + '" ';
        tag += '/]\n';
        
        tag="!!!\n<link rel=\"stylesheet\" href=\"https://www.6zgm.com/usr/plugins/DPlayer/dist/DPlayer.min.css\"><div id=\"dplayer\"></div><script src=\"https://www.6zgm.com/usr/plugins/DPlayer/plugin/hls.min.js\"></script><script src=\"https://www.6zgm.com/usr/plugins/DPlayer/plugin/flv.min.js\"></script><script src=\"https://www.6zgm.com/usr/plugins/DPlayer/dist/DPlayer.min.js\"></script><script>const dp = new DPlayer({container: document.getElementById('dplayer'),autoplay: false,theme: '#FADFA3',loop: false,lang: 'zh',hotkey: true, preload: 'auto',screenshot: false,video: {url: '";
        
        tag += DP_url;
        
        tag += "',pic: '";
        
        tag += DP_pic;
        
        tag+="',thumbnails: 'thumbnails.jpg'},danmaku: {id: 'demo',api: '";
        
        tag+=DP_danmu;
        tag+="'}});</script>\n!!!\n";
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        myField = document.getElementById('text');

        if (document.selection) {
            myField.focus();
            sel = document.selection.createRange();
            sel.text = tag;
            myField.focus();
        }
        else if (myField.selectionStart || myField.selectionStart == '0') {
            var startPos = myField.selectionStart;
            var endPos = myField.selectionEnd;
            var cursorPos = startPos;
            myField.value = myField.value.substring(0, startPos)
                + tag
                + myField.value.substring(endPos, myField.value.length);
            cursorPos += tag.length;
            myField.focus();
            myField.selectionStart = cursorPos;
            myField.selectionEnd = cursorPos;
        }
        else {
            myField.value += tag;
            myField.focus();
        }

        $('#DPlayer-Panel').remove();
    })
});

$(function () {
    if ($('#wmd-button-row').length > 0) {
        $('#wmd-button-row').append('<li class="wmd-button" id="wmd-dplayer-button2" style="" title="插入可复制内容或代码"><img src="https://www.6zgm.com/usr/themes/handsome/usr/img/sj2/3.jpg" height="16" width="16"/></li>');
    }
    $(document).on('click', '#wmd-dplayer-button2', function () {
        $('body').append(
            '<div id="DPlayer-Panel2">' +
            '<div class="wmd-prompt-background" style="position: absolute; top: 0px; z-index: 1000; opacity: 0.5; height: 875px; left: 0px; width: 100%;"></div>' +
            '<div class="wmd-prompt-dialog">' +
            '<div>' +
            '<p><b>插入可复制内容或代码</b></p>' +
            '<p>在下方输入参数</p>' +
            '<p><input type="text" id="DP-url2" value="" placeholder="代号"></input></p>' +
            '<p><input type="text" id="DP-pic2" value="" placeholder="可复制内容"></input></p>' +
            '</div>' +
            '<form>' +
            '<button type="button" class="btn btn-s primary" id="ok22">确定</button>' +
            '<button type="button" class="btn btn-s" id="cancel">取消</button>' +
            '</form>' +
            '</div>' +
            '</div>');
    });
    //cancel
    $(document).on('click', '#cancel', function () {
        $('#DPlayer-Panel2').remove();
        $('textarea').focus();
    });
    //ok
    $(document).on('click', '#ok22', function () {
        var DP_url = document.getElementById('DP-url2').value,
            DP_pic = document.getElementById('DP-pic2').value;
        var tag = '[dplayer url="' + DP_url + '" pic="' + DP_pic + '" ';

        tag += '/]\n';
        
        tag="```";
        
        tag += DP_url;
        
        tag += "\n";
        
        tag += DP_pic;
        
        tag+="\n```\n";
        
        myField = document.getElementById('text');

        if (document.selection) {
            myField.focus();
            sel = document.selection.createRange();
            sel.text = tag;
            myField.focus();
        }
        else if (myField.selectionStart || myField.selectionStart == '0') {
            var startPos = myField.selectionStart;
            var endPos = myField.selectionEnd;
            var cursorPos = startPos;
            myField.value = myField.value.substring(0, startPos)
                + tag
                + myField.value.substring(endPos, myField.value.length);
            cursorPos += tag.length;
            myField.focus();
            myField.selectionStart = cursorPos;
            myField.selectionEnd = cursorPos;
        }
        else {
            myField.value += tag;
            myField.focus();
        }

        $('#DPlayer-Panel2').remove();
    })
});

$(function () {
    if ($('#wmd-button-row').length > 0) {
        $('#wmd-button-row').append('<li class="wmd-button" id="wmd-dplayer-button3" style="" title="插入iFrame框架"><img src="https://www.6zgm.com/usr/themes/handsome/usr/img/sj2/4.jpg" height="16" width="16"/></li>');
    }
    $(document).on('click', '#wmd-dplayer-button3', function () {
        $('body').append(
            '<div id="DPlayer-Panel3">' +
            '<div class="wmd-prompt-background" style="position: absolute; top: 0px; z-index: 1000; opacity: 0.5; height: 875px; left: 0px; width: 100%;"></div>' +
            '<div class="wmd-prompt-dialog">' +
            '<div>' +
            '<p><b>插入iFrame框架</b></p>' +
            '<p>在下方输入参数</p>' +
            '<p><input type="text" id="DP-url3" value="" placeholder="输入内嵌网址"></input></p>' +
            '<p><input type="text" id="DP-pic3" value="" placeholder="量衡框架高度（需带单位）"></input></p>' +
            '</div>' +
            '<form>' +
            '<button type="button" class="btn btn-s primary" id="ok3">确定</button>' +
            '<button type="button" class="btn btn-s" id="cancel">取消</button>' +
            '</form>' +
            '</div>' +
            '</div>');
    });
    //cancel
    $(document).on('click', '#cancel', function () {
        $('#DPlayer-Panel3').remove();
        $('textarea').focus();
    });
    //ok
    $(document).on('click', '#ok3', function () {
        var DP_url = document.getElementById('DP-url3').value,
            DP_pic = document.getElementById('DP-pic3').value;
        var tag = '[dplayer url="' + DP_url + '" pic="' + DP_pic + '" ';

        
        tag="!!!\n<div itemscope itemtype=\"https://schema.org/VideoObject\"><meta itemprop=\"uploadDate\" content=\"Sun Sep 08 2019 11:11:59 GMT+0800 (中国标准时间)\"/><meta itemprop=\"name\" content=\"Cctv2\"/><div style=\"position:relative; overflow:hidden; padding-bottom:56.25%\"> <iframe src=\"";
        
        tag += DP_url;
        
        tag += "\" width=\"100%\" height=\"";
        
        tag += DP_pic;
        
        tag+="\" frameborder=\"0\" scrolling=\"auto\" style=\"position:absolute;\" allowfullscreen></iframe> </div></div>\n!!!\n";
        
        myField = document.getElementById('text');

        if (document.selection) {
            myField.focus();
            sel = document.selection.createRange();
            sel.text = tag;
            myField.focus();
        }
        else if (myField.selectionStart || myField.selectionStart == '0') {
            var startPos = myField.selectionStart;
            var endPos = myField.selectionEnd;
            var cursorPos = startPos;
            myField.value = myField.value.substring(0, startPos)
                + tag
                + myField.value.substring(endPos, myField.value.length);
            cursorPos += tag.length;
            myField.focus();
            myField.selectionStart = cursorPos;
            myField.selectionEnd = cursorPos;
        }
        else {
            myField.value += tag;
            myField.focus();
        }

        $('#DPlayer-Panel3').remove();
    })
});
