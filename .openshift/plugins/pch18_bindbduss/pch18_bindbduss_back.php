<?php
require '../../init.php';
global $m;

if (isset($_GET['mod'])){
	switch($_GET['mod']){
		case'havekey':
			echo havekey();exit();
		case'makeurl':
			echo "http://api.t8qd.cn/api/bindbduss/down.php?".makeurl();exit;
		case'upload':
			if(isset($_GET['bduss'])){
			$bainame=getId($_GET['bduss']);
				echo '<div style="word-break:break-all">';
				if ($bainame==""){
				echo "BDUSS验证失败,请用BDUSS<a target='_blank' href='".SYSTEM_URL."index.php?mod=baiduid#newid'>(点击此处)</a>尝试后动绑定<br><br>";
				echo "您的BDUSS为:".$_GET['bduss'];
				}else{
				$intosql=$m->query("insert into ".DB_PREFIX."baiduid set `uid`=".UID.",`bduss`='".$_GET['bduss']."';");
				echo "绑定成功,您的贴吧用户名为:".urldecode(getId($_GET['bduss']))."<br><br>";
				echo "您的BDUSS为:".$_GET['bduss']."<br><br>";
				echo "请返回贴吧列表页面<a target='_blank' href='".SYSTEM_URL."index.php?mod=showtb'>(点击此处)</a>刷新贴吧列表";
				}
			}else{
				echo "未能获取到bduss,提交错误";
			}exit;
	}
}


function makeurl(){
	global $m;
	$userpw_q=$m->query("select `name`,`pw` from ".DB_PREFIX."users where name='".NAME."';");
    $userpw=$userpw_q->fetch_array();
    return "username=".NAME."&userpw=".$userpw[1]."&domain=".SYSTEM_URL;
}
function getId($bduss){
	$header[] = 'Content-Type:application/x-www-form-urlencoded; charset=UTF-8';
	$header[] = 'Cookie: BDUSS='.$bduss;
		$x=new wcurl("http://wapp.baidu.com/",$header);
		$data= $x->exec();
		return getMiddle($data,'i?un=','">');
	}
function getMiddle($text, $left, $right) {
	$loc1 = stripos($text, $left);
	if (is_bool($loc1)) { return ""; }
	$loc1 += strlen($left);
	$loc2 = stripos($text, $right, $loc1);
	if (is_bool($loc2)) { return ""; }
	return substr($text, $loc1, $loc2 - $loc1);
}
	
?>