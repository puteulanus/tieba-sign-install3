<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 


function callback_active() {
	msg('您的云签到版本过低，请先升级到最新版本');
}

function callback_init() {

global $m;

	$m->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pch18_relist` (
  `id` int(10) NOT NULL,
  `lastdate` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

	cron::set('pch18_relist','plugins/pch18_relist/run.php',0,0,0);
}

function callback_inactive() {
	global $m;
	$m->query("DROP TABLE IF EXISTS `".DB_PREFIX."pch18_relist`");
	cron::del('pch18_relist');
}
?>