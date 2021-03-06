<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>3595补偿</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="http://lib.sinaapp.com/js/jquery-ui/1.9.2/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://lib.sinaapp.com/js/jquery-ui/1.9.2/jquery-ui.js"></script>
    <script type="text/javascript" src="Public/Home/Js/global.js"></script>
    <style>
        body{
            font-family: '微软雅黑';
        }
    </style>
</head>
<body>
<div class="panel panel-danger" style="margin:50px auto;min-width:1000px;width:90%;">
    <form method="post" action="<?php echo U('Home/Xiangwan/index');?>">
    <div class="panel-heading">
        <label>3595补偿</label>
        <br/>
		<label>区服:</label>
        <?php echo ($server_html); ?>
        <label>平台来源：</label>
        <select name="resourceid" id="resourceid" class="form-control" style="width:200px;display:inline;" selectplat="<?php echo ($resourceid); ?>">
            <option value="0">请选择平台来源</option>
            <?php if(is_array($plats)): $i = 0; $__LIST__ = $plats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["resource"]); ?>" class="platopt"><?php echo ($vo["platname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <label for="date">开始日期:</label>
        <input class="datepicker" type="input" id="start_date" name="start_date" value="<?php echo ($start_date); ?>"/>&nbsp;
        <label for="date">结束日期:</label>
        <input class="datepicker" type="input" id="end_date" name="end_date" value="<?php echo ($end_date); ?>"/>&nbsp;
        <label>开始等级:</label>
        <input class="form-control" type="input" id="start_level" name="start_level" style="display:inline;width:80px;" value="<?php echo ($start_level); ?>"/>&nbsp;
        <label>结束等级:</label>
        <input class="form-control" type="input" id="end_level" name="end_level" style="display:inline;width:80px;" value="<?php echo ($end_level); ?>"/>&nbsp;
        &nbsp;&nbsp;<input type="submit" value="查询"/>
    </div>
    </form>
    <div class="panel-body">
        <table class="table table-bordered table-striped" style="text-align:center;vertical-align:middle;">
            <thead>
                <label>银两数量(*):</label><br/>
                <input type="text" size="20" value="" name="money" /><br/><br/>
                <label>元宝数量(*):</label><br/>
                <input type="text" size="20" value="" name="emoney" /><br/><br/>
                <label>申请道具名称(*):(支持模糊查询)</label><br/>
                <input type="text" size="20" value="" name="propname" id="propname" />
                <div class="selectimitate">
                    <?php if(is_array($props)): $i = 0; $__LIST__ = $props;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="optionimitate" propid="<?php echo ($vo["propid"]); ?>"><?php echo ($vo["propname"]); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <input type="hidden" name="tempid" id="tempid">
                <br/><br/>道具对应ID&nbsp;<input class="form-control" id="propid" style="width:100px;display:inline-block;"><br/><br/>
                <label>道具列表(*):(可输入多个道具，先查询道具id，在下面按如下格式输入10023:10:0,第一个数字代表道具id，第2个数字代表数量，第3个数字代表是否绑定，0为绑定，1为不绑定，多个道具以英文','分割，如：10023:10:0,10024:20:1     注意：最后一个不需加逗号)</label><br/>
                <input type="text" size="100" name="props" value="" id="props" /><br/><br/>
                <label>邮件内容(*):</label><br/>
                <input type="text" size="20" value="" name="apply_content" /><br/><br/>
                &nbsp;&nbsp;<input type="submit" value="全部发送" class="submit"/><br/><br/>
                <tr align="center">
                    <td>角色id</td>        
                    <td>账号</td>
                    <td>角色名</td>
                    <td>等级</td>
                    <td>登录时间</td>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($rs)): $i = 0; $__LIST__ = $rs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($vo["characterid"]); ?></td>
                        <td class="account"><?php echo ($vo["account"]); ?></td>
                        <td><?php echo ($vo["name"]); ?></td>
                        <td><?php echo ($vo["level"]); ?></td>
                        <td><?php echo ($vo["logintime"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".submit").click(function(){
            var url = "<?php echo U('Apply/sendlot');?>";
            var autoid = $("#autoid").val();
            var content = $("input[name='apply_content']").val();
            var emoney = $("input[name='emoney']").val();
            var money = $("input[name='money']").val();
            var props = $("input[name='props']").val();
            if(autoid == 0){
                alert("请选择区服！");
                return false;
            }
            var len = $(".account").length;
            if(len == 0){
                alert("请先查询账号！");
                return false;
            }
            $(".account").each(function(index){
                var account = $(this).html();
                //$.post(url,{autoid:autoid,content:content,emoney:emoney,props:props,money:money,account:account},function(data){
                  //  if(data == 1){
                   // }
                //});
                $.ajax({
                    type:"POST",
                    url:url,
                    async:false,
                    data:{autoid:autoid,content:content,emoney:emoney,props:props,money:money,characters:account},
                    success:function(data){
                        console.log("accout:" + account + ",data:" + data);
                    }
                })
            })
        });
    });
</script>
</body>
</html>