<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function cron_wmzz_zan() {
	require_once SYSTEM_ROOT.'/plugins/Cloud_Click/zan.php';
	$set   = unserialize(option::get('plugin_Cloud_Click'));
	$today = date('Y-m-d');
	global $m;
	//准备：扫描wmzz_zan表中lastdo不是今天的，然后更新wmzz_zan_data表的remain
	$sy = $m->query("SELECT * FROM `".DB_PREFIX."wmzz_zan` WHERE `lastdo` != '{$today}';");
	while ($sx = $m->fetch_array($sy)) {
		$m->query('UPDATE `'.DB_NAME.'`.`'.DB_PREFIX.'wmzz_zan_data` SET `remain` = \''.$sx['num'].'\' WHERE `uid` = '.$sx['uid']);
		$m->query('UPDATE `'.DB_NAME.'`.`'.DB_PREFIX.'wmzz_zan` SET `lastdo` = \''.$today.'\' WHERE `uid` = '.$sx['uid']);
	}
	//开始：计划任务
	$count = $m->once_fetch_array("SELECT COUNT(*) AS `c` FROM `".DB_PREFIX."wmzz_zan_data` WHERE `remain` > '0' LIMIT {$set['rem']};");
	if ($count['c'] == $set['rem']) {
		$y = rand_row(DB_PREFIX.'wmzz_zan_data','id', $set['rem'] ,"`remain` > '0'");
	} else {
		$y = rand_row(DB_PREFIX.'wmzz_zan_data','id', $count['c'] ,"`remain` > '0'");
	}
	//如果只有一条记录的兼容方案
	if (isset($y['tieba'])) {
		$y = array(0 => $y);
	}
	//点赞
	foreach ($y as $x) {
		if (!empty($x['pid'])) {
			$remain = $x['remain'] - $set['num'] ;
			$res    = wmzz_zan_donow( misc::GetCookie($x['pid']) , $x['tieba'] , $set['num']);
			$m->query('UPDATE `'.DB_NAME.'`.`'.DB_PREFIX.'wmzz_zan_data` SET `remain` = \'' . $remain . '\' WHERE `tieba` = \''.$x['tieba'].'\' AND `uid` = '.$x['uid']);
			sleep($set['sleep']);
		}
	}

	/*
	while ($v = $m->fetch_array($x)) {
		$u = $m->once_fetch_array("SELECT * FROM `".DB_NAME."`.`".DB_PREFIX."users` WHERE `id` = '{$v['uid']}' LIMIT 1");
		$variable = unserialize($v['tieba']);
		foreach ($variable as $value) {
			wmzz_zan_get_list($u['ck_bduss'],$value['tieba'],$s['sleep'],$v['max'],$s['sp']);
		}
		$m->query("UPDATE `".DB_NAME."`.`".DB_PREFIX."wmzz_zan` SET  `lastdo` =  '".$today."' WHERE  `id` = ".$v['id']);
	}
	*/
}
?>