<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2019/7/31
 * Time: 17:39
 */

namespace Siam\HttpMonitor;


use EasySwoole\Component\Singleton;

class Monitor
{
    use Singleton;
    
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
        $tem  = array_values($list);
        $tem  = array_reverse($tem);  

        return json_encode($tem, 256);
    }

    /**
     * 列表页面
     */
    public function listView()
    {
        $list = $this->getList();
        $loadListUrl = $this->config->getListUrl();
        $tpl  = file_get_contents(__DIR__ . '/Resource/list.html');
      	$tpl  = str_replace("_LIST_URL_", $loadListUrl, $tpl);
      	return $tpl;
    }

    /**
     * 复发某请求
     */
    public function resend()
    {
        $info = $this->logData->getArray()[3];
		
    }
}