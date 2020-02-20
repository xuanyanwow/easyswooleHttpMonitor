<?php
/**
 * 执行者抽象
 * User: Siam
 * Date: 2020/2/20 0020
 * Time: 12:32
 */

namespace Siam\HttpMonitor;

abstract class RunnerAbstract
{
    protected $config;

    abstract public function __construct(Config $config);

    abstract public function addOne($data);

    abstract public function getData($dataKey = null);

    abstract public function checkSize();
}