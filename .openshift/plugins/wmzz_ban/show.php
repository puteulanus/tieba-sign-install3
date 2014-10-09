<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } global $m,$i,$s; ?>
<input type="button" data-toggle="modal" data-target="#banuser" class="btn btn-info btn-lg" value="+ 增加封禁" style="float:right;">
<h2>贴吧循环封禁</h2>

以下为循环封禁列表，若要增加新的封禁，请点击右侧的 增加封禁 按钮
<br/><br/>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>PID</th>
			<th style="width:30%">所在贴吧</th>
			<th style="width:30%">被封禁人名字</th>
			<th style="width:25%">截止日期</th>
			<th style="width:25%">下次封禁</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$x = $m->query("SELECT * FROM `".DB_PREFIX."wmzz_ban` WHERE `uid` = ".UID);
		while($v = $m->fetch_array($x)) {
		?>
		<tr>
			<td><?php echo $v['id'] ?></td>
			<td><?php echo $v['pid'] ?></td>
			<td><?php echo $v['tieba'] ?></td>
			<td><?php echo $v['user'] ?></td>
			<td>
			<?php if ($v['date'] == '0') {
				echo '永久';
			} else {
				echo date('Y-m-d',$v['date']);
			}
			?></td>
			<td><?php if(empty($v['nextdo'])) echo '即将'; else echo date('Y-m-d' , $v['nextdo'] ); ?></td>
			<td><a class="btn btn-default" href="index.php?plugin=wmzz_ban&mod=del&id=<?php echo $v['id'] ?>" title="删除"><span class="glyphicon glyphicon-remove"></span> </a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script type="text/javascript">
	function conban() {
		document.getElementById('banlist').innerHTML += '<br/><div class="input-group"><span class="input-group-addon">被封禁人百度名字</span><input type="text" name="user[]" class="form-control"></div>';
	}
</script>
<div class="modal fade" id="banuser" tabindex="-1" role="dialog" aria-labelledby="banuser" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="banuser_title">添加循环封禁</h4>
      </div>
      <form action="index.php?plugin=wmzz_ban&mod=add" method="post">
      <div class="modal-body">
      	要操作的贴吧名称后面不要带 <b>吧</b>，封禁截止日期格式为 yyyy-mm-dd，<b>0</b> 表示永久封禁<br/>
      	<br/>
      	<div class="input-group">
			<span class="input-group-addon">选择封禁发起人账号ID [PID]</span>
     	    <select name="pid" class="form-control"><?php foreach ($i['user']['bduss'] as $keyyy => $valueee) {echo '<option value="'.$keyyy.'">'.$keyyy.'</option>';} ?></select>
      	</div>
      	<br/>
      	<div class="input-group">
			<span class="input-group-addon">要操作的贴吧名称</span>
     	   	<input type="text" name="tieba" class="form-control">
      	</div>
      	<br/>
      	<div id="banlist">
      	<div class="input-group">
			<span class="input-group-addon">被封禁人百度名字</span>
     	   	<input type="text" name="user[]" class="form-control">
      	</div>
      	</div>
      	<br/>
      	<div class="input-group">
			<span class="input-group-addon">封禁截止日期</span>
     	   	<input type="text" name="date" class="form-control" value="0">
      	</div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-info" style="float:left;" onclick="conban()">继续添加</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary" id="runsql_button">提交更改</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<br/><br/>管理员设置的循环封禁理由：<?php echo $s['msg'] ?>
<br/><br/>作者：<a href="http://zhizhe8.net" target="_blank">无名智者</a>