<script type="text/javascript">
	function save(plugin){
		var url=encodeURI($("#"+plugin+"_input").val());
		if(url==""){ alert("请填写插件发布地址！"); return; }
		$("#"+plugin+"_save").attr("disabled","true").text("正在获取插件信息...");
		//confirm("你确信要转去风亦飞的博客？")
		$.get("plugins/mok_pluginUp/apis.php",{"do":"get","url":url},function(data){
			if(data["ver"]==""){
				alert("没有检测到插件信息，请检查插件发布地址是否输入正确！");
				$("#"+plugin+"_save").removeAttr("disabled").text("保存");
			} else {
				if(confirm("插件名称: "+data["name"]+"\r最新版本: "+data["ver"]+"\r\r是否正确？")){
					$("#"+plugin+"_save").text("正在保存...");
					$.get("plugins/mok_pluginUp/apis.php",{"do":"save","mok_plugin":plugin,"url":url},function(data){
						if(data["status"]=="true"){
							$("#"+plugin+"_save").text("成功");
						} else {
							alert("未知错误，保存失败！");
							$("#"+plugin+"_save").removeAttr("disabled").text("保存");
						}
					},"json");
				} else {
					$("#"+plugin+"_save").removeAttr("disabled").text("保存");
				}
			}
		},"json");
		
	}

	function check(plugin,ver){
		var url=encodeURI($("#"+plugin+"_input").val());
		if(url==""){ alert("请填写插件发布地址！"); return; }
		$("#"+plugin+"_check").attr("disabled","true").text("正在检查");
		$.get("plugins/mok_pluginUp/apis.php",{"do":"get","url":url,"mok_plugin":plugin},function(data){
			if(data["ver"]==""){
				alert("没有检测到插件信息，请检查插件发布地址是否输入正确！");
				$("#"+plugin+"_check").removeAttr("disabled").text("检查更新");
			} else {
				if(data["ver"]==ver){
					$("#"+plugin+"_check").text("已是最新");
				} else {
					$("#"+plugin+"_check").removeAttr("disabled").text("发现新版");
					var alertText="<div class='alert alert-info' role='alert'>发现【"+data["name"]+"】的新版本</div>";
					if(<?php echo SYSTEM_VER; ?><data["system_ver"]){
						alertText+="<div class='alert alert-danger' role='alert'>检测到你的签到系统版本过低（v"+<?php echo SYSTEM_VER; ?>+"），可能无法兼容该插件（最低要求v"+data["system_ver"]+"）。请升级你的签到系统 -> <a href='http://www.stus8.com/forum.php?mod=viewthread&tid=2141' target='_blank'>立即升级</a></div>";
					}
					alertText+="<div class='alert alert-warning' role='alert'>最新版本："+data["ver"]+"</div>";
					alertText+="<div class='alert alert-danger' role='alert'>"+data["describe"]+"</div>";
					alertText+='<a class="btn btn-success" href="'+$("#"+plugin+"_input").val()+'" target="_blank">立即更新</a>';
					alert(alertText);
				}
			}
		},"json");
	}

	function checkAll(){
		alert("快醒醒，别作死(=ﾟДﾟ=)<br/>因为<a href='http://zhizhe8.net' target='_blank'>无名智者</a>没有开发接口的原因<br/>目前都是通过读取网页来检查新版本，<span style='color:#f00'>效率极其低下</span><br/>为了照顾你那悲催的网速以及无名君的服务器╮(╯_╰)╭<br/><span style='color:#f00'>【该功能暂不开放】</span><br/>表打我━(ﾟ∀ﾟ)━!");
	}
</script>
<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } if (ROLE != 'admin') { msg('权限不足！'); }
loadhead();
if (isset($_GET['ok'])) {
	echo '<div class="alert alert-success">插件操作成功</div>';
}
$x=getPlugins();
$plugins = '';
$stat=0;
//获取数据库内的插件url以及上次更新间隔时间
global $m;
$q=$m->query("Select * From ".DB_PREFIX."mok_pluginup");
while ($row=$q->fetch_row()) {
	$ary["url"]=$row[2];
	if($row[3]!="0000-00-00"){
		$d1=strtotime(date("Y-m-d"));
		$d2=strtotime($row[3]);
		$day=round(($d1-$d2)/3600/24);
		if($day==0){ $ary["day"]="今天"; }else{ $ary["day"]=$day." 天前"; }
		
	} else {
		$ary["day"]="从未检查";
	}
	$db[$row[1]]=$ary;
}

foreach($x as $key=>$val) {
	$stat++;
	$pluginfo = '';
	if (!empty($val['Url'])) {
		$pluginfo .= '<b><a href="'.$val['Url'].'" target="_blank">'.$val['Name'].'</a></b>';
	} else {
		$pluginfo .= '<b>'.$val['Name'].'</b>';
	}
	
	if (!empty($val['Version'])) {
		$pluginfo .= '<br/>版本：'.$val['Version'];
	} else {
		$pluginfo .= '<br/>版本：1.0';
	}

	if(!isset($db[$val['Plugin']])){
		$db[$val['Plugin']]["day"]="从未检查";
		$db[$val['Plugin']]["url"]="";
	}

	$authinfo = $db[$val['Plugin']]["day"].'</td><td><div class="input-group"><input type="text" class="form-control" value="'.$db[$val['Plugin']]["url"].'" id="'.$val['Plugin'].'_input"><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="save(\''.$val['Plugin'].'\')" id="'.$val['Plugin'].'_save">保存</button></span></div>';

	$status = '<button type="button" class="btn btn-default" onclick="check(\''.$val['Plugin'].'\',\''.$val['Version'].'\')" id="'.$val['Plugin'].'_check">检查更新</button>';

	$plugins .= '<tr><td>'.$pluginfo.'</td><td>'.$authinfo.'<td>'.$status.'</td></tr>';
	
}

?>
<h2>检查插件更新<button type="button" class="btn btn-default pull-right" onclick="checkAll()">全部检查</button></h2>
<div class="alert alert-info" id="tb_num">当前有 <?php echo sizeof(unserialize(option::get('actived_plugins'))); ?> 个已激活的插件，总共有 <?php echo $stat ?> 个插件 | 请支持<a href="http://www.stus8.com/home.php?mod=space&uid=562&do=thread&view=me&from=space" target="_blank">mokeyjay</a>的插件 （←不要脸 | <a href="http://www.stus8.com/forum.php?mod=forumdisplay&fid=163&filter=sortid&sortid=13" target="_blank">插件商城</a><br/>插件安装方法：直接解压缩插件并放到 /plugins/ 文件夹里就行</div>
<div class="alert alert-info">将插件的发布地址（例如http://www.stus8.com/forum.php?mod=viewthread&tid=2778）粘贴到输入框中即可检查更新。如果你点击了保存按钮，当你下次打开时将不再需要输入地址。</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th style="width:20%">插件信息</th>
			<th style="width:10%">上次检查</th>
			<th style="width:59%">插件发布地址</th>
			<th style="width:11%">操作</th>
		</tr>
	</thead>
	<tobdy>
		<?php echo $plugins; ?>
	</tbody>
</table>
<?php loadfoot(); ?>