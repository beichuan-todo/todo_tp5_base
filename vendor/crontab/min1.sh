#!/bin/sh
#公共变量
CRONPATH="/var/www/html/tdshop/crontab"

#示例
#path="/var/www/html/seller/cron"
#script="demo.php"
#if [ `ps -ef|grep $script|grep -v grep|grep -v vim|wc -l` -lt 1 ]
#then
#       cd $path
#       nohup php $script >/dev/null 2>&1 &
#       echo "start $script"
#else
#       echo "skip $script"
#fi

#每天的数据统计
script="Demo.php"
if [ `ps -ef|grep $script|grep -v grep|grep -v vim|wc -l` -lt 1 ]
then
       cd $CRONPATH
       nohup php $script >/dev/null 2>&1 &
       echo "start $script"
else
       echo "skip $script"
fi
