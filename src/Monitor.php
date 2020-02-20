<?php
/**
 * 监控执行门面
 * User: Siam
 * Date: 2019/7/31
 * Time: 17:39
 */

namespace Siam\HttpMonitor;


use EasySwoole\Component\CoroutineRunner\Runner;
use EasySwoole\Component\Singleton;
use EasySwoole\HttpClient\Exception\InvalidUrl;
use Siam\HttpMonitor\Runner\ArrayRunner;

class Monitor
{
    use Singleton;
    
    /**
     * @var RunnerAbstract
     */
    private $runner;
    /** @var Config $config */
    private $config;
    /** @var array 过滤记录的列表 */
    private $filter;

    public function __construct(Config $config, RunnerAbstract $runner = null)
    {
        if ($runner === null){
            $runner = new ArrayRunner($config);
        }
        $this->config = $config;
        $this->runner = $runner;
    }


    /**
     * 添加一条记录
     * @param $data
     * @return bool
     */
    public function log($data)
    {
        if (isset($data['server']['request_uri']) && in_array($data['server']['request_uri'], $this->filter)){
            return false;
        }
        $this->runner->addOne($data);
    }

    /**
     * 添加白名单
     * @param $router
     */
    public function addFilter($router)
    {
        $this->filter[] = $router;
    }

    /**
     * 获取列表
     */
    public function getList()
    {
        $list = $this->runner->getData();
        foreach ($list as $key => $value)
        {
            $list[$key]['id'] = $key;
        }
        $tem  = array_values($list);
        $tem  = array_reverse($tem);

        return json_encode($tem, 256);
    }

    /**
     * 列表页面
     */
    public function listView()
    {
        $loadListUrl = $this->config->getListUrl();
        $resendUrl   = $this->config->getResendUrl();

        $tpl  = file_get_contents(__DIR__ . '/Resource/list.html');
      	$tpl  = str_replace("_LIST_URL_", $loadListUrl, $tpl);
      	$tpl  = str_replace("_RESEND_URL_", $resendUrl, $tpl);
      	return $tpl;
    }

    /**
     * 复发某请求
     * @param $id
     * @return mixed
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    public function resend($id)
    {
        $data = $this->runner->getData()[$id];
        // 复发请求
        $url = 'http://127.0.0.1:'.$data['server']['server_port'].$data['server']['request_uri'];
        $client = new \EasySwoole\HttpClient\HttpClient();

        $client->setUrl($url);

        // header
        $headers = $data['header'] ?? [];
        foreach($headers as $header => $value){
            $client->setHeader($header, $value[0], false);
        }

        // cookie
        $cookies = $data['cookie'] ?? [];
        foreach($cookies as $cookie => $value){
            $client->addCookies([$cookie => $value[0]]);
        }

        switch ($data['server']['request_method']){
            case 'GET':
                $client->setQuery($data['get'] ?? []);
                $res = $client->get();
                break;
            case 'POST':
                $sendData = $data['post'];
                if (!empty($data['rawContent'])){
                    $sendData = $data['rawContent'];
                }
                $res = $client->post($sendData ?? []);
                break;
            default:
                $res = $client->get();
                break;
        }

        return json_encode($res, 256);
    }

}