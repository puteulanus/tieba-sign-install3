<?php
require '../../init.php';
if (isset($_GET['index'])){
	$x=new wcurl('http://t8qd.cn/api/tongji.php?mod=gettongji');
	echo $x->exec();
}

?>