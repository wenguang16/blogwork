<?php

function request_post($url = '', $param = '')
{
    if (empty($url) || empty($param)) {
        return false;
    }
    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init(); //初始化curl
    curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch); //运行curl
    curl_close($ch);
    return $data;
}


$touser = 'oNaaVt9A7N2nu3PQVYUSZ5NF3EDw';


$first = "恭喜您，获得好运平台返现奖励！";
$keyword1 = "好运来了";
$keyword2 = '50';
$keyword3 = "好运余额";
$keyword4 = "nihao";
$remark = "点击查看返现奖励";
$url = 'http://lucky.xdjst.com/Skyfier/Skyfierhtml/personal/personal.html';
$topcolor  = '#173177';
$data = array(
    "first" => array("value"=>"您好，您的微信支付已成功！", "color"=>"#173177"),
    "keyword1"=>array("value"=>$keyword1,"color"=>"#173177"),
    "keyword2"=>array("value"=>$keyword2, "color"=>"#173177"),
    "keyword3"=> array("value"=>$keyword3, "color"=>"#173177"),
    "keyword4"=> array("value"=>$keyword4, "color"=>"#173177"),
    "remark"=> array("value"=>"点击查看奖励进度！", "color"=>"#173177"),
);

$template = array(
    'touser' => $touser,
    'template_id' => 'taDRhs-vpmLZiWeCXedi_od48IvsL6tholVTmcUkWfw',
    'url' => $url,
    'topcolor' => $topcolor,
    'data' => $data
);
$json_template = json_encode($template);

$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=9_KDJ-kNUNTn_AKTwMQasIzUrWp-SuI4nEcNFdpVe0A-Tse6HNzdjCfiWqgVoaZ8CNUatYbTRy6uw1y4kxkJhTgQdLaqAqKSeZdKf-C0qYGNf1eqpEEZ5eTH_Ay_8kW6b897E7C6n6gvGBPiFYHESkCDAURF';

$res =  request_post($url, urldecode($json_template));
print_r($res);


?>