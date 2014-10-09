<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 


function callback_active() {
	msg('您的云签到版本过低，请先升级到最新版本');
}

function callback_init() {

	cron::set('pch18_tongji','plugins/pch18_tongji/pch18_tongji_cron.php',0,0,0);
}

function callback_inactive() {

	cron::del('pch18_relist');
}
?>