<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
/*
Plugin Name: 『签到信息统计』
Version: 1.01
Plugin URL: http://t8qd.cn
Description: 签到信息统计
Author: pch18
Author URL: http://t8qd.cn
For: V3.1+
*/



function pch18_indexshow(){

$bencishu=option::get('pch18_tongji_total')*1;
?>
<style type="text/css">
tjtxt{color:DarkCyan ;font-size:16px;}
tjnum{color:DodgerBlue ;font-size:20px;font-weight: bold;}
footxt{color:GoldenRod ;font-size:13px;margin-left:180px}
</style>
<div id="pch18_qdtj"><tjnum><br><font color="Orange ">统计数据加载中...</font><tjnum></div>
<script language="JavaScript" type="text/javascript">

	$.get("plugins/pch18_tongji/pch18_tongji_ajax.php",{'index':''},function(data){
		var xianshi="<tjtxt><br>截至今日云签到已完成<tjnum>"+data['zong']+"</tjnum>次签到<br>为用户获取经验<tjnum>"+data['jinyan']+"</tjnum>点<br>其中本服务器签到<tjnum><?php echo $bencishu; ?></tjnum>次,获取经验<tjnum><?php echo $bencishu*8; ?></tjnum>点</tjtxt><br><footxt>"+data['zdsl'];
	document.getElementById("pch18_qdtj").innerHTML=xianshi;
	//alert(xianshi);
},"json");
</script>

<?php
}
addAction('index_3','pch18_indexshow');