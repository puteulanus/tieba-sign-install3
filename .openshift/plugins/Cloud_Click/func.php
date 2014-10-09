<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
class cloudclick {
	public static function uset($uid, $max , $tbss , $pid) {
		global $m;
		$rcid = array();
		$rcidk = 0;
		$m->query("INSERT INTO  `".DB_NAME."`.`".DB_PREFIX."wmzz_zan` (`uid`, `num`) VALUES ('{$uid}', '{$max}') on duplicate key update `num` = '{$max}'");
		foreach ($tbss as $key => $tbsx) {
			if (!empty($tbsx) && !empty($pid[$key])) {
				$tes = $m->once_fetch_array("SELECT count(*) AS `c` FROM `".DB_NAME."`.`".DB_PREFIX."wmzz_zan_data` WHERE `uid` = '".UID."' AND `pid` = '{$pid[$key]}' AND `tieba` = '{$tbsx}'");
				if($tes['c'] <= 0) {
					$m->query("INSERT INTO `".DB_NAME."`.`".DB_PREFIX."wmzz_zan_data` ( `id`,`uid`,`pid`,`tieba` ) VALUES ( NULL,'".UID."','{$pid[$key]}','{$tbsx}' );");
				} else {
					$m->query("UPDATE `".DB_NAME."`.`".DB_PREFIX."wmzz_zan_data` SET `tieba` = '{$tbsx}', `pid` = '{$pid[$key]}' WHERE `id` = '{$rcid[$rcidk]}';");
					$rcidk = $rcidk + 1;
				}
			}
		}
	}

	public static function uget($uid, $value) {
		global $m;
		$v = $m->once_fetch_array("SELECT * FROM `".DB_NAME."`.`".DB_PREFIX."wmzz_zan` WHERE `uid` = '{$uid}'");
		return $v[$value];
	}
}
?>