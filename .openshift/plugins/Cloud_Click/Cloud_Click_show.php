<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
	global $m,$i;
	$us=$m->once_fetch_array('SELECT * FROM  `'.DB_NAME.'`.`'.DB_PREFIX.'wmzz_zan` WHERE  `uid` = '.UID.'');
	if (isset($_GET['del'])) {
		$id = intval($_GET['del']);
		$m->query("DELETE FROM `".DB_PREFIX."wmzz_zan_data` WHERE `uid` = '".UID."' AND `id` = '{$id}'");
		ReDirect(SYSTEM_URL . 'index.php?plugin=Cloud_Click&mod=set&ok');
	}
	require SYSTEM_ROOT.'/plugins/Cloud_Click/func.php';
	$set = unserialize(option::get('plugin_Cloud_Click'));
	if ($i['mode'][0] == 'setting') {
	$tbss = isset($_POST['tieba'])   ? $_POST['tieba']                : array();
	$max  = isset($_POST['max'])     ? intval($_POST['max'])          : '0';
	$pid  = isset($_POST['pid'])     ? $_POST['pid']                  : array();
	if (ISVIP == false && (!empty($set['max']) && count($tbss) * $max > $set['max'])) {
		msg('设置无法保存，请勿设置超过规定限额的点赞数量');
	}
	if (ISVIP == false && (!empty($set['lmax']) && count($tbss) > $set['lmax'])) {
		msg('设置无法保存，因为您的最大点赞贴吧数超过了管理员的设置');
	}
	if (ISVIP == false && (!empty($set['cmax']) && $max > $set['cmax'])) {
		msg('设置无法保存，因为您的最大单贴吧点赞帖子数超过了管理员的设置');
	}
	cloudclick::uset(UID,$max,$tbss,$pid);
	Redirect(SYSTEM_URL.'index.php?plugin=Cloud_Click&mod=set&ok');
	} else {
		loadhead();
?>
<script type="text/javascript">
	function addtb() {
		$('#tbs').append('<tr><td><input type="text" class="form-control" name="tieba[]"></td><td><select name="pid[]" class="form-control"><?php
foreach ($i['user']['bduss'] as $keyyy => $valueee) {
	echo '<option value="'.$keyyy.'">'.$keyyy.'</option>';
} ?></select></td></tr>');
	}
</script>
<h2>贴吧帖子云点赞</h2>
<?php if ($i['mode'][0] == 'set') { ?>
<ul class="nav nav-tabs">
	  <li><a href="index.php?plugin=Cloud_Click">点赞日志</a></li>
	  <li class="active"><a href="#">程序设置</a></li>
</ul>
<?php
	if (isset($_GET['ok'])) {
		echo '<br/><div class="alert alert-success">设置保存成功</div>';
	}
	?>
<form action="index.php?plugin=Cloud_Click&mod=setting" method="post">
<input type="button" style="float:right;" class="btn btn-info btn-lg" value="+ 增加" onclick="addtb()">
	<h3>点赞设置</h3>
	输入需要点赞的贴吧名称。按增加按钮添加新点赞设置。留空为不点赞。贴吧名称后面不要带 吧
	<table class="table table-striped">
		<thead>
			<th style="width:70%">贴吧名称</th>
			<th style="width:30%">对应 PID</th>
			<th></th>
		</thead>
		<tbody id="tbs">
			<?php $tbss = $m->query("SELECT * FROM `".DB_PREFIX."wmzz_zan_data` WHERE `uid` = '".UID."';");
			while ($tbs = $m->fetch_array($tbss)) {
				echo '<tr><td><input type="text" class="form-control" name="tieba[]" style="width:100%" value="'.$tbs['tieba'].'" readonly></td><td><input type="text" name="pid[]" value="'.$tbs['pid'].'" class="form-control" readonly></td><td><a class="btn btn-default" title="删除" href="index.php?plugin=Cloud_Click&mod=set&del='.$tbs['id'].'"><b>X</b></a></td></tr>';
			}
			?>
		</tbody>
	</table>
<br/><br/>
<div class="input-group">
	<span class="input-group-addon">单贴吧点赞数量</span>
	<input type="number" class="form-control" required value="<?php echo cloudclick::uget(UID,'num') ?>" min="1" name="max" style="width:100%" size="100%">
</div>
<?php if (ISVIP == false && (!empty($set['max']) || !empty($set['cmax']) || !empty($set['lmax']))) { 
echo '<br/><br/>注意：您';
	if (!empty($set['cmax'])) 
		echo '每天最大能在一个贴吧点赞 '.$set['cmax'].' 个帖子，';
	if (!empty($set['lmax'])) 
		echo '最大能设置点赞 '.$set['lmax'].' 个贴吧，';
	if (!empty($set['max']))
		echo '能设置的点赞总数不能超过 '. $set['max'] . ' 贴<br/>最大点赞总数计算公式： 设置的贴吧数 x 单贴吧点赞数 = 总点赞帖子数'; 
} ?>

<br/><br/><button type="submit" class="btn btn-success">保存设定</button>
</form>
<?php } else { ?>
<ul class="nav nav-tabs">
	  <li class="active"><a href="#">点赞日志</a></li>
	  <li><a href="index.php?plugin=Cloud_Click&mod=set">程序设置</a></li>
</ul>
<?php
$f = $m->query('SELECT * FROM  `'.DB_NAME.'`.`'.DB_PREFIX.'wmzz_zan_data` WHERE  `uid` = '.UID.'');
?>
<br/>
<div class="alert alert-info">
	当前已设置 <?php echo $m->num_rows($f); ?> 个要点赞的帖子
	<?php if($us['lastdo'] != '0000-00-00') echo '，最后一次点赞在 '.$us['lastdo']; ?>，PID 即为 百度账号ID
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>PID</th>
			<th style="width:60%">贴吧名称</th>
			<th style="width:40%">剩余点赞数</th>
		</tr>
	</thead>
	<tbody>
	<?php
	while($x = $m->fetch_array($f)) {
		echo '<tr><td>'.$x['pid'].'</td><td><a href="http://tieba.baidu.com/f?ie=utf-8&kw='.$x['tieba'].'" target="_blank">'.$x['tieba'].'</td><td>'.$x['remain'].' 贴</td></tr>';
	}
	?>
	</tbody>
</table>
<?php } ?>
<br/><br/><br/><br/>贴吧云点赞 V3.1 | 作者：<a href="http://zhizhe8.net" target="_blank">无名智者</a> | 感谢贴吧会员 <a href="http://tieba.baidu.com/home/main?un=h573980998" target="_blank">@h573980998</a>
<?php loadfoot(); }