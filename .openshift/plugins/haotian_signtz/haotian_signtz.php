<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
/*
Plugin Name: 签到邮件通知
Version: 1.1
Plugin URL: http://ihaotian.me
Description: 贴吧签到后自动邮件提醒，采用内部接口调用邮件。
Author: Haotian
Author URL: http://ihaotian.me
*/

function haotian_signtz_setting() {
	global $m;
	?>
	<tr><td>开启签到邮件通知</td>
	<td>
	<input type="radio" name="haotian_mail_enable" value="1" <?php if (option::uget('haotian_mail_enable') == 1) { echo 'checked'; } ?> > 是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="haotian_mail_enable" value="0" <?php if (option::uget('haotian_mail_enable') != 1) { echo 'checked'; } ?> > 否
	</td>
	<?php
}

addAction('set_2','haotian_signtz_setting');
?>