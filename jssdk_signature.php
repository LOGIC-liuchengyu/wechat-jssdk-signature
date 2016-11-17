<?php

/**
 * 生成JS-SDK权限验证的签名
 * @author 刘健 <59208859@qq.com>
 */

// 引用文件
include 'autoload.php';
include 'config.php';

// 参数效验
$noncestr = isset($_GET["noncestr"]) ? $_GET["noncestr"] : null;
$timestamp = isset($_GET["timestamp"]) ? $_GET["timestamp"] : null;
$url = isset($_GET["url"]) ? $_GET["url"] : null;

if (is_null($noncestr) || is_null($timestamp) || is_null($url)) {
    die('params noncestr,timestamp,url not null');
}

// 签名计算
$jsapi = Core\Session::jsapiTicket();
$urlArr = array(
    'noncestr=' . $noncestr,
    'timestamp=' . $timestamp,
    'url=' . $url,
    'jsapi_ticket=' . $jsapi->ticket,
);
sort($urlArr, SORT_STRING);
$signature = implode('&', $urlArr);
$signature = sha1($signature);

// 输出
$output = array(
    'noncestr' => $noncestr,
    'timestamp' => $timestamp,
    'signature' => $signature,
);
echo json_encode($output);