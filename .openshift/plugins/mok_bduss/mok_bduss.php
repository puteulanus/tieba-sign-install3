<?php
/*
Plugin Name: BDUSS有效性检测
Version: 1.3
Plugin URL: http://www.longtings.com
Description: 检测BDUSS是否有效
Author: mokeyjay
Author Email: longting@longtings.com
Author URL: http://www.longtings.com
For: V3.0+
*/
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }

function mok_bduss_navi(){
	?>
	<li <?php if(isset($_GET['plugin']) && $_GET['plugin'] == 'mok_bduss') { echo 'class="active"'; } ?>><a href="index.php?plugin=mok_bduss"><span class="glyphicon glyphicon-exclamation-sign"></span> Bduss有效性检测</a></li>
	<?php
}

addAction('navi_1','mok_bduss_navi');
addAction('navi_7','mok_bduss_navi');
?>