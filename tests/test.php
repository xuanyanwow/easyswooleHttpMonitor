<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2019/7/31
 * Time: 17:40
 */

require "../vendor/autoload.php";
use Siam\HttpMonitor\Config;
use Siam\HttpMonitor\Monitor;

$config = new Config([
    'size'    => 3,
    'listUrl' => '123',
]);

$monitor = new Monitor($config);
$monitor->log(['time' => time()]);
$monitor->log(['time' => time()]);
$monitor->log(['time' => time()]);
$monitor->log(['time' => time()]);


// 获取列表
// $list = $monitor->getList();
// var_dump($list);

// 列表
$monitor->listView();


// 复发请求
$monitor->resend();