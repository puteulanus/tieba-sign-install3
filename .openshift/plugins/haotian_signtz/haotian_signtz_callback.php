<?php
function callback_init() {
    //global $m;
    //$nowtime=time();
    //$last=$nowtime-($nowtime-1398787200)%86400+10800-86400;
    //$m->query("CREATE TABLE IF NOT EXISTS `".DB_NAME."`.`".DB_PREFIX."tdou_log` ( `uid` int(10) unsigned NOT NULL, `date` varchar(100) NOT NULL DEFAULT '0', `num` int(10) NOT NULL DEFAULT '0', PRIMARY KEY (`uid`), UNIQUE KEY `uid` (`uid`,`date`), KEY `uid_2` (`uid`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	cron::set('signtz_mail', 'plugins/haotian_signtz/send.php', '0', '0', '0');
}

function callback_remove() {
    //global $m;
    //$m->query("DROP TABLE IF EXISTS `".DB_NAME."`.`".DB_PREFIX."tdou_log`");
    cron::del('signtz_mail');
}
?>