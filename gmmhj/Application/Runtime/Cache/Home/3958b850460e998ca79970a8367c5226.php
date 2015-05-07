<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>元宝统计</title>
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
    <form method="post" action="<?php echo U('Home/Cost/task');?>">
    <div class="panel-heading">
        <label>全服老玩家数据</label>&nbsp;&nbsp;
    </div>
    </form>
    <div class="panel-body">
        <table class="table table-bordered datadiv" style="text-align:center;vertical-align:middle;"></table>
    </div>
</div>
<input type="hidden" name="jsondata" value='<?php echo ($jsonstring); ?>'/>
<script>
    $(document).ready(function(){
        var jsondata = $("input[name='jsondata']").val();
        //console.log(jsondata);
        jsonstring = jQuery.parseJSON(jsondata);
        var length = jsonstring.length;
        var pernum = 20;
        var num = Math.ceil(length / pernum);
        //alert(jsonstring[0].date);
        //console.log(num);
        for(var i = 0;i < num;i++){
            var theadhtml = "<thead><tr align='center'>";
            var tbodyhtml = "<tbody><tr align='center'>";
            for(var j = i * pernum;j < pernum * (i + 1);j++){
                if(j < length){
                    theadhtml += "<td style='width:50px;'>" + jsonstring[j]['date'] + "</td>";
                    tbodyhtml += "<td>" + jsonstring[j]['num'] + "</td>";
                }
            }
            theadhtml += "</tr></thead>";
            tbodyhtml += "</tr></tbody>";
            $(".datadiv").append(theadhtml);
            $(".datadiv").append(tbodyhtml);
        }
    })
</script>
</body>
</html>