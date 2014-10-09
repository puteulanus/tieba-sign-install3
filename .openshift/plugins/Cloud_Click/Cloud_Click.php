<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
/*
Plugin Name: 百度贴吧云点赞
Version: 3.1
Plugin URL: http://www.stus8.com/
Description: 提供高级的贴吧云点赞。特别感谢贴吧会员 @h573980998。支持VIP功能
Author: 无名智者
Author URL: http://zhizhe8.net/
For: V3.1+
*/


function wmzz_zan_userset() {
	?><li <?php if(isset($_GET['plugin']) && $_GET['plugin'] == 'Cloud_Click') { echo 'class="active"'; } ?>><a href="index.php?plugin=Cloud_Click"><span class="glyphicon glyphicon-thumbs-up"></span> 贴吧云点赞</a></li>
	<?php
}

function wmzz_zan_setting() {
	?><li><a href="index.php?mod=admin:setplug&plug=Cloud_Click"><span class="glyphicon glyphicon-thumbs-up"></span> 贴吧云点赞管理</a></li>
	<?php
}

addAction('navi_7','wmzz_zan_userset');
addAction('navi_1','wmzz_zan_userset');
addAction('navi_3','wmzz_zan_setting');
?>