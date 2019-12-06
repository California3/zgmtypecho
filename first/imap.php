<?php
/*
 * PHP访问gmail IMAP邮箱的完成代码。
* 示例1：列出邮箱的子目录名称
* 示例2：取出收件箱（INBOX）下所有邮件。可以正确显示中文字符。
*
* 整理/编写：www.tudaxia.com, 2014年1月
* 感谢互联网分享给我们的一切知识！
*/

// gmail邮箱地址
//（注：也可以是托管在Google APP上的账号，实际也是gmail服务器负责提供邮件功能）
$gmail_account = 'noreply@6zgm.com';
// gmail邮箱密码
$gmail_password = 'zyzy666@QWE';

// gmail imap邮件服务器地址
$gmail_imap_host = 'imap.exmail.qq.com';
// imap服务器端口
$gmail_imap_post = 993;
// 根据以上参数，拼凑出imap服务器的完整地址
$gmail_imap_server = '{'.$gmail_imap_host.':'.$gmail_imap_post.'/novalidate-cert/imap/ssl}';

/*
===========================
示例1：gmail的中文目录编码与解码
===========================
(Gmail内部使用UTF7-IMAP编码，所以如果直接显示会乱码，需要进行转码才能正确显示)
 * 
 */
$imap_code = "&V4NXPpCuTvY-";
echo "imap_code: $imap_code\n";
$hanzi = mb_convert_encoding($imap_code, "UTF-8", "UTF7-IMAP");
echo "中文名称 : $hanzi\n";

$encode=  mb_convert_encoding($hanzi, "UTF7-IMAP","UTF-8");
echo "encode : $encode\n";

/*
===========================
// 示例2： 列出所有的邮件Label（相当于邮箱的子目录）
===========================
*
*/
if (($mbox = @imap_open($gmail_imap_server, $gmail_account, $gmail_password)) == true) {
    $folders = imap_list($mbox, $gmail_imap_server, "*");
    foreach ($folders as $folder) {
        // Gmail邮箱目录采用的编码为"UTF7-IMAP"，因此如果要正确显示中文目录名称，需要针对中文目录名称进行UTF-8转码
        // （反之，如果给出中文名字，需要访问gmail的目录，需要先执行UTF-8到UTF7-IMAP的逆向转码）
        $folder = mb_convert_encoding($folder, "UTF-8", "UTF7-IMAP");
        echo $folder . "\n";
    }
    // 关闭imap连接
    imap_close($mbox);
}

/*
 ===========================
// 示例3：查看收件夹（INBOX）的所有邮件
 * 
 */
if (($mailbox_inbox = @imap_open($gmail_imap_server."INBOX", $gmail_account, $gmail_password)) == true) {
    echo "处理INBOX \n";
    scan_mailbox($mailbox_inbox);
    imap_close($mailbox_inbox);
}

function scan_mailbox($mbox) {
    // 获取邮箱信息
    $mboxes=imap_mailboxmsginfo($mbox);

    // 查看是否有新邮件
    if( $mboxes->Nmsgs != 0 ) {
        for( $mailno=1; $mailno<=$mboxes->Nmsgs; $mailno++ ) {

            // 获取邮件内容
            $email = fetchEmail($mbox, $mailno);
            var_dump($email);

            // 删除邮件（打上删除标记）
            //imap_delete($mbox, $mailno);
        }
        // 删除所有打上删除标记的邮件
        //imap_expunge($mbox);
    }
}

/**
 * 获取一封邮件的信息
 * @param resource $imap_stream
 * @param int $msg_number
 */
function fetchEmail($mbox , $mailno) {
    // 获取邮件内容
    $email = array();
    // 获取Header信息
    $head=imap_header($mbox, $mailno);

    // 获取邮件的发件人地址
    $email['from_address']=$head->from[0]->mailbox.'@'.$head->from[0]->host;

    // 初始化邮件主题变量
    $subject = null;
    if( !empty($head->subject) ) {
        // 编码转换
        $mhead=imap_mime_header_decode($head->subject);
        foreach( $mhead as $key=>$value) {
            if( $value->charset != 'default' ) {
                $subject.=mb_convert_encoding($value->text,'UTF-8',$value->charset);
            }else{
                $subject.=$value->text;
            }
        }
    }

    $email['subject'] = $subject;

    global $charset,$htmlmsg,$plainmsg,$attachments;
    $htmlmsg = $plainmsg = $charset = '';
    $attachments = array();

    // BODY
    $s = imap_fetchstructure($mbox,$mailno);
    if (!$s->parts)  // simple
        getpart($mbox,$mailno,$s,0);  // pass 0 as part-number

    else {  // multipart: cycle through each part
        foreach ($s->parts as $partno0=>$p)
            getpart($mbox,$mailno,$p,$partno0+1);
    }

    $email['plainmsg'] = $plainmsg;
    $email['htmlmsg'] = $htmlmsg;
    $email['attachments'] = $attachments;
    return $email;
}

function getpart($mbox,$mid,$p,$partno) {
    // $partno = '1', '2', '2.1', '2.1.3', etc for multipart, 0 if simple
    global $htmlmsg,$plainmsg,$charset,$attachments;

    // DECODE DATA
    $data = ($partno)? imap_fetchbody($mbox,$mid,$partno): imap_body($mbox,$mid);  // simple

    // PARAMETERS
    // get all parameters, like charset, filenames of attachments, etc.
    $params = array();
    if ($p->parameters)
        foreach ($p->parameters as $x)
        $params[strtolower($x->attribute)] = $x->value;
    if (isset($p->dparameters))
        foreach ($p->dparameters as $x)
        $params[strtolower($x->attribute)] = $x->value;

    // ATTACHMENT
    // Any part with a filename is an attachment,
    // so an attached text file (type 0) is not mistaken as the message.
    if (isset($params['filename']) || isset($params['name'])) {
        // filename may be given as 'Filename' or 'Name' or both
        $filename = ($params['filename'])? $params['filename'] : $params['name'];
        // filename may be encoded, so see imap_mime_header_decode()
        $attachments[$filename] = $data;  // this is a problem if two files have same name
    }

    // TEXT
    if( $p->type==0 && !empty($data) ) {
        $charset = $params['charset'];
        $encoding=$p->encoding;

        // 根据encoding参数，进行转码
        switch( $encoding ) {
            case 0 :
                $data=mb_convert_encoding($data, "UTF-8", $charset);
                break;
            case 1 :
                $encode_data=imap_8bit($data);
                $encode_data=imap_qprint($encode_data);
                $data=mb_convert_encoding($encode_data, "UTF-8", $charset);
                break;
            case 3 :
                $encode_data=imap_base64($data);
                $data=mb_convert_encoding($encode_data, "UTF-8", $charset);
                break;
            case 4 :
                $encode_data=imap_qprint($data);
                $data=mb_convert_encoding($encode_data, 'UTF-8', $charset);
                break;
            case 2 :
            case 5 :
            default:
                // 转码失败
                break;
        }

        if (strtolower($p->subtype)=='plain') {
            $plainmsg .= trim($data);

        } else {
            $htmlmsg .= $data;
        }
    }

    // EMBEDDED MESSAGE
    // Many bounce notifications embed the original message as type 2,
    // but AOL uses type 1 (multipart), which is not handled here.
    // There are no PHP functions to parse embedded messages,
    // so this just appends the raw source to the main message.
    if ($p->type==2 && $data) {
        $plainmsg .= $data;
    }

    // SUBPART RECURSION
    if (isset($p->parts)) {
        foreach ($p->parts as $partno0=>$p2)
            getpart($mbox,$mid,$p2,$partno.'.'.($partno0+1));  // 1.2, 1.2.1, etc.
    }
}
?>