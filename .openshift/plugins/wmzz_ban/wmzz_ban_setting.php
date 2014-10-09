<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

$s = unserialize(option::get('plugin_wmzz_ban'));

if (isset($_GET['ok'])) {
	echo '<div class="alert alert-success">设置保存成功</div>';
}
?>
<h3>循环封禁 - 管理</h3><br/>
<form action="setting.php?mod=plugin:wmzz_ban" method="post">
<table class="table table-striped">
	<thead>
		<tr>
			<th style="width:45%">参数</th>
			<th style="width:55%">值</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>单次计划任务连续封禁次数<br/>越小效率越低，但太大也可能导致超时</td>
			<td><input type="number" min="1" step="1" name="limit" value="<?php echo $s['limit'] ?>"  class="form-control" required></td>
		</tr>
		<tr>
			<td>被封禁提示语句</td>
			<td><input type="text" value="<?php echo $s['msg'] ?>" name="msg" class="form-control" required></td>
		</tr>
	</tbody>
</table>
<br/><br/><button type="submit" class="btn btn-success">保存设定</button>
</form>