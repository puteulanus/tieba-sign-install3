<?php
/*
Plugin Name: 绑定Bduss插件
Version: 1.00
Plugin URL: http://t8qd.cn
Description: 管理员可手动为成员刷新列表
Author: pch18
Author URL: http://t8qd.cn
For: V3.0+
*/
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }

function pch18_bindbduss(){
	?>
	<li <?php if(isset($_GET['plugin']) && $_GET['plugin'] == 'pch18_bindbduss') { echo 'class="active"'; } ?>><a href="index.php?plugin=pch18_bindbduss"><span class="glyphicon glyphicon-paperclip"></span> 绑定Bduss工具</a></li>
	<?php
}

addAction('navi_1','pch18_bindbduss');
addAction('navi_7','pch18_bindbduss');
?>