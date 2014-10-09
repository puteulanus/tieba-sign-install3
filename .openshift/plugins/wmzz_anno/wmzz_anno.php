<?php
/*
Plugin Name: 公告栏插件
Version: 1.0
Plugin URL: http://zhizhe8.net
Description: 在 首页 显示公告栏
Author: 无名智者
Author Email: kenvix@vip.qq.com
Author URL: http://zhizhe8.net
For: V2.0+
*/
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function wmzz_anno_show() {
	global $m;
	$s = option::get('wmzz_anno_set');
	if(!empty($s)) {
		$y = '';
		$x = explode("\n", $s);
		foreach ($x as $value) {
			$y .= $value.'<br/>';
		}
		echo str_replace('{$anno}', $y, option::get('wmzz_anno_tpl'));
	}
}


addAction(option::get('wmzz_anno_doa'),'wmzz_anno_show');
?>