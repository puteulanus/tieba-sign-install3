<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }

function callback_init() {
	global $m;
	$m->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."wmzz_ban` (
`id`  int(255) NOT NULL AUTO_INCREMENT ,
`uid`  int(255) NOT NULL ,
`pid`  int(255) NOT NULL ,
`tieba`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`user`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`date`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' ,
`nextdo`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=12
CHECKSUM=0
ROW_FORMAT=DYNAMIC
DELAY_KEY_WRITE=0;");
	option::set('plugin_wmzz_ban','a:2:{s:5:"limit";s:2:"10";s:3:"msg";s:63:"由于你违反了吧规，现在已被本吧管理循环封禁";}');
	cron::set('wmzz_ban','plugins/wmzz_ban/wmzz_ban_cron.php',0,0,0);
}

function callback_inactive() {
	cron::del('wmzz_ban');
}

function callback_remove() {
	global $m;
	$m->query("DROP TABLE IF EXISTS `".DB_PREFIX."wmzz_ban`");
	option::del('plugin_wmzz_ban');
}
?>