<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2019/8/1
 * Time: 9:09
 */


require "../vendor/autoload.php";
use Siam\HttpMonitor\Config;
use Siam\HttpMonitor\Monitor;


$config = new Config([
    'size'      => 20,
    'listUrl'   => '/get_list',
    'temDir'    => getcwd()."/Temp",
    'resendUrl' => '/resend',
]);

$monitor = Monitor::getInstance($config);

// 添加白名单 无需记录
$monitor->addFilter('/get_list');
$monitor->addFilter('/favicon.ico');
$monitor->addFilter('/list_view');
$monitor->addFilter('/resend');

$http = new Swoole\Http\Server("0.0.0.0", 9502);

$http->set([
    'worker_num' => 4,    //worker process num
]);

$http->on('request', function ($request, $response) {

    Monitor::getInstance()->log([
        'header'     => $request->header,
        'server'     => $request->server,
        'get'        => $request->get,
        'post'       => $request->post,
        'cookie'     => $request->cookie,
        'files'      => $request->files,
        'rawContent' => $request->rawContent(),
        'data'       => $request->getData(),
    ]);

    if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
        return $response->end('');
    }
    if ($request->server['path_info'] == '/get_list' || $request->server['request_uri'] == '/get_list') {
        return $response->end(Monitor::getInstance()->getList());
    }
    if ($request->server['path_info'] == '/list_view' || $request->server['request_uri'] == '/list_view') {
        return $response->end(Monitor::getInstance()->listView());
    }
    if ($request->server['path_info'] == '/resend' || $request->server['request_uri'] == '/resend') {
        $content = $request->rawContent();
        $content = json_decode($content, true);
        return $response->end(Monitor::getInstance()->resend($content['id']));
    }
    $response->end($request->rawContent() ?? 'siam');
});

$http->start();
