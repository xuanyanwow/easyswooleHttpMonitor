<?php
/**
 * 数组缓存驱动
 * User: Siam
 * Date: 2019/7/31
 * Time: 17:56
 */

namespace Siam\HttpMonitor\Runner;

use Siam\HttpMonitor\Config;
use Siam\HttpMonitor\RunnerAbstract;

class ArrayRunner extends RunnerAbstract
{
    protected $config;
    private $data = [];
    private $dataKey = [];


    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function addOne($data)
    {
        $dataKey = time();
        $this->checkSize();

        $this->dataKey[]      = $dataKey;
        $this->data[$dataKey] = $data;
    }

    public function getData($dataKey = null)
    {
        if ($dataKey === null){
            return $this->data;
        }
        if (isset($this->data[$dataKey])){
            return $this->data[$dataKey];
        }
        return null;
    }

    public function checkSize()
    {
        if (count($this->dataKey) >= $this->config->getSize()){
            $dataKey = array_pop($this->dataKey);
            if ($this->data[$dataKey]){
                unset($this->data[$dataKey]);
            }
        }
    }


}