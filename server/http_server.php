<?php
/**
 * Created by PhpStorm.
 * User: shuyu
 * Date: 2019/8/5
 * Time: 16:34
 */

$http = new Swoole\Http\Server("0.0.0.0", 9501);

$http->set([
    'document_root' => '/data/wwwroot/docment/swoole_live/public/static', // v4.4.0以下版本, 此处必须为绝对路径
    'enable_static_handler' => true,
]);
$http->on('request', function ($request, $response) {
    $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
});
$http->start();