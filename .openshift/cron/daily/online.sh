#!/bin/bash

# 获取测速节点
content=`curl -s 'http://api.ccindex.cn/ccindex.api?cmd=4&subcmd=2'`
# 分割节点IP及地区
ip=`echo $content|grep -oP '(?<=\"url\":\")(\d{1,3}\.){3}\d{1,3}'`
ips=($ip)
place=`echo $content|grep -oP '(?<=\"province\":\")[A-Z]+'`
places=($place)
# 开始测速
i=0
for tmp in ${ips[@]}
do
curl -s -m 10 "http://api.ccindex.cn/ccindex.api?cmd=4&subcmd=3&url=https://${OPENSHIFT_APP_DNS}&ip=${ips[i]}&province=${places[i]}"
i=`expr $i + 1`
done