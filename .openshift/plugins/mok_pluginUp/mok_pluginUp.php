<?php
/*
Plugin Name: 检查插件更新
Version: 1.1
Plugin URL: http://www.longtings.com
Description: 检查插件是否有新版本
Author: mokeyjay
Author Email: longting@longtings.com
Author URL: http://www.longtings.com
For: V3.0+
*/
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }

function mok_pluginUp_navi(){
	?>
	<li <?php if(isset($_GET['plugin']) && $_GET['plugin'] == 'mok_pluginUp') { echo 'class="active"'; } ?>><a href="index.php?plugin=mok_pluginUp"><span class="glyphicon glyphicon-open"></span> 检查插件更新</a></li>
	<?php
}

addAction('navi_2','mok_pluginUp_navi');
addAction('navi_8','mok_pluginUp_navi');
?>