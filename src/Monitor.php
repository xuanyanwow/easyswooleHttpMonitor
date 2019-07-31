<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2019/7/31
 * Time: 17:39
 */

namespace Siam\HttpMonitor;


use EasySwoole\Component\Singleton;
use EasySwoole\Spl\SplArray;

class Monitor
{
    use Singleton;

    /**
     * @var LogData
     */
    private $logData;

    public function __construct($size)
    {
        $this->logData = new LogData($size);
        $this->logData->setArray([]);
    }

    function log($data)
    {
        $this->logData->addOne($data);
    }

    function getList()
    {
        $list = $this->logData->getArray();
        return $list;
    }
}