<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } if (ROLE != 'admin') { msg('权限不足'); }

if (isset($_GET['add'])) {
	global $m;
	option::set('wmzz_mailer_title' , addslashes($_POST['title']));
	option::set('wmzz_mailer_text' , addslashes($_POST['text']));
	option::set('wmzz_mailer_limit' , $_POST['limit']);
	if ($_POST['check'] == '1') {
		option::set('wmzz_mailer_check','1');
		cron::set('wmzz_mailer','plugins/wmzz_mailer/wmzz_mailer_cron.php',0);
	} else {
		option::set('wmzz_mailer_check','0');
		option::set('wmzz_mailer_last','0');
		cron::set('wmzz_mailer','plugins/wmzz_mailer/wmzz_mailer_cron.php',1);
	}
	ReDirect(SYSTEM_URL.'index.php?plugin=wmzz_mailer&ok');
} else {
loadhead();
if (isset($_GET['ok'])) {
	echo '<div class="alert alert-success">设置已保存。当群发任务完成后，"开始群发" 复选框将自动取消</div>';
}
?>
<h2>群发邮件给所有用户</h2><br/>
<?php if (option::get('wmzz_mailer_check') != '0') {
	echo '群发任务现在已开始，已发送 '.option::get('wmzz_mailer_last').' 封邮件<br/><br/>';
} ?>
<form action="index.php?plugin=wmzz_mailer&add" method="post">
<input type="checkbox" name="check" <?php if (option::get('wmzz_mailer_check') != '0') { echo 'checked'; } ?> value="1"> 开始群发 [ 选中才能群发邮件 ]
<br/><br/>
<div class="input-group">
  <span class="input-group-addon">标题</span>
  <input type="text" name="title" class="form-control" placeholder="邮件标题" value="<?php echo option::get('wmzz_mailer_title') ?>">
</div>
<br/>邮件内容：[ 支持 HTML ]<br/><br/>
<textarea class="form-control" name="text" style="height:350px"><?php echo option::get('wmzz_mailer_text') ?></textarea>
<br/><br/>
<div class="input-group">
  <span class="input-group-addon">每次计划任务发送</span>
  <input type="number" name="limit" class="form-control" placeholder="指定每次计划任务发送多少个邮件" value="<?php echo option::get('wmzz_mailer_limit') ?>">
  <span class="input-group-addon">个邮件</span>
</div>
<br/><br/><button type="submit" class="btn btn-success">保存设置</button>
</form>

<br/><br/><br/><br/>作者：<a href="http://zhizhe8.net" target="_blank">无名智者</a>
<?php
loadfoot();
}
?>