<?php
/**
 * Created by PhpStorm.
 * User: shuyu
 * Date: 2019/8/5
 * Time: 16:34
 */

$http = new Swoole\Http\Server("0.0.0.0", 9501);

$http->set([
    'document_root'          => '/data/wwwroot/docment/swoole_live/public/static', // v4.4.0以下版本, 此处必须为绝对路径
    'enable_static_handler'  => true,
    'worker_num'             => 5
]);

$http->on('WorkerStart', function (swoole_server $server, $worker_id){
    // 定义应用目录
    define('APP_PATH', __DIR__ . '/../application/');
    // ThinkPHP 引导文件
    // 加载基础文件
    require __DIR__ . '/../thinkphp/base.php';

});

$http->on('request', function ($request, $response) {
    if(isset($request->server)){
        foreach ($request->server as $k => $v){
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if(isset($request->header)){
        foreach ($request->header as $k => $v){
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if(isset($request->get)){
        foreach ($request->get as $k => $v){
            $_GET[$k] = $v;
        }
    }
    if(isset($request->post)){
        foreach ($request->post as $k => $v){
            $_POST[$k] = $v;
        }
    }
    //开启缓冲区
    ob_start();
    // 执行应用并响应
    think\Container::get('app', [defined('APP_PATH') ? APP_PATH : ''])
        ->run()
        ->send();
    $res = ob_get_contents();
    ob_end_clean();
    $response->end($res);
});
$http->start();