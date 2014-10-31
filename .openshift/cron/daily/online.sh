#!/bin/bash

url=${OPENSHIFT_APP_DNS}
# 获取验证字符
content=`curl -sd "url=$url&checkAll=all&dummy=" 'http://host-tracker.com/check_page/'`
num=`echo $content|grep -oP '(?<=dt!=)\d+'`
hh=`echo $content|grep -oP "(?<=dt=$num value=\')[^\']+"`
# 发送测速请求
result=`curl -svd "url=$url&hh=$hh" 'http://host-tracker.com/check_page/' 2>&1 >/dev/null | grep -oP '(?<=Location: )[^\s]+'`