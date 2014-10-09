<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
/*
Plugin Name: 邮件群发
Version: 2.0
Plugin URL: http://zhizhe8.net
Description: 群发邮件给所有注册本站的用户
Author: 无名智者
Author Email: kenvix@vip.qq.com
Author URL: http://zhizhe8.net
For: 不限
*/

function wmzz_mailer_navi() {
	echo '<li ';
	if(isset($_GET['plugin']) && $_GET['plugin'] == 'wmzz_mailer') { echo 'class="active"'; }
	echo '><a href="index.php?plugin=wmzz_mailer"><span class="glyphicon glyphicon-envelope"></span> 邮件群发</a></li>';
}

addAction('navi_3','wmzz_mailer_navi');
addAction('navi_9','wmzz_mailer_navi');
?>