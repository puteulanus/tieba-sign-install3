<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } if (ROLE != 'admin') { msg('权限不足'); }

if (isset($_GET['ok'])) {
	echo '<div class="alert alert-success">设置已保存</div>';
}

$x = unserialize(option::get('plugin_Cloud_Click'));
?>

<h2>贴吧云点赞 - 管理</h2><br/>
<form action="setting.php?mod=plugin:Cloud_Click" method="post">
<table class="table table-striped">
	<thead>
		<tr>
			<th style="width:45%">参数</th>
			<th style="width:55%">值</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>单次连续点赞次数<br/>越小效率越低，但太大也可能点赞无效</td>
			<td><input type="number" name="num" class="form-control" value="<?php echo $x['num']; ?>" step="1" min="1" max="15"></td>
		</tr>
		<tr>
			<td>点赞时间间隔<br/>0 为无间隔，单位为秒。设置间隔可避免点赞无效，但是可能会导致程序超时</td>
			<td><input type="number" name="sp" class="form-control" value="<?php echo $x['sp']; ?>" ></td>
		</tr>
		<tr>
			<td>单次计划任务贴吧点赞数量<br/>设置执行一次计划任务为多少个帖吧点赞，至少为 1。一次计划任务帖子点赞数 = 单次连续点赞次数 x 单次计划任务贴吧点赞数量</td>
			<td><input type="number" name="rem" class="form-control" value="<?php echo $x['rem']; ?>" ></td>
		</tr>
		<tr>
			<td>用户最大设置帖吧数<br/>0 为无限，优先于总灌水量设置</td>
			<td><input type="number" name="lmax" class="form-control" min="0" value="<?php echo $x['lmax']; ?>" ></td>
		</tr>
		<tr>
			<td>用户最大单贴吧点赞帖子数<br/>0 为无限，优先于总灌水量设置</td>
			<td><input type="number" name="cmax" class="form-control" min="0" value="<?php echo $x['cmax']; ?>" ></td>
		</tr>
		<tr>
			<td>用户最大总点赞量<br/>0 为无限，计算公式： 设置的帖吧数 x 每个帖吧的灌水数量 = 总点赞量</td>
			<td><input type="number" name="max" class="form-control" min="0" value="<?php echo $x['max']; ?>" ></td>
		</tr>
	</tbody>
</table>

<br/><br/><button type="submit" class="btn btn-success">保存设定</button>
</form>
<br/><br/><br/><br/>贴吧云点赞 V3.0 | 作者：<a href="http://zhizhe8.net" target="_blank">无名智者</a> | 感谢贴吧会员 <a href="http://tieba.baidu.com/home/main?un=h573980998" target="_blank">@h573980998</a>
