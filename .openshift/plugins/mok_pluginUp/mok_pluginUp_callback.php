<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function callback_init() {
	global $m;
	$m->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mok_pluginup` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `pname` text NOT NULL,
  `purl` text NOT NULL,
  `ltime` date DEFAULT NULL,
  PRIMARY KEY (`id`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
CHECKSUM=0
ROW_FORMAT=DYNAMIC
DELAY_KEY_WRITE=0
;");
}

function callback_remove() {
	global $m;
	$m->query("DROP TABLE IF EXISTS `".DB_PREFIX."mok_pluginup`");
}