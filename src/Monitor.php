<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2019/7/31
 * Time: 17:39
 */

namespace Siam\HttpMonitor;



class Monitor
{
    /**
     * @var LogData
     */
    private $logData;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->logData = new LogData($config->getSize());
        $this->logData->setArray([]);
    }

    public function set

    /**
     * 添加一条记录
     */
    public function log($data)
    {
        $this->logData->addOne($data);
    }

    /**
     * 获取列表
     */
    public function getList()
    {
        $list = $this->logData->getArray();
        return $list;
    }

    /**
     * 列表页面
     */
    public function listView()
    {
        $list = $this->getList();
        $loadListUrl = $this->config->getListUrl();
        $tpl  = require(__DIR__ . '/Resource/list.html');
    }

    /**
     * 复发某请求
     */
    public function resend()
    {
        $info = $this->logData->getArray()[3];

    }
}