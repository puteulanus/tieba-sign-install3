<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 
if (ROLE != 'admin') { msg('权限不足!'); }

if (isset($_GET['setting'])) {
	option::set('wmzz_anno_set', addslashes(htmlspecialchars_decode($_POST['wmzz_anno_set'])));
	option::set('wmzz_anno_tpl', addslashes(htmlspecialchars_decode($_POST['wmzz_anno_tpl'])));
	option::set('wmzz_anno_doa', $_POST['wmzz_anno_doa']);
	echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>插件设置成功</div>';
}
?>

<form action="index.php?mod=admin:setplug&plug=wmzz_anno&setting" method="post">
<b>请输入您的公告： [ 每行一个，支持 HTML ]</b><br/><br/>
<textarea class="form-control" name="wmzz_anno_set" style="height:300px;"><?php echo htmlspecialchars(option::get('wmzz_anno_set')) ?></textarea>
<br/><br/>
<b>公告栏模板： [ 使用 {$anno} 表示公告 ]</b><br/><br/>
<textarea class="form-control" name="wmzz_anno_tpl" style="height:150px;"><?php echo htmlspecialchars(option::get('wmzz_anno_tpl')) ?></textarea>
<br/><br/>
<div class="input-group">
  <span class="input-group-addon">公告栏挂载点</span>
  <select class="form-control" name="wmzz_anno_doa">
  	<option value="index_1" <?php if (option::get('wmzz_anno_doa') == 'index_1') { echo 'selected'; } ?> >index_1</option>
  	<option value="index_2" <?php if (option::get('wmzz_anno_doa') == 'index_2') { echo 'selected'; } ?> >index_2</option>
  	<option value="index_3" <?php if (option::get('wmzz_anno_doa') == 'index_3') { echo 'selected'; } ?> >index_3</option>
	<option value="navi_7" <?php if (option::get('wmzz_anno_doa') == 'navi_7') { echo 'selected'; } ?> >navi_7</option>
  	<option value="navi_8" <?php if (option::get('wmzz_anno_doa') == 'navi_8') { echo 'selected'; } ?> >navi_8</option>
  	<option value="navi_9" <?php if (option::get('wmzz_anno_doa') == 'navi_9') { echo 'selected'; } ?> >navi_9</option>
  </select>
</div>
<br/><br/>

<button type="submit" class="btn btn-success">提交更改</button>
</form>
<br/><br/>公告栏 V1.0 By 无名智者