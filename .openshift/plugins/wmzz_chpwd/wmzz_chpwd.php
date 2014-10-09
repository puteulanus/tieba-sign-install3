<?php
/*
Plugin Name: 密码更改插件
Version: 1.1
Plugin URL: http://zhizhe8.net
Description: 允许用户更改自己的密码
Author: 无名智者
Author Email: kenvix@vip.qq.com
Author URL: http://zhizhe8.net
For: 不限
*/
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function wmzz_chpwd_navi() {
	global $m;
	echo '<tr><td>更改密码<br/>留空表示不更改密码</td><td><input type="password" class="form-control" name="wmzz_chpwd_newpw"></td>';
}

function wmzz_chpwd_setting() {
	if (!empty($_POST['wmzz_chpwd_newpw'])) {
		$newpw = addslashes($_POST['wmzz_chpwd_newpw']);
		global $m;
		$m->query("UPDATE `".DB_NAME."`.`".DB_PREFIX."users` SET `pw` = '".EncodePwd($newpw)."' WHERE id = ".UID);
		msg('更改密码成功，请重新登录',SYSTEM_URL);
	}
}

addAction('set_2','wmzz_chpwd_navi');
addAction('set_save1','wmzz_chpwd_setting');
?>