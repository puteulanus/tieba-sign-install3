<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function cron_mok_zdwk() {
	global $m;
	$prefix = DB_PREFIX;
	//选出用户的options和bduss
	$res = $m->query("SELECT {$prefix}users.`options`,{$prefix}baiduid.`bduss` FROM {$prefix}baiduid INNER JOIN {$prefix}users ON {$prefix}users.id={$prefix}baiduid.uid");

	$wk = $zd = 0;
	while($row = $res->fetch_array()){
		$opt = unserialize($row["options"]);
		if($opt["mok_zdwk_wk"]){
			$wk++;
			$c = new wcurl('http://wenku.baidu.com/');
			$c->set(CURLOPT_TIMEOUT, 1);
			$c->addCookie('BDUSS='.$row["bduss"]);
			$c->exec();
			$c->close();
		}
		if($opt["mok_zdwk_zd"]){
			$zd++;
			$c = new wcurl('http://zhidao.baidu.com/');
			$c->addCookie('BDUSS='.$row["bduss"]);
			$stoken = $c->get();
			$c->close();
			$stoken = textMiddle($stoken,'"stoken":"','",');
			if($stoken!=""){
				$c = new wcurl('http://zhidao.baidu.com/submit/user');
				$c->addCookie('BDUSS='.$row["bduss"]);
				$c->post(array(
					'cm' => '100509',
					'utdata' => '90,90,102,96,107,101,99,97,96,90,98,103,103,99,127,106,99,99,14138554765830',
					'stoken' => $stoken
				));
				$c->close();
			}
		}
	}
	return "知道、文库签到完毕<br/>".date("Y-m-d H:i:s")."<br/>共计百度账号: ".$res->num_rows." 个<br/>知道签到: {$zd} 个<br/>文库签到: {$wk} 个";
}