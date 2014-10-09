<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }  
global $i,$m;
$s = unserialize(option::get('plugin_wmzz_ban'));
if (SYSTEM_PAGE == 'add') {
	$pid   = !empty($_POST['pid']) ? intval($_POST['pid']) : msg('请选择PID');
	if (!isset($i['user']['bduss'][$pid])) {
		msg('PID不存在');
	}
	$tieba = !empty($_POST['tieba']) ? addslashes(strip_tags($_POST['tieba'])) : msg('请输入贴吧');
	if (isset($_POST['date'])) {
		if (empty($_POST['date'])) {
			$date = '0';
		} else {
			$date = strtotime($_POST['date']);
		}
	} else {
		msg('请输入截止日期');
	}
	foreach ($_POST['user'] as $value) {
		$value = addslashes(strip_tags($value));
		$m->query("INSERT INTO `".DB_PREFIX."wmzz_ban` (`uid`, `pid`, `tieba`, `user`, `date`) VALUES ('".UID."', '{$pid}', '{$tieba}', '{$value}', '{$date}')");
	}
	ReDirect(SYSTEM_URL . 'index.php?plugin=wmzz_ban&ok');
} elseif (SYSTEM_PAGE == 'del') {
	$id = isset($_GET['id']) ? intval($_GET['id']) : msg('缺少ID');
	$m->query("DELETE FROM `".DB_PREFIX."wmzz_ban` WHERE `uid` = ".UID." AND `id` = ".$id);
	ReDirect(SYSTEM_URL . 'index.php?plugin=wmzz_ban&ok');
} else {
	loadhead();
	require SYSTEM_ROOT.'/plugins/wmzz_ban/show.php';
	loadfoot(); 
} 