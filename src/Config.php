<?php

namespace Siam\HttpMonitor;

use \EasySwoole\Spl\SplBean;

class Config extends SplBean
{
    protected $size;
    protected $listUrl;
    protected $temDir;
    protected $resendUrl;

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getListUrl()
    {
        return $this->listUrl;
    }

    public function setistUrl($listUrl)
    {
        $this->listUrl = $listUrl;
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

    /**
     * @param mixed $resendUrl
     */
    public function setResendUrl($resendUrl): void
    {
        $this->resendUrl = $resendUrl;
    }


    public function getResendUrl()
    {
        return $this->resendUrl;
    }

}
