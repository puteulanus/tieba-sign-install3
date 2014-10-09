<?php
/*
Plugin Name: 循环封禁
Version: 1.5
Plugin URL: http://zhizhe8.net
Description: 可以对指定用户进行循环封禁的插件，支持永久封禁和限时封禁
Author: 无名智者
Author Email: kenvix@vip.qq.com
Author URL: http://zhizhe8.net
For: V3.1+
*/
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function wmzz_ban_addaction_navi() {
	?>
	<li <?php if(isset($_GET['plugin']) && $_GET['plugin'] == 'wmzz_ban') { echo 'class="active"'; } ?>><a href="index.php?plugin=wmzz_ban"><span class="glyphicon glyphicon-ban-circle"></span> 循环封禁</a></li>
	<?php
}

function wmzz_ban_setting_navi() {
	?>
	<li><a href="index.php?mod=admin:setplug&plug=wmzz_ban"><span class="glyphicon glyphicon-ban-circle"></span> 循环封禁管理</a></li>
	<?php
}

addAction('navi_1','wmzz_ban_addaction_navi');
addAction('navi_7','wmzz_ban_addaction_navi');
addAction('navi_3','wmzz_ban_setting_navi');