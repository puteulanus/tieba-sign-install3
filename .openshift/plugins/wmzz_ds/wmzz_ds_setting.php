<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
if (ROLE != 'admin') { msg('权限不足!'); }

if (isset($_GET['setting'])) {
	Clean();
	option::set('wmzz_ds_code', addslashes(htmlspecialchars_decode($_POST['wmzz_ds_code'])));
	header("Location: ".SYSTEM_URL.'index.php?mod=admin:setplug&plug=wmzz_ds&ok');
} else {

	if (isset($_GET['ok'])) {
		echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>插件设置成功</div>';
	}
?>

首先，你需要粘贴相关代码。<a href="http://duoshuo.com/" target="_blank">获得多说评论代码</a> | <a href="http://www.uyan.cc/getcode" target="_blank">获得友言评论代码</a>
<br/><br/>
<form action="index.php?mod=admin:setplug&plug=wmzz_ds&setting" method="post">
<b>请在此处粘贴 多说/友言 评论代码：</b><br/><br/>
<textarea class="form-control" name="wmzz_ds_code" style="height:350px;"><?php echo htmlspecialchars(option::get('wmzz_ds_code')) ?></textarea>
<br/><br/>
<button type="submit" class="btn btn-success">提交更改</button>
</form>
<br/><br/>多说/友言 评论 1.0 By 无名智者
<?php } ?>