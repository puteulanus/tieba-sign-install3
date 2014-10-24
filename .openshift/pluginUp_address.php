<?php
define('SYSTEM_ROOT',dirname(__FILE__).'./');
include('config.php');

// 连接数据库
$lk = mysql_connect(getenv('OPENSHIFT_MYSQL_DB_HOST').':'.getenv('OPENSHIFT_MYSQL_DB_PORT'),getenv('OPENSHIFT_MYSQL_DB_USERNAME'),getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
if (!$lk){
	die('Could not connect: ' . mysql_error());
}

// 加入插件更新地址
mysql_select_db(getenv('OPENSHIFT_APP_NAME'), $lk);
mysql_query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mok_pluginup` ( `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT, `pname` text NOT NULL, `purl` text NOT NULL, `ltime` date DEFAULT NULL, PRIMARY KEY (`id`))ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=DYNAMIC DELAY_KEY_WRITE=0;");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('Cloud_Click','http://www.stus8.com/forum.php?mod=viewthread&tid=2150','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('haotian_signtz','http://www.stus8.com/forum.php?mod=viewthread&tid=2723','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('mok_bduss','http://www.stus8.com/forum.php?mod=viewthread&tid=2778','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('mok_pluginUp','http://www.stus8.com/forum.php?mod=viewthread&tid=3186','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('pch18_bindbduss','http://www.stus8.com/forum.php?mod=viewthread&tid=3276','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('pch18_relist','http://www.stus8.com/forum.php?mod=viewthread&tid=3158','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('pch18_tongji','http://www.stus8.com/forum.php?mod=viewthread&tid=3242','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_anno','http://www.stus8.com/forum.php?mod=viewthread&tid=2189','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_ban','http://www.stus8.com/forum.php?mod=viewthread&tid=2953','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_chpwd','http://www.stus8.com/forum.php?mod=viewthread&tid=2142','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_debug','http://www.stus8.com/forum.php?mod=viewthread&tid=2140','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_ds','http://www.stus8.com/forum.php?mod=viewthread&tid=2179','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_flatui','http://www.stus8.com/forum.php?mod=viewthread&tid=3391','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_gz','http://www.stus8.com/forum.php?mod=viewthread&tid=2144','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_mailer','http://www.stus8.com/forum.php?mod=viewthread&tid=2352','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_post','http://www.stus8.com/forum.php?mod=viewthread&tid=2499','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_skui','http://www.stus8.com/forum.php?mod=viewthread&tid=2735','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('wmzz_todcui','http://www.stus8.com/forum.php?mod=viewthread&tid=2932','')");
mysql_query('INSERT INTO '.DB_PREFIX."mok_pluginup (pname,purl,ltime) VALUES ('mok_zdwk','http://www.stus8.com/forum.php?mod=viewthread&tid=4139','')");

// 修改应用地址为https
mysql_query("UPDATE ".DB_PREFIX."options SET value = 'https://".getenv('OPENSHIFT_APP_DNS')."/' WHERE name = 'system_url'");

// 关闭连接
mysql_close($lk);
