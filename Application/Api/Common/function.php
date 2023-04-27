<?php
//获取并格式化当前时间
function get_time()
{
    return date("Y-m-d H:i:s",time());
}
function sys_get_time()
{
    return date("Y-m-d H:i:s",time());
}
function sys_check_empty($parm)
{
    if(!isset($parm) || strlen(trim($parm))==0)
        return true;
    return false;
}




//检测多个post参数是否完整并且不为空值
function sys_check_post($post_array) {
    foreach ($post_array as $parm) {
        if (!isset($_POST[$parm]) || sys_check_empty($_POST[$parm])) {
            sys_out_fail($parm." 参数不能为空",100);
        }
    }
}
//检测单个post参数是否完整（前台不再生成数组以便节省开销）
function sys_check_post_single($parm)
{
    if (!isset($_POST[$parm]) || sys_check_empty($_POST[$parm])) {
        sys_out_fail($parm." 参数不能为空",100);
    }
}

//向客户端发送JSON串
function sys_out_json($parm_array)
{
    //防止PHP自带json_encode函数把中文转成unicode(必须是PHP5.4以上版本)
    //die(json_encode($parm_array,JSON_UNESCAPED_UNICODE));
    if (version_compare(PHP_VERSION,'5.4.0','<'))
        echo json_encode($parm_array);
    else
        echo json_encode($parm_array, JSON_UNESCAPED_UNICODE);
    die();//非常重要，请勿删除
}

//向客户端输出错误信息(500表示是服务器端异常错误，需要重试)
function sys_out_fail($parmMsg=NULL,$errorNumber=500)
{
    unset($result_array);
    $result_array['success'] = false;//注意：为了和extjs兼容，此处必须不带引号

    if(empty($parmMsg)) $parmMsg="操作失败！";
    else $parmMsg=	$parmMsg;

    $result_array['msg'] = $parmMsg;
    $result_array['error_code'] = $errorNumber;

    sys_out_json($result_array);
}
//向客户端输出成功信息
function sys_out_success($parmMsg=NULL,$infor_array=NULL)
{
    unset($result_array);
    $result_array['success'] = true;//注意：为了和extjs兼容，此处必须不带引号

    if(empty($parmMsg)) $parmMsg="操作成功！";

    $result_array['msg'] = $parmMsg;
    $result_array['infor'] = $infor_array;//固定输出infor字段，以适配各种复杂情况
    sys_out_json($result_array);
}


//根据client_id来生成并返回token
function sys_get_token($client_id,$username)
{
    $myToken = "TK_".sys_create_code()."_".$client_id;//命名规则：TK_6位随机数_用户主键ID
    $_SESSION['client_id']  = $client_id;
    $_SESSION['username']   = $username;
    $_SESSION['token']      = $myToken;
    return $myToken;
}

function sys_get_temp_token($parmStr)
{
    $myToken= "TK_".sys_create_code()."_".$parmStr;//命名规则：TK_6位随机数_用户登录名(此登录名重设密码时需要用到，不可或缺)
    $_SESSION['temp_token']=$myToken;
    return $myToken;
}
//获取4位定长数字随机串
function sys_create_code()
{
    return rand(1000,9999);
}
//获取系统唯一串号
function sys_get_no()
{
    //时间戳再加4位随机数，共18位
    return date("YmdHis").sys_create_code();
}


//用户登录加入session token
function  sys_set_token($user = array())
{
    $myToken = "TK_".sys_create_code()."_".$user['uid'];

    $_SESSION['user_id']    = $user['uid'];
    $_SESSION['username']   = $user['username'];
    $_SESSION['mobile']     = $user['utel'];
    $_SESSION['token']      = $myToken;
}


/**
 * @author: wang
 * @date: 2016-11-10 12:04:12
 * @description: 运营中心
 * @note:
 */
 function parent_user_id($user_id,$numer)
 {    
    $user = M('UserinfoRelationship')->where(array('user_id'=>$user_id))->find();  //用户


    if(isset($user))
    {
        //运营中心
        if(trim($numer) == 2){
          
            if($user["user_type"] != 5){
                return parent_user_id($user["parent_user_id"],$numer);
            }
        }
         
         //经纪人
        if(trim($numer) == 1){

            $user = M("UserinfoRelationship")->where(array('user_id' => $user['parent_user_id']))->find();
        }

        if(isset($user['user_id']))
        {
            
            return $user['user_id'];

        } else {

            sys_out_fail('系统没有查到该用户的上级');
        }
    }  else {

            sys_out_fail('系统没有查到该用户的上级');
    }
 }

 //佣金比率
function commission_rate($class){

  $rate = M("UserinfoRate")->where(array('class' => $class))->find();
  return $rate['rate'];
}


