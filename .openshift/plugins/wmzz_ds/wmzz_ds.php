<?php
/*
Plugin Name: 多说/友言 评论
Version: 1.0
Plugin URL: http://zhizhe8.net
Description: 在首页显示 多说/友言 评论系统
Author: 无名智者
Author Email: kenvix@vip.qq.com
Author URL: http://zhizhe8.net
For: V2.0+
*/
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function wmzz_ds_showds() {
	global $m;
	echo '<br/><br/>'.option::get('wmzz_ds_code');
}


addAction('index_2','wmzz_ds_showds');
addAction('login_page_3','wmzz_ds_showds');
?>