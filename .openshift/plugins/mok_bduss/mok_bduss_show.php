<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
global $i,$m;
loadhead();
?>
<style type="text/css">
.panel-heading{ cursor: pointer;}
button{ outline:none !important}
/*tbody td:last-child{ text-align: center}*/
#mok_me td{ transition:color .5s ease-in-out;}
.ok{color: #08ac10}
.no{color: #f00}
</style>
<script>
$(function(){
	//判断当前用户的IDs是否有效
	for (var i = 0; i < $("#mok_me tbody tr").length; i++) {
		$.get("plugins/mok_bduss/mok_bduss_bg.php",{"do":"tr","bduss":$("#mok_me tbody tr:eq("+i+") td:eq(2) input").val(),"eq":i},function(data){
			var tr=$("#mok_me tbody tr:eq("+data["eq"]+")").children();
			if(data["id"]==""){
				tr.eq(1).addClass("no").text("失效");
			} else {
				tr.eq(1).addClass("ok").text(decodeURI(data["id"]));
			}
		},"json");
	};
});

function tab(id){
	$("#tab_"+id+"~.panel-body").slideToggle("fast",function(){
		if($("#tab_"+id+" .badge").text()=="◢"){
			$("#tab_"+id+" .badge").text("◥");
			var fast=0;
			if($("#fast").is(":checked")){ fast=1; }
			$.get("plugins/mok_bduss/mok_bduss_bg.php",{"do":"table","uid":id,"fast":fast},function(data){
				var tar=$("#tab_"+id+"~.panel-body");
				tar.slideUp("fast",function(){
					if(data["Empty"]){//如果该账号下没有绑定百度账号
						tar.html("这个账号还没有绑定任何一个百度账号。你可以 -> <button type='button' class='btn btn-danger' onclick='delUser("+id+",$(this))'>删掉这坑货</button>");
					} else {
						tar.text("").append('<table class="table" style="margin-bottom:0"><thead><tr><th style="width:10%">ID</th><th style="width:20%">用户名</th><th style="width:60%">BDUSS</th><th style="width:10%">操作</th></tr></thead><tbody></tbody></table>');
						for (var i in data) {
							var user=data[i][0]==""?' class="no">失效':' class="ok">'+decodeURI(data[i][0]);
							tar.children("table").children("tbody").append('<tr id="'+i+'_tr"><td>'+i+'</td><td id="'+i+'_id"'+user+'</td><td><div class="input-group"><input type="text" id="'+i+'_bduss" class="form-control" value="'+data[i][1]+'"><span class="input-group-btn"><button id="'+i+'_save" class="btn btn-default" type="button" onclick="save('+i+')">保存</button></span></div></td><td><button type="button" id="'+i+'_del" class="btn btn-danger" onclick="del('+i+')">删除</button></td></tr>');
						};
					}
					tar.slideDown("fast");
				});
			},"json");
		} else {
			$("#tab_"+id+" .badge").text("◢");
			$(this).text("加载中...");
		}
	});
}
function save(id){
	var btn=$("#"+id+"_save");
	var bduss=$("#"+id+"_bduss").val();
	btn.text("保存中").attr("disabled","true");
	if(bduss==""){
		alert("请输入有效的BDUSS");
		btn.removeAttr("disabled").text("保存");
	} else {
		var fast=0;
		if($("#fast").is(":checked")){ fast=1; }
		$.get("plugins/mok_bduss/mok_bduss_bg.php",{"do":"save","id":id,"bduss":bduss,"fast":fast},function(data){
			if(data["status"]=="false"){
				alert(data["msg"]);
				btn.removeAttr("disabled").text("保存");
			} else {
				btn.text("已保存");
				$("#"+id+"_id").removeAttr("class").addClass("ok").text(decodeURI(data["id"]));
			}
		},"json");
	}
}
function del(id){
	var btn=$("#"+id+"_del");
	var bduss=$("#"+id+"_bduss").val();
	if(confirm("真的要删除ID为 "+id+" 的这条账号信息吗？")){
		btn.text("删除中").attr("disabled","true");
		$.get("plugins/mok_bduss/mok_bduss_bg.php",{"do":"del","id":id},function(data){
			if(data["status"]=="false"){
				alert(data["msg"]);
				btn.removeAttr("disabled").text("删除");
			} else {
				$("#"+id+"_tr").fadeOut("fast");
			}
		},"json");
	}
}
function delUser(uid,btn){
	//去掉里面的换行和空白，再去掉角标
	var user=$("#tab_"+uid).text().replace(/\s*(◢|◥)\s*/,"").replace(/\s*/,"");
	if(confirm("真的要删除 "+user+" 这个签到账号吗？")){
		btn.text("删除中").attr("disabled","true");
		$.get("plugins/mok_bduss/mok_bduss_bg.php",{"do":"delUser","uid":uid},function(data){
			if(data["status"]=="false"){
				alert(data["msg"]);
				btn.removeAttr("disabled").text("删掉这坑货");
			} else {
				$("#tab_"+uid).parent().slideUp("fast");
			}
		},"json");
	}
}
function tabAll(){
	var tabs=$(".panel-default");
	if(tabs.length==0){ return; }
	var i=0;
	var jsq = setInterval(function(){
		tabs.eq(i).children().click();
		if(i==tabs.length){
			clearInterval(jsq);
			jsq=null;
		}
		i++;
	},500);
}
</script>
<h2>Bduss有效性检测<button type="button" class="btn btn-default pull-right" onclick="tabAll()">全部展开</button></h2>
<div class="alert alert-info" role="alert">如正确显示用户名则表示该BDUSS没有失效</div>
<div class="alert alert-info" role="alert">
	<label><input id="fast" type="checkbox" />  启用快速检测模式</label><br/>
	勾选该选项后可通过特殊方法检测bduss是否有效，缺点是无法显示用户名，优点是速度快。适合垃圾主机或网速不好时使用
</div>
<div id="mok_me" class="panel panel-primary">
	<div class="panel-heading"><?php echo NAME; ?></div>
	<div class="panel-body">
		<table class="table" style="margin-bottom:0">
			<thead>
				<tr>
					<th style="width:10%">ID</th>
					<th style="width:20%">用户名</th>
					<th style="width:60%">BDUSS</th>
					<th style="width:10%">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php /*获取当前用户绑定的ID列表*/ ?>
				<?php foreach ($i['user']['bduss'] as $id => $bduss) { ?>
					<tr id="<?php echo $id; ?>_tr"><td><?php echo $id; ?></td><td id="<?php echo $id; ?>_id">读取中...</td>
					<td><div class="input-group"><input type="text" id="<?php echo $id; ?>_bduss" class="form-control" value="<?php echo $bduss; ?>"><span class="input-group-btn"><button id="<?php echo $id; ?>_save" class="btn btn-default" type="button" onclick="save(<?php echo $id; ?>)">保存</button></span></div></td>
					<td><button type="button" id="<?php echo $id; ?>_del" class="btn btn-danger" onclick="del(<?php echo $id; ?>)">删除</button></td></tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php
	/*如果当前用户为管理员，则显示其他用户的ID*/
	if($i['user']['role']==="admin"){
		$q=$m->query("Select id,name From ".DB_PREFIX."users Where id!=".$i['user']['uid']);
		while ($row=$q->fetch_row()) {
?>
	<div class="panel panel-default">
		<div id="tab_<?php echo $row[0]; ?>" class="panel-heading" onclick="tab(<?php echo $row[0]; ?>)">
			<?php echo $row[1]; ?><span class="badge pull-right">◢</span><!--◥-->
		</div>
		<div class="panel-body" style="display:none">加载中...</div>
	</div>
<?php }} ?>

<?php loadfoot(); ?>