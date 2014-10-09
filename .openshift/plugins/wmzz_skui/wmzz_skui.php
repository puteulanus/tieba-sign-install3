<?php
/*
Plugin Name: Skeumorphism UI
Version: 1.0
Plugin URL: http://zhizhe8.net
Description: Bootstrap Skeumorphism UI
Author: 无名智者
Author Email: kenvix@vip.qq.com
Author URL: http://zhizhe8.net
For: V3.1+
*/

if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function wmzz_skui_core() {
	echo '<link rel="stylesheet" href="'.SYSTEM_URL.'plugins/wmzz_skui/core.css">';
}

addAction('header','wmzz_skui_core');