<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function cron_pch18_relist() {
	global $m;

	$query = $m->query("SELECT DISTINCT id,uid FROM `".DB_PREFIX."baiduid` ");
	while ($fetch = $m->fetch_array($query)) {
		$id = $fetch['id'];
		$uid = $fetch['uid'];
		$isqd_query = $m->query("SELECT * FROM `".DB_PREFIX."pch18_relist` where id=".$id." and lastdate='".date("Y-m-d")."'");
		$isqd_fetch = $m->fetch_array($isqd_query);

		if (!$isqd_fetch){										//确认当天没有签到过
			$setqd_query = $m->query("SELECT id,options FROM `".DB_PREFIX."users` where id=".$uid);
			$setqd_fetch = $m->fetch_array($setqd_query);
			$setqd=$setqd_fetch['options'];
		
			
		if (substr(strstr($setqd,"pch18_relist_enable"),26,1)==1){			//user表里面开启签到功能
			$r = misc::scanTiebaByPid($id);//更新列表函数
			$m->query("REPLACE INTO `".DB_NAME."`.`".DB_PREFIX."pch18_relist` SET `lastdate` = '".date("Y-m-d")."', id = ".$id);
		
		}
		}
	}
}
?>