<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
/*
Plugin Name: 自动刷新贴吧列表V2.01『统计信息栏→后台管理』
Version: 2.01
Plugin URL: http://t8qd.cn
Description: 管理员可手动为成员刷新列表
Author: pch18
Author URL: http://t8qd.cn
For: V3.0+
*/

function pch18_relist_setting() {

	?>
	<tr><td><font color="red">开启自动每天刷新贴吧列表</font></td>
	<td>
	<input type="radio" name="pch18_relist_enable" value="1" <?php if (option::uget('pch18_relist_enable') == 1) { echo 'checked'; } ?> > 开启&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="pch18_relist_enable" value="0" <?php if (option::uget('pch18_relist_enable') != 1) { echo 'checked'; } ?> > 关闭
	</td> 
    
	<?php
}

function pch18_relist_admin() {

global $i;
	
	if ($i['mode'][2]!='relist'){
	?> <li><a href="index.php?mod=admin:stat:relist">贴吧列表刷新</a></li><?php
		return;
	}
	
		global $m;

//=====================================以下刷新贴吧代码=========================
if (isset($_GET['ref'])) {

switch ($_GET['ref']){
case 'all':
		$query = $m->query("SELECT DISTINCT id,uid FROM `".DB_PREFIX."baiduid` ");
		while ($fetch = $m->fetch_array($query)) {
			$id = $fetch['id'];
			$uid = $fetch['uid'];
			$setqd_fetch = $m->once_fetch_array("SELECT id,options FROM `".DB_PREFIX."users` where id=".$uid);//本条测试成功的话run里面同样修改
			$setqd=$setqd_fetch['options'];
			if ((substr(strstr($setqd,"pch18_relist_enable"),26,1)==1)||(isset($_GET['nojump']))){			//user表里面开启签到功能
				$r = misc::scanTiebaByPid($id);//更新列表函数
				$m->query("REPLACE INTO `".DB_NAME."`.`".DB_PREFIX."pch18_relist` SET `lastdate` = '".date("Y-m-d")."', id = ".$id);
			}
		}
		Redirect(SYSTEM_URL.'index.php?mod=admin:stat:relist&isok=已刷新完所有用户贴吧列表');

case 'kong':
	//刷新空账户
			$baid_ft = $m->query("SELECT id,uid FROM `".DB_PREFIX."baiduid`");
		while ($baid = $m->fetch_array($baid_ft)) {
			$uxs = $m->once_fetch_array("SELECT * FROM `".DB_PREFIX."users` where id=".$baid['uid']);
			if ($uxs['t']=='') continue;
			$uxsm = $m->once_fetch_array("SELECT COUNT(*) AS `c` FROM `".DB_PREFIX.$uxs['t']."` WHERE `pid` = ".$baid['id']);
			if ($uxsm['c']==0){
			$r = misc::scanTiebaByPid($baid['id']);//更新列表函数
			$m->query("REPLACE INTO `".DB_NAME."`.`".DB_PREFIX."pch18_relist` SET `lastdate` = '".date("Y-m-d")."', id = ".$baid['id']);
			}
		}
	Redirect(SYSTEM_URL.'index.php?mod=admin:stat:relist&isok=已刷新完所有空账户');//页面跳转
default:
		if ($_GET['ref']>0){
		$r = misc::scanTiebaByPid($_GET['ref']);
		$m->query("REPLACE INTO `".DB_NAME."`.`".DB_PREFIX."pch18_relist` SET `lastdate` = '".date("Y-m-d")."', id = ".$_GET['ref']);
		Redirect(SYSTEM_URL.'index.php?mod=admin:stat:relist&isok=已刷新完'.$_GET['ref'].'号用户贴吧列表');
		}
}
}

//=====================================以上刷新贴吧代码=========================	


//---------------------------------下面是页面------------------------------------
?>
<li class="active"><a href="index.php?mod=admin:stat:relist">贴吧列表刷新</a></li>
</ul>
<h3>自动刷新贴吧列表插件V2.01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://home.t8qd.cn" target="_blank">作者:Pch18</a></h3>

<table class="table table-striped">
	<thead>
		<th>百度ID</th>
		<th>用户名</th>
		<th>贴吧总数</th>
		<th>开启每天刷新</th>
		<th>上次刷新时间</th>
		<th>操作</th>
	</thead>
	<tbody>
<?php 
		$baid_ft = $m->query("SELECT id,uid FROM `".DB_PREFIX."baiduid`");
		$num=0;
		while ($baid = $m->fetch_array($baid_ft)) {
			$uxs = $m->once_fetch_array("SELECT * FROM `".DB_PREFIX."users` where id=".$baid['uid']);
            if ($uxs['t']=='') continue;
			$uxsm = $m->once_fetch_array("SELECT COUNT(*) AS `c` FROM `".DB_PREFIX.$uxs['t']."` WHERE `pid` = ".$baid['id']);
			//显示id+用户名
			echo '<tr><td>'.$baid['id'].'</td><td>'.$uxs['name'].'</td>';
			//贴吧数量
			if ($uxsm['c']==0)
			$uxsm['c']='<font color="red"><B>'.$uxsm['c'].'    空账户</B></font>';
			echo '<td>'.$uxsm['c'].'</td>';
			//显示是否开启自动签到
			$setqd_fetch = $m->once_fetch_array("SELECT id,options FROM `".DB_PREFIX."users` where id=".$baid['uid']);//本条测试成功的话run里面同样修改
			$setqd=$setqd_fetch['options'];
			if (substr(strstr($setqd,"pch18_relist_enable"),26,1)==1){
			echo '<td><font color="Green"><b>开启</b></font></td>';
			}else{
			echo '<td><font color="Darkorange"><b>关闭</b></font></td>';
			}
			//上次刷新时间
			$lastdate = $m->once_fetch_array("SELECT * FROM `".DB_PREFIX."pch18_relist` where id=".$baid['id']);
			if ($lastdate['lastdate']==date("Y-m-d"))
				$lastdate['lastdate']='<font color="DarkTurquoise">今日</font>';
			if ($lastdate['lastdate']=='')
				$lastdate['lastdate']='<font color="black"></b>无记录<b></font>';
			echo '<td><font color="DeepPink"><b>'.$lastdate['lastdate'].'</b></font></td>';
			//操作
			echo '<td><a href="index.php?mod=admin:stat:relist&ref='.$baid['id'].'" onclick="$(\'#tb_num\').html(\'正在刷该用户贴吧列表，可能需要较长时间，请耐心等待...\')">刷新贴吧列表</a></td>';
		$num++;
		}
		
			if (isset($_GET['isok'])) {
				echo '<div class="alert alert-info" id="tb_num">'.$_GET['isok'].'<br/>功能：';
			}else{
				echo '<div class="alert alert-info" id="tb_num">当前已列出 '.$num.' 个百度ID账户，百度ID 即为 百度账号在本服务器的编号<br/>功能：';
			}
			echo '<a href="index.php?mod=admin:stat:relist&ref=all&nojump" onclick="$(\'#tb_num\').html(\'正在刷新 所有用户 贴吧列表，可能需要较长时间，请耐心等待...\')"><font color="SlateBlue ">刷新所有用户</font></a>';
			echo ' | <a href="index.php?mod=admin:stat:relist&ref=all" onclick="$(\'#tb_num\').html(\'正在刷新 所有刷新所有(跳过没开自动刷新)用户 贴吧列表，可能需要较长时间，请耐心等待...\')"><font color="Fuchsia">刷新所有(跳过没开自动刷新)用户</font></a>';
			echo ' | <a href="index.php?mod=admin:stat:relist&ref=kong" onclick="$(\'#tb_num\').html(\'正在刷新 所有空账户 贴吧列表，可能需要较长时间，请耐心等待...\')"><font color="red">刷新所有空账户</font></a>';
			echo '</div>';
?>
	</tbody>
</table>

<?php
		
}
		



function pch18_relist_redate() {
global $m,$i;
if (isset($_GET['ref'])){

	$uidtoid = $m->query("SELECT id,uid FROM `".DB_PREFIX."baiduid` where uid=".UID);
	while ($iid = $m->fetch_array($uidtoid)) {
		$m->query("REPLACE INTO `".DB_NAME."`.`".DB_PREFIX."pch18_relist` SET `lastdate` = '".date("Y-m-d")."', id = ".$iid['id']);
	}
}
}

function pch18_relist_updata() {
    if (ROLE=="admin"){
    $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,'http://t8qd.cn/PluginUp.php?Pname=pch18_relist&Pver=2.02&http='.SYSTEM_URL);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $content=curl_exec($ch);
    if(curl_errno($ch)); //echo curl_error($ch);
    else echo $content;
    curl_close($ch);
    }
}
addAction('index_3','pch18_relist_updata');
addAction('showtb_set','pch18_relist_redate');
addAction('set_2','pch18_relist_setting');
addAction('stat_navi','pch18_relist_admin');

?>