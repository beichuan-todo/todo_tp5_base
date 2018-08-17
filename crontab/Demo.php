<?php
/**
 * 每日更新价格
 */
namespace crontab;

//引入框架
date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/../thinkphp/base.php';
\think\Container::get('app')->path(__DIR__ . '/../application/')->initialize();

//基础设置
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('memory_limit', '512M');

use think\facade\Cache;

class Demo
{
    public function main()
    {
        if (date('H')>1) {
            exit;
        }
        Cache::set('demo', 'this is a demo', 3600);
        echo Cache::get('demo');
        return ;
    }
}

$obj = new Demo();
$obj->main();