<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }

/**
 * 获取封禁类型
 * @param $date 封禁截止日期
 */
function wmzz_ban_getTime($date) {
	return '1';
}

function cron_wmzz_ban() {
	global $m;
	$s = unserialize(option::get('plugin_wmzz_ban'));
	$now   = strtotime(date('Y-m-d'));
	$y = $m->query("SELECT * FROM `".DB_PREFIX."wmzz_ban` WHERE `nextdo` <= '{$now}' LIMIT {$s['limit']}");
	while ($x = $m->fetch_array($y)) {
		$r = wmzz_ban_getTime($x['date']);
		if ($r != '-1') {
			$bduss = misc::getCookie($x['pid']);
			$c = new wcurl('http://tieba.baidu.com/pmc/blockid');
			$c->addcookie('BDUSS='.$bduss);
			$c->post(array(
				'user_name[]' => $x['user'],
				'day' => $r,
				'fid' => misc::getFid($x['tieba']),
				'tbs' => misc::getTbs($x['uid'] , $bduss),
				'ie' => 'utf-8',
				'reason' => $s['msg']
			));
			$next = $now + ( $r * 86400 );
			$m->query("UPDATE `".DB_PREFIX."wmzz_ban` SET `nextdo` = '{$next}' WHERE `id` = '{$x['id']}'");
		} else {
			$m->query("DELETE FROM `".DB_PREFIX."wmzz_ban` WHERE `id` = '{$x['id']}'");
		}
	}
}