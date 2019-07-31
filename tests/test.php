<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2019/7/31
 * Time: 17:40
 */

require "../vendor/autoload.php";

use Siam\HttpMonitor\Monitor;


$monitor = Monitor::getInstance(4);
$monitor->log(['time' => time()]);
$monitor->log(['time' => time()]);
$monitor->log(['time' => time()]);
$monitor->log(['time' => time()]);

$list = $monitor->getList();

var_dump($list);