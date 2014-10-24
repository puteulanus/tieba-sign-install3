<?php
/*
Plugin Name: 百度知道、文库签到
Version: 1.0
Plugin URL: http://www.longtings.com
Description: 百度知道、文库签到，个人设置中开启
Author: mokeyjay
Author Email: longting@longtings.com
Author URL: http://www.longtings.com
For: V3.3+
*/

function mok_zdwk_set(){
	echo '<tr><td>附加签到</td><td><input type="checkbox" name="mok_zdwk_wk" ';
	if (option::uget('mok_zdwk_wk')) { echo 'checked'; }
	echo '> 签到百度文库<br/><input type="checkbox" name="mok_zdwk_zd" ';
	if (option::uget('mok_zdwk_zd')) { echo 'checked'; } 
	echo '> 签到百度知道</td></tr>';
}
function mok_zdwk_setting() {
	global $PostArray;
	if (!empty($PostArray)) {
		$PostArray[] = 'mok_zdwk_wk';
		$PostArray[] = 'mok_zdwk_zd';
	}
}

addAction('set_2','mok_zdwk_set');
addAction('set_save1','mok_zdwk_setting');
?>