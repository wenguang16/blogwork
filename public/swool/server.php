<?php

$server = new swoole_websocket_server("192.168.10.10", 1099);
$server->on('open', function (swoole_websocket_server $server, $request) use ($config){
    echo "server: handshake success with fd{$request->fd}\n";
});

$server->on('message', function (swoole_websocket_server $server, $frame) {

});