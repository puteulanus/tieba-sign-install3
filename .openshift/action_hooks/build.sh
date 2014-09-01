#!/bin/sh
# 下载签到助手
cd ${OPENSHIFT_REPO_DIR}
curl -s http://git.oschina.net/kenvix/Tieba-Cloud-Sign/repository/archive?ref=master > Tieba-sign.zip
# 展开
unzip Tieba-sign.zip
cp Tieba-Cloud-Sign/* ./
rm -rf Tieba-sign.zip