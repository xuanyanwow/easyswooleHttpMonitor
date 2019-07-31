<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2019/7/31
 * Time: 17:56
 */

namespace Siam\HttpMonitor;

class LogData
{
    /** @var array */
    protected $array;
    /** @var int 最大记录长度 */
    private $maxSize;
    /** @var int 记录现在应该删除的键名 */
    private $nowDelete = 0;

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
        $this->array[] = $data;
    }

    private function checkSize()
    {
        $count = count($this->array);

        if ($count >= $this->maxSize){
            // 删除最旧的一个 腾出位置
            unset($this->array[$this->nowDelete]);
            $this->nowDelete++;
        }
    }
}