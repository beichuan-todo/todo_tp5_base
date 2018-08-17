TDshop
===============

TDshop 1.0

 + 采用容器统一管理对象
 + 支持Facade
 + 注解路由支持
 + 路由跨域请求支持
 + 配置和路由目录独立
 + 取消系统常量
 + 助手函数增强
 + 类库别名机制
 + 增加条件查询
 + 改进查询机制
 + 配置采用二级
 + 依赖注入完善
 + 中间件支持（V5.1.6+）


> TDshop的运行环境要求PHP7.1以上。


## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─application 应用目录
│ ├─common 逻辑层
│ │ ├─controller 逻辑处理控制器
│ │ └─model 模型目录
│ │
│ ├─module_name 模块目录
│ │ ├─common.php 模块函数文件
│ │ ├─controller 控制器目录，控制器以功能划分
│ │ ├─view 视图目录
│ │ └─ ... 更多类库目录
│ │
│ ├─command.php 命令行定义文件
│ ├─common.php 公共函数文件
│ └─tags.php 应用行为扩展定义文件
│
├─config 应用配置目录
│ ├─module_name 模块配置目录
│ │ ├─database.php 数据库配置
│ │ ├─cache 缓存配置
│ │ └─ ...
│ │
│ ├─app.php 应用配置
│ ├─cache.php 缓存配置
│ ├─cookie.php Cookie配置
│ ├─database.php 数据库配置
│ ├─log.php 日志配置
│ ├─session.php Session配置
│ ├─template.php 模板引擎配置
│ └─trace.php Trace配置
│
├─crontab 定时任务目录
│ ├─Demo.php 定时任务类
│ ├─min1.sh 每分钟启动一次脚本的入口
│ └─... 更多
│
├─route 路由定义目录
│ ├─route.php 路由定义
│ └─... 更多
│
├─public WEB目录（对外访问目录）
│ ├─uploads 图片上传目录
│ │ ├─20180612 以时间作为子目录命名规则
│ │ └─20180613 ……
│ ├─static 静态文件如js，css
│ │ └─module_name	按模块划分
│ ├─index.php 入口文件
│ ├─router.php 快速测试文件
│ └─.htaccess 用于apache的重写
│
├─thinkphp 框架系统目录
│ ├─lang 语言文件目录
│ ├─library 框架类库目录
│ │ ├─think Think类库包目录
│ │ └─traits 系统Trait目录
│ │
│ ├─tpl 系统模板目录
│ ├─base.php 基础定义文件
│ ├─convention.php 框架惯例配置文件
│ ├─helper.php 助手函数文件
│ └─logo.png 框架LOGO文件
│
├─extend 扩展类库目录
├─runtime 应用的运行时目录（可写，可定制）
├─vendor 第三方类库目录（Composer依赖库）
├─composer.json composer 定义文件
├─README.md README 文件
├─think 命令行入口文件
~~~

> router.php用于php自带webserver支持，可用于快速测试
> 切换到public目录后，启动命令：php -S localhost:8888  router.php
> 上面的目录结构和名称是可以改变的，这取决于你的入口文件和配置参数。

## 版权信息

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2018 by 投道 (http://thinkphp.cn)

All rights reserved。

