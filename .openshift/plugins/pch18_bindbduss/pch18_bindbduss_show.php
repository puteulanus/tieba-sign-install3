<?php
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
global $i,$m;
loadhead();
?>
<style type="text/css">
.panel-heading{ cursor: pointer;}
tbody td:last-child{ text-align: center}
.ok{color: #08ac10}
.no{color: #f00}
</style>
<?php 
if (isset($_GET['help'])){
?>
<ul class="nav nav-tabs" role="tablist">
  <li><a href="index.php?plugin=pch18_bindbduss">绑定工具</a></li>
  <li class="active"><a href="index.php?plugin=pch18_bindbduss&help">帮助</a></li>
</ul>
<span id="pic" style="float:right;">
<img src="plugins\pch18_bindbduss\pic1.png">
</span>
<h2>1.使用方法</h2><br>
<font size='4pt'>
1->点击『工具下载』按钮<button type="button" class="btn btn-default" onclick="download()"><font color=red><b>工具下载</b></font></button><br><br>
2->打开此文件<br><br>
3->在右图所示的界面登陆您的百度账号<br><br>
4->回到该网站查看是否绑定成功<br><br><br>
<h2>2.报毒措施</h2><br>
1->我们承诺该软件没有病毒<br><br>
2->个人开发的软件被误报是在所难免的<br><br>
3->由于每次下载会往软件中写入账号信息，每个人下载的都是不同的软件，所以无法报备<br><br>
4->如果您相信我们，就请按以下提示操作<br><br>
5->本教程只列出了360的处理方案，其他杀软大同小异，在此不再一一列出，可以退出杀毒软件后运行<br><br>
6->如果打开时出现以下画面请点击左下角的＂添加信任＂，再尝试打开本软件<br><br>
<img src="plugins\pch18_bindbduss\pic2.png"><br><br>
7->若是添加信任后仍然无法打开，请检查软件是不是被360给删除了．若是请重新下载打开或尝试下面第二种方法<br><br>
8->右击屏幕右下角的360图标．点击退出，在接下来的框框中选择＂暂停保护15分钟＂<br><br>
<img src="plugins\pch18_bindbduss\pic3.png"><img src="plugins\pch18_bindbduss\pic4.png"><br><br>
9->若是任然无法使用，请完全退出杀毒软件，或者尝试在其他电脑上操作<br><br>
<br><br>
本软件只在少部分系统下测试通过（不包含苹果电脑），若您的系统无法运行此软件，请将报错信息和系统版本号一同发到pch18@qq.com，我们将继续完善
<br><br><br><br>
<br><br><br><br><br><br><br><br><span style="float:right;">作者:Pch18 <a href='http://t8qd.cn'>T8qd.cn<a></span>
<?php
}else{
	?>
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="index.php?plugin=pch18_bindbduss">绑定工具</a></li>
  <li><a href="index.php?plugin=pch18_bindbduss&help">帮助</a></li>
</ul>

<h2>绑定Bduss工具</h2>
<div class="alert alert-info" role="alert">
1->点击『工具下载』按钮<br>
2->打开此文件<br>
3->在右图所示的界面登陆您的百度账号<br>
4->回到该网站查看是否绑定成功<br>
</div>

<h4>若您的电脑无法运行此软件，请将系统版本号和报错信息发给pch18@qq.com我们将继续完善</h4>
<h4>绑定多个账号无需重新下载，关闭软件重新打开即可绑定其他账号</h4>
<h4>更改此站点的密码后，此软件失效</h4>

<div id="tishi" style="font-size:14pt;"></div><br>
<button type="button" class="btn btn-default" onclick="download()"><font color=red><b>工具下载</b></font></button>
<button type="button" class="btn btn-default" onclick="backlook()"><font color=Blue><b>查看是否绑定成功</b></font></button>
<button type="button" class="btn btn-default" onclick="baodu()"><font color=Chocolate><b>提示有病毒请看这里</b></font></button>
<br><br><br><br><br><br><br><br><span style="float:right; font-size:14pt">作者:Pch18 <a href='http://t8qd.cn'>T8qd.cn<a></span>



<script>
	//$.get('plugins/pch18_bindbduss/pch18_bindbduss_back.php',{'mod':'havekey'},function(data){

function download(){
	$.get('plugins/pch18_bindbduss/pch18_bindbduss_back.php',{'mod':'makeurl'},function(data){  
		location.replace (data);
	})
}

function backlook(){
location.replace ('index.php?mod=baiduid');
}
function baodu(){
location.replace ('index.php?plugin=pch18_bindbduss&help');
}

</script>

<?php
}
loadfoot();
?>