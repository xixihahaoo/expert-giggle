<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	 <link rel="stylesheet" type="text/css" href="/Public/Admin/css/layerui/css/layui.css">
   <script type="text/javascript" src="/Public/Admin/css/layerui/layui.js"></script>
   
    <!-- bootstrap -->
    <link href="/Public/Admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
    <link href="/Public/Admin/css/bootstrap/bootstrap.css" rel="stylesheet" />

  <title></title>
    <style>
        .layui-input{
            width: 60%;
            display: inline-block;
        }
    </style>
</head>
<body>
 <form  id="id_form" method="post">
  <div class="layui-form">
    <table class="layui-table">
      <colgroup>
        <col width="50">
        <col width="150">
        <col width="150">
        <col width="200">
        <col>
      </colgroup>
      <thead>
        <tr>
          <th style="text-align: center;">编号</th>
          <th style="text-align: center;">用户名</th>
          <th style="text-align: center;">手机号码</th>
          <th style="text-align: center;">账户余额</th>
          <th style="text-align: center;">登录时间</th>
          <th style="text-align: center;">注册时间</th>
        </tr>
      </thead>
      <tbody>
      
         <input type="hidden" name="uid" value="<?php echo ($uid); ?>">
        <?php if(is_array($user)): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr style="text-align: center;">
            <td><?php echo ($vo["uid"]); ?></td>
            <td><?php echo ($vo["username"]); ?></td>
            <td><?php echo ($vo["utel"]); ?></td>
            <td><?php echo ($vo["balance"]); ?></td>
            <td><?php echo ($vo['lastlog']); ?></td>
            <td><?php echo date('Y-m-d H:i:s',$vo['utime']);?></td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
        <div class="pagination pull-right">
            <ul>
                <?php echo ($page); ?>
            </ul>
        </div>
  </div>
  </form>
</body>
</html>