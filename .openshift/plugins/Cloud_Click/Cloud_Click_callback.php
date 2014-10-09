<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
function callback_active() {
	msg('您的云签到版本过低，请先升级到最新版本');
}

function callback_init() {
	global $m;
	$m->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."wmzz_zan` (
`id`  int(255) NOT NULL AUTO_INCREMENT ,
`uid`  int(255) NOT NULL ,
`num`  int(255) NULL DEFAULT 0 ,
`lastdo`  date NOT NULL DEFAULT '0000-00-00' ,
PRIMARY KEY (`id`, `uid`),
UNIQUE INDEX `uid` (`uid`) USING BTREE 
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=3
CHECKSUM=0
ROW_FORMAT=DYNAMIC
DELAY_KEY_WRITE=0
;");
	$m->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."wmzz_zan_data` (
`id`  int(255) NOT NULL AUTO_INCREMENT ,
`uid`  int(255) NOT NULL DEFAULT 0 ,
`pid`  int(255) NOT NULL DEFAULT 0 ,
`tieba`  varchar(10000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`remain`  int(255) NOT NULL DEFAULT 0 ,
PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=7
CHECKSUM=0
ROW_FORMAT=DYNAMIC
DELAY_KEY_WRITE=0
;");
	option::set('plugin_Cloud_Click','a:6:{s:3:"num";s:2:"10";s:2:"sp";s:1:"3";s:3:"rem";s:2:"10";s:4:"lmax";s:1:"0";s:4:"cmax";s:1:"0";s:3:"max";s:1:"0";}');
	cron::set('wmzz_zan','plugins/Cloud_Click/run.php',0,0,0);
}

function callback_inactive() {
	cron::del('wmzz_zan');
}

function callback_remove() {
	global $m;
	$m->query("DROP TABLE IF EXISTS `".DB_PREFIX."wmzz_zan`");
	$m->query("DROP TABLE IF EXISTS `".DB_PREFIX."wmzz_zan_data`");
}
?>