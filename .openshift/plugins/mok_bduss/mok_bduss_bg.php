<?php
require '../../init.php';
global $i,$m;

function getMiddle($text, $left, $right) {
	$loc1 = stripos($text, $left);
	if (is_bool($loc1)) { return ""; }
	$loc1 += strlen($left);
	$loc2 = stripos($text, $right, $loc1);
	if (is_bool($loc2)) { return ""; }
	return substr($text, $loc1, $loc2 - $loc1);
}
function curl_get($url, $header) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
function getId($bduss,$fast){
	$header[] = 'Content-Type:application/x-www-form-urlencoded; charset=UTF-8';
	$header[] = 'Cookie: BDUSS='.$bduss;
	if($fast){
		$data = curl_get("http://tieba.baidu.com/dc/common/tbs",$header);
		$data = getMiddle($data,'"is_login":','}');
		if($data=="1"){ return "有效"; }else{ return ""; }
	} else {
		$data = curl_get("http://wapp.baidu.com/",$header);
		return getMiddle($data,'i?un=','">');
	}
}

if(isset($_GET["do"])){
	switch ($_GET["do"]) {
		case 'tr':
			if(isset($_GET["bduss"]) && isset($_GET["eq"])){
				$ary["id"]=getId($_GET["bduss"],0);
				$ary["eq"]=$_GET["eq"];
				echo json_encode($ary);
			}
			break;
		case 'table':
			if(isset($_GET["uid"]) && isset($_GET["fast"])){
				//做个检测，防止恶意用户获取其他UID的BDUSS
				if($i['user']['role']!="admin"){ $_GET["uid"]=UID; }
				$q=$m->query("Select * from ".DB_PREFIX."baiduid where uid=".$_GET["uid"]);
				while ($row=$q->fetch_row()) {
					$ary[$row[0]]=Array(getId($row[2],$_GET["fast"]),$row[2]);
				}
				if(isset($ary)){ echo json_encode($ary); } else { echo json_encode(Array("Empty"=>"Empty")); }
			}
			break;
		case 'save':
			if(isset($_GET["id"]) && isset($_GET["bduss"])){
				//做个检测，防止恶意用户修改其他ID的BDUSS
				$m->query("Select * From ".DB_PREFIX."baiduid Where uid=".UID." and id=".$_GET["id"]);
				//判断当前用户ID（UID）下是否有将要修改的这个账号ID，如果没有（就是说这id并没有绑定在这个UID下）并且当前用户不是管理员的话
				if($m->affected_rows()==0 && $i['user']['role']!="admin"){
					echo json_encode(Array("status"=>"false","msg"=>"请不要作死，这个账号不属于你"));
					break;
				}
				$id=getId($_GET["bduss"],$_GET["fast"]);
				$ary=Array();
				if($id==""){
					$ary["status"]="false";
					$ary["msg"]="该BDUSS无效！请检查后重新保存";
				} else {
					if($m->query('Update '.DB_PREFIX.'baiduid Set bduss="'.$_GET["bduss"].'" Where id='.$_GET["id"])){
						$ary["status"]="true";
						$ary["id"]=$id;
					} else {
						$ary["status"]="false";
						$ary["msg"]="数据库错误，保存失败";
					}
				}
				echo json_encode($ary);
			}
			break;
		case 'del':
			if (isset($_GET["id"])) {
				//做个检测，防止恶意用户删除其他ID的账号
				$m->query("Select * From ".DB_PREFIX."baiduid Where uid=".UID." and id=".$_GET["id"]);
				//判断当前用户ID（UID）下是否有将要修改的这个账号ID，如果没有（就是说这id并没有绑定在这个UID下）并且当前用户不是管理员的话
				if($m->affected_rows()==0 && $i['user']['role']!="admin"){
					echo json_encode(Array("status"=>"false","msg"=>"请不要作死，这个账号不属于你"));
					break;
				}
				if($m->query('Delete From '.DB_PREFIX.'baiduid Where id='.$_GET["id"]) && 
					$m->query('Delete From '.DB_PREFIX.'tieba Where pid='.$_GET["id"])){
					$ary["status"]="true";
				} else {
					$ary["status"]="false";
					$ary["msg"]="数据库错误，删除失败";
				}
				echo json_encode($ary);
			}
			break;
		case 'delUser':
			if (isset($_GET["uid"])) {
				if($i['user']['role']!="admin"){
					echo json_encode(Array("status"=>"false","msg"=>"请不要作死，这个账号不属于你"));
					break;
				}
				if($m->query('Delete From '.DB_PREFIX.'users Where id='.$_GET["uid"])){
					$ary["status"]="true";
				} else {
					$ary["status"]="false";
					$ary["msg"]="数据库错误，删除失败";
				}
				echo json_encode($ary);
			}
			break;
		case 'fast':
			if(isset($_GET["mode"])){
				
			}
			break;
	}
}
?>