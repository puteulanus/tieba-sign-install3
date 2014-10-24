<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function callback_active() {}

function callback_init() {
	cron::set('mok_zdwk','plugins/mok_zdwk/mok_zdwk_cron.php',0,0,0);
}

function callback_inactive() {
	cron::del('mok_zdwk');
}

function callback_remove() {}