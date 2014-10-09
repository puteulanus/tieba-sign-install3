<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }

function cron_wmzz_mailer() {
	global $m;
	$check = option::get('wmzz_mailer_check');
	if ($check == '1') {
		$text  = option::get('wmzz_mailer_text');
		$title = option::get('wmzz_mailer_title');
		$limit = option::get('wmzz_mailer_limit');
		$last  = option::get('wmzz_mailer_last');
		$done  = 0;
		$z = $m->query("SELECT * FROM  `".DB_NAME."`.`".DB_PREFIX."users` LIMIT {$last},{$limit}");
		while ($v = $m->fetch_array($z)) {
			$done++;
			misc::mail($v['email'], $title , $text);
		}
		if ($done - $limit <= -1) {
			option::set('wmzz_mailer_check','0');
			option::set('wmzz_mailer_last','0');
			cron::set('wmzz_mailer','plugins/wmzz_mailer/wmzz_mailer_cron.php',1);
			return '所有邮件群发任务于 '.date('Y-m-d H:m:s').' 完成';
		}
		option::set('wmzz_mailer_last',($done + $last));
	}
}