<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }

function callback_init() {
	option::add('wmzz_mailer_title');
	option::add('wmzz_mailer_text');
	option::set('wmzz_mailer_limit','5');
	option::set('wmzz_mailer_last','0');
	cron::set('wmzz_mailer','plugins/wmzz_mailer/wmzz_mailer_cron.php',0,0,0);
}

function callback_remove() {
	option::del('wmzz_mailer_title');
	option::del('wmzz_mailer_text');
	option::del('wmzz_mailer_limit');
	option::del('wmzz_mailer_last');
}
?>