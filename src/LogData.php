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
    /** @var int 最大记录长度 */
    private $maxSize;
    private $data;
    protected $temDir;


    public function __construct()
    {
    }

    public function setSize($size)
    {
        $this->maxSize = $size;
    }


    public function addOne($data)
    {
        $fileName = $this->getTemDir()."/siamHttpMonitor.log";

        if (!is_dir($this->getTemDir())){
            mkdir($this->getTemDir());
        }

        if (!is_file($fileName)){
            file_put_contents($fileName,serialize([]));
        }

        $this->data = unserialize(file_get_contents($fileName));

        if (count($this->data) >= $this->maxSize){
            // 删除最旧的一个
            $del = $this->data['nextDelete'] ?? 0;
            unset($this->data[$del]);
            $this->data['nextDelete'] = $del +1;
        }

        $this->data[] = $data;

        file_put_contents($fileName, serialize($this->data));
    }

    public function getData()
    {
        $this->data = unserialize(file_get_contents($this->getTemDir()."/siamHttpMonitor.log"));

        unset($this->data['nextDelete']);

        return $this->data ?? [];
    }

    /**
     * @return mixed
     */
    public function getTemDir()
    {
        return $this->temDir;
    }

    /**
     * @param mixed $temDir
     */
    public function setTemDir($temDir): void
    {
        $this->temDir = $temDir;
    }



}