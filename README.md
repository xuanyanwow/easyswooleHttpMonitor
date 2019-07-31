# HTTP监控复发工具

在开发接口阶段，可以记录最近的http请求，并且分析参数、复发请求，

特别是在微信支付等异步回调的场景，调试非常舒爽。

作者 Siam 

QQ 59419979

可在easyswoole官方1群、2群(管理员)找到我


# 使用教程

mainServerCreate方法注册
```

use Siam\HttpMonitor\Config as HttpConfig;
use Siam\HttpMonitor\Monitor;


// HTTP监控
$config = new HttpConfig([
    'size'    => 3,
    'listUrl' => 'http://47.101.149.152:9501/siam/http-monitor/get_list',
]);
$monitor = Monitor::getInstance($config);
    
```



添加路由支持
```

use Siam\HttpMonitor\Config;
use Siam\HttpMonitor\Monitor;

$routeCollector->get('/siam/http-monitor', function (Request $request, Response $response) {
    $monitor = Monitor::getInstance();
    $html = $monitor->listView();
    $monitor->log(['time' => time()]);
    $monitor->log(['time' => time()]);
    $response->withHeader('Content-type','text/html;charset=utf-8');
    $response->write("$html");//获取到路由匹配的id
    return false;//不再往下请求,结束此次响应
});

$routeCollector->addRoute(['POST', 'GET'], '/siam/http-monitor/get_list', function (Request $request, Response $response) {
    $response->withHeader('Content-type','text/html;charset=utf-8');
    $response->write(Monitor::getInstance()->getList());//获取到路由匹配的id
    return false;//不再往下请求,结束此次响应
});
```


onRequest拦截
```
$monitor = Monitor::getInstance();
$monitor->log(['time' => time()]);
```