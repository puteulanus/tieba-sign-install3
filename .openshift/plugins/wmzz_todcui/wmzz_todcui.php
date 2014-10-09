<?php
/*
Plugin Name: 高仿谷歌扁平样式
Version: 1.0
Plugin URL: http://zhizhe8.net
Description: Bootstrap 的高仿谷歌扁平样式
Author: 无名智者
Author Email: kenvix@vip.qq.com
Author URL: http://zhizhe8.net
For: V3.0+
*/

if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function wmzz_todcui_core() {
	echo '<link rel="stylesheet" href="'.SYSTEM_URL.'plugins/wmzz_todcui/css/todc-bootstrap.min.css">';
}

addAction('header','wmzz_todcui_core');