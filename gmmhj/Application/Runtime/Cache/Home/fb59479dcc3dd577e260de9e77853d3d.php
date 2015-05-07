<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>申请充值</title>
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
            <form method="post" action="<?php echo U('Home/Apply/apply');?>">
                <div class="panel-heading">
                    <h4>申请元宝（通过邮件发送）</h4>
                    <label>区服:</label>
                    <?php echo ($server_html); ?><br/><br/>
                    <label>角色信息(*):(可以输入角色id、账号、角色名，注意中英文符号区别)</label><br/>
                    <input type="text" size="100" name="characters" value="" id="characters" /><br/><br/>
                    <label>申请货币数量(*):</label><br/>
                    <input type="text" size="20" value="" name="apply_gold" /><br/><br/>
                    <label>邮件内容(*):</label><br/>
                    <input type="text" size="20" value="" name="apply_content" /><br/><br/>
                    <label>申请原因(*):</label><br/>
                    <input type="text" size="100" value="" name="reason" /><br/><br/>
                    <input type="button" value="申请" class="submit"/>
                </div>
            </form>
        </div>
    </body>
    <script>
        $(document).ready(function(){
            $(".submit").click(function(){
                var url = "<?php echo U('Home/Apply/apply1');?>";
                var autoid = $("#autoid").val();
                var characters = $("#characters").val();
                var apply_gold = $("input[name='apply_gold']").val();
                var apply_content = $("input[name='apply_content']").val();
                var reason = $("input[name='reason']").val();
                $.post(url,{autoid:autoid,characters:characters,apply_gold:apply_gold,apply_content:apply_content,reason:reason},function(data){
                    //alert(data);
                    if(data == 1){
                        alert('申请成功！');
                        window.location.reload();
                    }else{
                        alert('申请失败！' + data);
                    }
                });
            });
        });
    </script>
</html>