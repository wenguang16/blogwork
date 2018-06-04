<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22
 * Time: 16:17
 */
$server->on('open', function (swoole_websocket_server $server, $request) use ($config){
    $app = Factory::officialAccount($config['wechat']);
    $result = $app->qrcode->temporary($request->fd, 120);
    $url = $app->qrcode->url($result['ticket']);
    $server->push($request->fd, json_encode([
        'message_type'  => 'qrcode_url',
        'url'    => $url
    ]));
});