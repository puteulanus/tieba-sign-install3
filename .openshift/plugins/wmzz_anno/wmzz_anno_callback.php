<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function callback_init() {
	global $m;

	$data = '';
	$x=$m->once_fetch_array("SELECT COUNT(*) AS ffffff FROM  `".DB_NAME."`.`".DB_PREFIX."options` WHERE  `name` =  'wmzz_anno_set' LIMIT 1");
	if ($x['ffffff'] <= 0) {
		$m->query("INSERT INTO `".DB_NAME."`.`".DB_PREFIX."options` (`id`, `name`, `value`) VALUES (NULL, 'wmzz_anno_set', '{$data}');");
	}

	$data = '<br/><div class="alert alert-info alert-dismissable" style="width:60%;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  {$anno}
</div>';
	$x=$m->once_fetch_array("SELECT COUNT(*) AS ffffff FROM  `".DB_NAME."`.`".DB_PREFIX."options` WHERE  `name` =  'wmzz_anno_tpl' LIMIT 1");
	if ($x['ffffff'] <= 0) {
		$m->query("INSERT INTO `".DB_NAME."`.`".DB_PREFIX."options` (`id`, `name`, `value`) VALUES (NULL, 'wmzz_anno_tpl', '{$data}');");
	}

	$data = 'index_1';
	$x=$m->once_fetch_array("SELECT COUNT(*) AS ffffff FROM  `".DB_NAME."`.`".DB_PREFIX."options` WHERE  `name` =  'wmzz_anno_doa' LIMIT 1");
	if ($x['ffffff'] <= 0) {
		$m->query("INSERT INTO `".DB_NAME."`.`".DB_PREFIX."options` (`id`, `name`, `value`) VALUES (NULL, 'wmzz_anno_doa', '{$data}');");
	}
}

function callback_remove() {
	global $m;
	$x=$m->once_fetch_array("SELECT COUNT(*) AS ffffff FROM  `".DB_NAME."`.`".DB_PREFIX."options` WHERE  `name` =  'wmzz_anno_set' LIMIT 1");
	if ($x['ffffff'] <= 0) {
		$m->query("DELETE FROM `".DB_NAME."`.`".DB_PREFIX."options` WHERE `name` = 'wmzz_anno_set'");
	}

	$x=$m->once_fetch_array("SELECT COUNT(*) AS ffffff FROM  `".DB_NAME."`.`".DB_PREFIX."options` WHERE  `name` =  'wmzz_anno_tpl' LIMIT 1");
	if ($x['ffffff'] <= 0) {
		$m->query("DELETE FROM `".DB_NAME."`.`".DB_PREFIX."options` WHERE `name` = 'wmzz_anno_tpl'");
	}

	$x=$m->once_fetch_array("SELECT COUNT(*) AS ffffff FROM  `".DB_NAME."`.`".DB_PREFIX."options` WHERE  `name` =  'wmzz_anno_doa' LIMIT 1");
	if ($x['ffffff'] <= 0) {
		$m->query("DELETE FROM `".DB_NAME."`.`".DB_PREFIX."options` WHERE `name` = 'wmzz_anno_doa'");
	}
}
?>