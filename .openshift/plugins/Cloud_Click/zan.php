<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function wmzz_zan_getpage($kw , $bduss){
	$pda  = array(
			'BDUSS'            => $bduss,
			'_client_id'       => 'wappc_1396611108603_817',
			'_client_type'     => '2',
			'_client_version'  => '5.7.0',
			'_phone_imei'      => '642b43b58d21b7a5814e1fd41b08e2a6',
			'from'             => 'tieba',
			'kw'               => $kw,
            'pn'               => '1',
            'q_type'           => '2',
            'rn'               => '50',
            'with_group'       => '1'
	);
	$ex = '';
	foreach($pda as $k => $v) {
		$ex .= $k.'='.$v;
	}
	$pda['sign'] = md5($ex . 'tiebaclient!!!'); //!!
	//CURL POST
	$x    = new wcurl('http://c.tieba.baidu.com/c/f/frs/page' , array("Content-Type: application/x-www-form-urlencoded") );
	$x->addcookie('BDUSS='.$bduss);
	$x->set(CURLOPT_TIMEOUT , 1);
	$r    = $x->post($pda);
	$x->close();
	return json_decode($r , true);
}

function wmzz_zan_do($kw , $pid , $tid , $b){
	$pda    = array(
		'BDUSS'            => $b,
		'_client_id'       => 'wappc_1396611108603_817',
		'_client_type'     => '2',
		'_client_version'  => '5.7.0',
		'_phone_imei'      => '642b43b58d21b7a5814e1fd41b08e2a6',
		'action'           => 'like',
		'from'             => 'tieba',
		'kw'               => $kw,
		'post_id'          => $pid,
		'thread_id'        => $tid
	);
	$ex = '';
	foreach($pda as $k => $v) {
		$ex .= $k.'='.$v;
	}
	$pda['sign'] = md5($ex . 'tiebaclient!!!'); //!!

	$x = new wcurl('http://c.tieba.baidu.com/c/c/zan/like' , array('Content-Type: application/x-www-form-urlencoded'));
	$x->addcookie('BDUSS='.$b);
	$x->set(CURLOPT_TIMEOUT , 1);
	return $x->post($pda);
	//$x->close();
}

function wmzz_zan_donow($bduss , $kw , $num = '1'){
	//get client page [array]
	$re    = wmzz_zan_getpage($kw , $bduss);
	$re    = $re['thread_list'];
	$done  = 0;
	foreach ($re as $v) {
		if($v['zan']['is_liked'] != '1') {
			wmzz_zan_do($kw , $v['first_post_id'] , $v['id'] , $bduss);
			$done = ( $done + 1 );
			if ($done >= $num) {
				break;
			}
		}
	}
}
?>