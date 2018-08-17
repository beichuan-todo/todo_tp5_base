ThinkPHP 5.1 Swoole 扩展
===============

## 安装

首先按照Swoole官网说明安装swoole扩展
然后使用
composer require topthink/think-swoole

## 使用方法

### Server

首先创建控制器类并继承 think\Swoole\Server，然后设置属性和添加回调方法

~~~
<?php
namespace app\index\controller;

use think\swoole\Server;

class Swoole extends Server
{
	protected $host = '127.0.0.1';
	protected $port = 9502;
	protected $option = [ 
		'worker_num'	=> 4,
		'daemonize'	=> true,
		'backlog'	=> 128
	];

	public function onReceive($server, $fd, $from_id, $data)
	{
		$server->send($fd, 'Swoole: '.$data);
	}
}
~~~

支持swoole所有的回调方法定义（回调方法必须是public类型）
serverType 属性定义为 socket/http 则支持swoole的swoole_websocket_server和swoole_http_server

在命令行启动服务端
~~~
php index.php index/Swoole/start
~~~

### HttpServer

命令行下启动服务端
~~~
php think swoole [start|stop|reload|restart]
~~~

swoole的参数可以在应用配置目录下的swoole.php里面配置。

由于onWorkerStart运行的时候没有HTTP_HOST，因此最好在应用配置文件中设置app_host