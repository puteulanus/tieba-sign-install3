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

function get($url){
	$page = file_get_contents($url);
	$ver = getMiddle(getMiddle($page,"<th>最新版本:","</tr>"),"<td>"," </td>");
	$name = getMiddle(getMiddle($page,"<th>插件名称:","</tr>"),"<td>"," </td>");
	$describe = getMiddle(getMiddle($page,"<th>插件描述:","</tr>"),"<td>"," </td>");
	$author = getMiddle(getMiddle($page,"<th>作者:","</tr>"),"<td>"," </td>");
	$system_ver = getMiddle(getMiddle($page,"<th>云签到最低版本要求:","</tr>"),"<td>"," </td>");
	preg_match('/(\d+)\.(\d+)/is', $ver, $ver_arr);//取其中的小数，排除掉V之类的字母
	preg_match('/(\d+)\.(\d+)/is', $system_ver, $system_ver_arr);
	$describe=str_replace("<br />","",$describe);//去除插件描述中多余的<br>
	$describe=$describe==""?$author."很懒，没有写插件描述":$describe;
	if(count($system_ver_arr)<=0){ $system_ver="-"; }else{ $system_ver=$system_ver_arr[0]; }
	if(count($ver_arr)<=0){
		echo json_encode(Array("name"=>"","ver"=>"","describe"=>"","system_ver"=>""));
	} else {
		echo json_encode(Array("name"=>$name,"ver"=>$ver_arr[0],"describe"=>$describe,"system_ver"=>$system_ver));
	}
	return;
}

if(isset($_GET["do"]) && isset($_GET["url"])){
	if($_GET["do"]=="get"){
		//获取插件信息
		if(isset($_GET["mok_plugin"])){//如果传了插件名过来就说明是检查更新
			$m->query('Update '.DB_PREFIX.'mok_pluginup Set ltime="'.date("Y-m-d").'" Where pname="'.$_GET["mok_plugin"].'"');
		}
		get($_GET["url"]);
	} else if($_GET["do"]=="save"){
		//保存
		$plugin=$_GET["mok_plugin"];
		$url=$_GET["url"];
		$m->query('Select id From '.DB_PREFIX.'mok_pluginup Where pname="'.$plugin.'"');
		if($m->affected_rows()){
			if ($m->query('Update '.DB_PREFIX.'mok_pluginup Set purl="'.$url.'" Where pname="'.$plugin.'"') === TRUE) {
				echo json_encode(Array("status"=>"true"));
			} else { echo json_encode(Array("status"=>"false")); }
		} else {
			if ($m->query('Insert Into '.DB_PREFIX."mok_pluginup (pname,purl,ltime) Values ('{$plugin}','{$url}','')") === TRUE) {
				echo json_encode(Array("status"=>"true"));
			} else { echo json_encode(Array("status"=>"false")); }
		}
	}
}
?>