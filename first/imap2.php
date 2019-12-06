<?php
//以腾讯企业邮箱做了测试
$mailServer="imap.exmail.qq.com"; //IMAP主机

$mailLink="{{$mailServer}:143}INBOX" ; //imagp连接地址：不同主机地址不同

$mailUser = 'noreply@6zgm.com'; //邮箱用户名

$mailPass = 'zyzy666@QWE'; //邮箱密码

$mbox = imap_open($mailLink,$mailUser,$mailPass); //开启信箱imap_open

$totalrows = imap_num_msg($mbox); //取得信件数

for ($i=1;$i<$totalrows;$i++){

    $headers = imap_fetchheader($mbox, $i); //获取信件标头

    $headArr = matchMailHead($headers); //匹配信件标头

    $mailBody = imap_fetchbody($mbox, $i, 1); //获取信件正文
    echo $mailBody;

}

/**
 * 
 * 匹配提取信件头部信息
 * @param String $str
 */
function matchMailHead($str){
    $headList = array();
    $headArr = array(
        'from',
        'to',
        'date',
        'subject'
    );

    foreach ($headArr as $key){
        if(preg_match('/'.$key.':(.*?)[\n\r]/is', $str,$m)){
            $match = trim($m[1]);
            $headList[$key] = $key=='date'?date('Y-m-d H:i:s',strtotime($match)):$match;
        }
    }
    return $headList;
}
?>