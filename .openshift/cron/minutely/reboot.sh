#!/bin/bash

export TZ="Asia/Shanghai"

# 每天 00:10 00:20 12:00 各重启一次防止计划任务失败
hour="`date +%H%M`"
if [ "$hour" = "0010" -o "$hour" = "0020" -o "$hour" = "1200" ]
then
  echo "Scheduled rebooting at $(date) ..." >&2
  (
  sleep 2
  gear restart --all-cartridges
  echo "Rebooted at $(date) ..." >&2
  ) &
  exit
fi

# 十分钟检查一次网站数据库是否正常
min="`date +%M`"
if [ "${min:1:1}" = "0" ]
then
  if ! curl -s -I -m 30 http://"${OPENSHIFT_APP_DNS}" | head -1 | grep -q '[23]0[0-9]'
  then
    echo "Server not responding, rebooting at $(date) ..." >&2
    (
    sleep 2
    gear restart --all-cartridges
    echo "Rebooted at $(date) ..." >&2
    ) &
    exit
  fi
fi