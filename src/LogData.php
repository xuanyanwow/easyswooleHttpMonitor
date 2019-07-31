<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2019/7/31
 * Time: 17:56
 */

namespace Siam\HttpMonitor;


use EasySwoole\Spl\SplArray;


class LogData
{
    /** @var array */
    protected $array;
    /** @var int 最大记录长度 */
    private $maxSize;

    public function __construct($size = 50)
    {
        $this->maxSize = $size;
    }

    public function getArray()
    {
        return $this->array;
    }

    public function setArray($array): void
    {
        $this->array = $array;
    }

    public function addOne($data)
    {
        // 判断是否已经达到最大记录长度
        $this->checkSize();
        array_push($this->array, $data);
    }

    private function checkSize()
    {
        $count = count($this->array);

        if ($count >= $this->maxSize){
            // 删除最旧的一个 腾出位置
            array_shift($this->array);
        }
    }
}