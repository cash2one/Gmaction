<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>每日数据</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="http://lib.sinaapp.com/js/jquery-ui/1.9.2/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://lib.sinaapp.com/js/jquery-ui/1.9.2/jquery-ui.js"></script>
    <script type="text/javascript" src="Public/Home/Js/global.js"></script>
</head>
<body>
<div class="panel panel-danger" style="margin:50px auto;min-width:1000px;width:90%;">
    <form method="post" action="<?php echo U('Home/Apply/sendmails');?>">
    <div class="panel-heading">
        <label>玩家信息查询</label>&nbsp;&nbsp;
        <label>区服:</label>
        <?php echo ($server_html); ?>
        <label for="date">开始日期:</label>
        <input class="datepicker" type="input" id="start_date" name="start_date" value="<?php echo ($start_date); ?>" />&nbsp;
        <label for="date">结束日期:</label>
        <input class="datepicker" type="input" id="end_date" name="end_date" value="<?php echo ($end_date); ?>" />&nbsp;
        <label for="level">VIP等级：</label>
        <input type="input" id="viplevel" name="viplevel" value="<?php echo ($viplevel); ?>" />&nbsp;
        <input type="submit" value="查询"/>
        <br/>
        <label for="content">邮件内容（不超过50字符）</label>
        <br/>
        <input type="text" id="content" name="content" style="width:600px;"/>
        <input type="button" class="send" value="开始群发"/>
    </div>
    </form>
    <div class="panel-body">
        <table class="table table-bordered" style="text-align:center;vertical-align:middle;">
            <thead>
            <tr align="center">
                <td id="col1">角色id</td>
                <td>账号</td>
                <td>VIP等级</td>
                <td>最后一次充值时间</td>
            </tr>
            </thead>
            <tbody>
                <?php if(is_array($rs)): $i = 0; $__LIST__ = $rs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td class="uid"><?php echo ($vo["characterid"]); ?></td>
                    <td><?php echo ($vo["account"]); ?></td>
                    <td><?php echo ($vo["vip"]); ?></td>
                    <td><?php echo ($vo["time"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    
</div>
<script>
    $(document).ready(function(){
        $(".send").click(function(){
            if($("#autoid").val() == 0){
                alert("请选择区服");
                return false;
            }
            if($("#content").val() == ""){
                alert("请输入邮件内容");
                return false;
            }
            var len = $(".uid").length;
            if(len == 0){
                alert("请先查询");
                return false;
            }
            $(".uid").each(function(index){
                var character = $(this).html();
                var autoid = $("#autoid").val();
                var content = $("#content").val();
                var url = "<?php echo U('Home/Apply/mailstart');?>";
                $.post(url,{character:character,autoid:autoid,content:content},function(data){
                    console.log(data);
                });
            });
        });        
    });
</script>
</body>
</html>