<?php if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); }
global $m;
function cron_signtz_mail() {
    global $m;
    $today=date("Y-m-d");
    $lastday=option::get('haotian_mail');
    if ((time()-1396281600)%86400<10800)
        return '未到发送邮件时间';
    if ($today!=$lastday)
        option::set('haotian_mail',$today);
    else return '今日任务已经执行完毕';
    $query = $m->query("SELECT * FROM  `".DB_NAME."`.`".DB_PREFIX."users`");
	while ($fetch = $m->fetch_array($query)) {
		$mail=$fetch['email'];
        $name=$fetch['name'];
        $id=$fetch['id'];
        $title="[".date("Y-m-d")."] 贴吧云签到 - $name - 签到报告";
        $query2 = $m->query("SELECT * FROM  `".DB_NAME."`.`".DB_PREFIX."tieba` WHERE `uid`=$id");
        $c=0;
        $content='<p class="sign_title">贴吧云签到 - 签到报告</p><p>'.date("Y-m-d").'<br>若有大量贴吧签到失败，建议您重新设置 Cookie 相关信息</p><table class="result_table"><thead><tr><td style="width: 40px">#</td><td>贴吧</td><td style="width: 75px">状态</td><td style="width: 75px">经验</td></tr></thead><tbody>';
        while ($ff = $m->fetch_array($query2)) {
            $c++;
            $tie8=$ff['tieba'];
            $status=$ff['status'];
            $content.="<tr><td>$c</td><td><a href=".'"http://tieba.baidu.com/f?kw='.urlencode($tie8).'" target="_blank">'.$tie8.'</a>'."</td>";
            if ($status==0) $content.="<td>已签到</td><td>+8</td>";
            else $content.="<td>签到失败</td><td>-</td>";
            $content.="</tr>";
        }
        $content.="</tbody></table>";
        $content='<style type="text/css">div.wrapper * { font: 12px "Microsoft YaHei", arial, helvetica, sans-serif; word-break: break-all; }div.wrapper a { color: #15c; text-decoration: none; }div.wrapper a:active { color: #d14836; }div.wrapper a:hover { text-decoration: underline; }div.wrapper p { line-height: 20px; margin: 0 0 .5em; text-align: center; }div.wrapper .sign_title { font-size: 20px; line-height: 24px; }div.wrapper .result_table { width: 85%; margin: 0 auto; border-spacing: 0; border-collapse: collapse; }div.wrapper .result_table td { padding: 10px 5px; text-align: center; border: 1px solid #dedede; }div.wrapper .result_table tr { background: #d5d5d5; }div.wrapper .result_table tbody tr { background: #efefef; }div.wrapper .result_table tbody tr:nth-child(odd) { background: #fafafa; }</style><div class="wrapper">'.$content.'</div><br><p style="font-size: 12px; color: #9f9f9f; text-align: right; border-top: 1px solid #dedede; padding: 20px 10px 0; margin-top: 25px;">此封邮件来自 百度贴吧云签到<br>Haotian Mail API v0.1, 2014 &copy; <a href="http://ihaotian.me/">Haotian\'s Laboratory</a>.</p>';
        if ($c==0) continue;
		$x = misc::mail($mail, $title, $content);
        if($x != true) return '发送失败，错误日志：'.$x;
	}
    return '邮件发送成功！';
}