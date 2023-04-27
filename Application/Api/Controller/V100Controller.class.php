<?php
// +----------------------------------------------------------------------
// | Api接口数据
// +----------------------------------------------------------------------
// | Author wang <admin>
// +----------------------------------------------------------------------
namespace Api\Controller;
use Think\Controller;
use Org\Util\Gateway;
use Org\Util\Shouxinyi;
use Org\Util\ShouxinyiYinlian;
use Org\Util\Des;
use Org\Util\Log;

class V100Controller extends Controller{
    public $session_id;
    // _initialize是TP封装后的初始化函数
     function _initialize() {
         $this->url = 'http://'.$_SERVER['HTTP_HOST'];

        /*//接口签名验证
        if(!SYS_DEBUG_MODE && ACTION_NAME!='version' && ACTION_NAME!='getOperate'){
             $datetime = _POST('datetime');
             $sign = _POST('sign');
             if(sys_get_timespan($datetime, sys_get_time(), 'i')>'60') sys_out_fail('非法操作',500);
             $signValue = md5(DATAKEY.'|'.$datetime.'|'.ACTION_NAME);
             if($signValue != $sign) sys_out_fail('签名错误',500);
         }*/
        //接口调用记录
        $data['client_id'] =$_SESSION['client_id'] ?$_SESSION['client_id'] : 0;
        $data['module'] = MODULE_NAME;
        $data['action'] = ACTION_NAME;
        $data['content'] = json_encode($_REQUEST);
        $data['regdate'] =date('Y-m-d H:i:s');
        $data['url']=$_SERVER['HTTP_HOST'];
        //var_dump($data);exit;
       // M('ApiRecord')->add($data);

        //定义不需要检查登陆令牌的接口数组

       // $not_check_token_list=array(
       //     'getOperate','getProduct','product','play','newtrader','register','login','outpwd','get_mobile_code','smsverify','binding','closeClient','highstock','news'
       // );

       // array_walk($not_check_token_list,function(&$v,$k){$v = strtolower($v);});

       // if(!in_array(ACTION_NAME,$not_check_token_list))
       //     $data = $this->checkLogin();//非指定方法名，统一进行登录令牌有效性检查
    }

    /**
     * app版本更新
     * @author wang <admin>
     */
    public function version()
    {

        $post_array = array('v','isck');
        sys_check_post($post_array);

        $v          = trim(I('post.v'));
        $isck       = trim(I('post.isck'));

        $versionObj = M('appupdate');

        $version    = $versionObj->order('appid desc')->find();

        if($version)
        {
            if($version['v'] == $v)
            {
                sys_out_fail('你当前的版本号为最新版本号');
            } else {

                if($isck == 'Android')
                {
                    $data['url'] = $version['andord_url'];

                } else if($isck == 'iOS')
                {
                    $data['url']    = $version['ios_url'];
                }

                $data['title'] = '有新的升级包';

                sys_out_success('',$data);
            }
        } else {

            sys_out_fail('你当前的版本号为最新版本号');
        }
    }


    /**
     * 根据运营中心获取首页产品
     * @author wang <admin>
     */

    public function getProduct()
    {

        $user_id    = $this->checkLogin();

        $agent_id   = parent_user_id($user_id,2);

        $userObj    = M('userinfo');
        $classObj   = M('OptionClassify');
        $optionObj  = M('option');

        
        $info = $userObj->field('uid,s_domain_trade,utel')->where(array('uid' => $agent_id,'otype' => 5))->find();

        if(!$info)
        {
            sys_out_fail('系统没有查到此运营中心');
        }

        $data   = array();

        $map['a.global_flag']   = 1;
        $map['b.user_id']       = $info['uid'];
        $map['b.status']        = 1;             //1为可售

        $field  = 'a.id,a.option_key,capital_key,a.capital_name,a.Price,a.DiffRate,a.flag,a.global_flag,a.pid,b.user_id,b.option_intro,c.capital_length';
        $option = M('option a')->
        field($field)->
        join(' left join wp_option_user_special as b on a.id = b.option_id')->
        join('left join wp_option_info as c on a.id = c.option_id')->
        where($map)->order('c.sort asc')->
        select();

        foreach ($option as $key => $value) {

            $option[$key]['Price']    = sprintf("%.".$value['capital_length']."f",$value['Price']);

            if($value['flag'] == 0 || $value['global_flag'] == 0){

                $option[$key]['img'] = $this->url.'/Public/Api/img/'.$value['option_key'].'z.png';
            } else {

                $option[$key]['img'] = $this->url.'/Public/Api/img/'.$value['option_key'].'.png';
            }

            $option[$key]['Hugh'] = shijian($value['id']);
        }

        $optionArr = array();
        foreach ($option as $key => $value) {
            $optionArr[$value['pid']][] = $value;
        }

        $class  = $classObj->field('id,name')->order('id asc')->select();   //分类  desc

        foreach ($class as $key => $value) {

            $class[$key]['data'] = $optionArr[$value['id']];
        }


        //头部公告
        $add    = M('newsclass')->field('fid')->where(array('fid' => 5,'isshow' => 1))->find();
        $news   = M("newsinfo")->field('nid,ntitle,ncover')->where(array('ncategory' => $add['fid']))->select();

        foreach ($news as $key => $value) {
            $news[$key]['ncover']   = $this->url.'/Uploads/'.$value['ncover'];
            $news[$key]['url']      = $this->url.'/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/newtrader';
        }

        $data['data']   = $class;
        $data['news']   = $news;
        $data['trade']  = $info['s_domain_trade'];
        $data['utel']   = $info['utel'];

        sys_out_success('',$data);
    }

    public function simulationData(){
        
        $user_id    = $this->checkLogin();

        $agent_id   = parent_user_id($user_id,2);

        $map['a.global_flag']   = 1;
        $map['b.user_id']       = $agent_id;
        $map['b.status']        = 1;
        $result = M('option a')->field('a.id,a.capital_name,a.flag,a.global_flag,a.option_key')->join(' left join wp_option_user_special as b on a.id = b.option_id')->join('left join wp_option_info as c on a.id = c.option_id')->where($map)->order('c.sort asc')->select();

        foreach ($result as &$value) {
             
             if($value['flag'] == 0 || $value['global_flag'] == 0){

                $value['img']   = $this->url.'/Public/Api/img/'.$value['option_key'].'z.png';
             } else {

                $value['img']   = $this->url.'/Public/Api/img/'.$value['option_key'].'.png';
            }
        }

        $data['result'] = $result;

        $data['gold']   = M('accountinfo')->where(array('uid' => $user_id))->getField('gold');

        sys_out_success('',$data);
        
    }


    /**
     * 产品详情
     * @author wang <admin>
     */

    public function product()
    {

        $id         = trim(I('post.id'));
        $type       = trim(I('post.type'));

        sys_check_post_single('type');

        $user_id    = $this->checkLogin();

        $agent_id   = parent_user_id($user_id,2);

        if(empty($id))
        {
            $first = M("option a")->
            field('a.id')->
            join('wp_option_info as b on a.id = b.option_id')->
            join('wp_option_user_special as c on a.id = b.option_id')->
            where(array('a.global_flag' => 1,'c.status' => 1,'user_id' => $agent_id))->
            order('b.sort asc')->
            find();

            if($first)
            {
                $id = $first['id'];
            } else {

                sys_out_fail('此运营中心没有没有开启产品数据');
            }
        }

        $field = 'a.id,a.capital_key,a.capital_name,a.sell_flag,a.flag,a.global_flag,a.Price,a.Open,a.Close,a.High,a.Low,a.Diff,a.DiffRate,a.bp,a.bv,a.sp,a.sv,b.capital_length,b.hs_code';
        $product = M('option a')->field($field)->join('wp_option_info as b on a.id = b.option_id')->where(array('a.id' => $id))->find();

        
        if($product['flag'] == 0 || $product['global_flag'] == 0)
        {
            $product['msg']       = '已休市';

        } else if($product['sell_flag'] == 0)
        {
            $product['msg']       = '即将休市';
        
        }

        $product['Price']    = sprintf("%.".$product['capital_length']."f",$product['Price']);
        $product['bp']       = sprintf("%.".$product['capital_length']."f",$product['bp']);
        $product['sp']       = sprintf("%.".$product['capital_length']."f",$product['sp']);
        $product['note_msg'] = '本时段持仓时间至 '.deal_time_end($product['id']);
        $product['play_msg'] = $this->url.'/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/play';

        $map['a.global_flag'] = 1;
        $map['b.user_id']     = $agent_id;
        $map['b.status']      = 1;


        $field     = 'a.id,a.capital_key,a.capital_name';
        $opiton    = M('option a')->
        field($field)->
        join(' left join wp_option_user_special as b on a.id = b.option_id')->
        join('left join wp_option_info as c on a.id = c.option_id')->
        where($map)->order('c.sort asc')->
        select();

        if(!$opiton)
        {
            sys_out_fail('没有数据');
        }

        if($user_id)
        {

            $count = M('order')->where(array('uid' => $user_id,'ostaus' => 0, 'pid' => $product['id'],'type' => $type))->count();

            $user  = M('accountinfo')->field('balance,gold')->where(array('uid' => $user_id))->find();

            $data['order_count']    = $count; 
            $data['balance']        = $user['balance'];
            $data['gold']           = $user['gold'];
            $data['is_login']       = true;

        } else {

            $data['is_login'] = false;
        }

        $data['data']   = $product;
        $data['option'] = $opiton;
 
        sys_out_success('',$data);
    }

    /**
     * 产品玩法
     * @author wang <admin>
     */
    public function play()
    {
        $option_id = trim(I('post.option_id'));

        sys_check_post_single('option_id');

        $news = M('OptionPlay')->where(array('option_id' => $option_id))->find();
        $news = html_entity_decode($news['content']);

        $option_name = M('option')->where(array('id' => $option_id))->getField('capital_name');
        
        $data['news'] = $news;
        $data['option_name'] = $option_name.'玩法规则';
        sys_out_success('',$data);
    }

    /**
     * 新闻详情
     * @author wang <admin>
     */

    public function newtrader()
    {
        $nid = trim(I('post.nid'));

       if($nid){
                 
            $news = M("newsinfo")->where(array('nid' => $nid))->find();
            $data['news'] = html_entity_decode($news['ncontent']);
            $data['title'] = $news['ntitle'];

            sys_out_success('',$data);

       } else{

            $class = M('newsclass')->where(array('fid' => 6,'isshow' => 1))->find();
            $news  = M('newsinfo')->where(array('ncategory' => $class['fid']))->find();

            $data['news']  = html_entity_decode($news['ncontent']);
            $data['title'] = '新手指引';

            //$this->assign('data',$data);
       }
        $this->assign('data',$data);
        $this->display();
    }


    /**
     * 用户注册
     * @author wang <admin>
     */
    public function register()
    {
        $mobile   = trim(I('post.mobile'));
        $smscode  = trim(I('post.smscode'));
        $password = trim(I('post.password'));
        $code     = trim(I('post.code'));

        $post_array = array('mobile','smscode','password','code');
        sys_check_post($post_array);

        if(!APP_DEBUG){
            if($smscode != session('mobile_code')){
                sys_out_fail('短信验证码不正确');
            }
        }

        if(M('userinfo')->field('uid')->where('utel='.$mobile.' and ustatus in(0,1) and otype=4')->find()) {
            sys_out_fail('手机号已经被注册了');
        }

        $code = M('userinfo')->field('uid,otype')->where(array('code' => $code))->find();
        if(!$code){

           sys_out_fail('推广人不存在');

        } else{
           
           if($code['otype'] == 4)
           {
                $acting  = M("UserinfoRelationship")->where(array('user_id' => $code['uid']))->find();
                $rela['parent_user_id'] = $acting['parent_user_id'];   //经纪人id
                $map['rid']             = $code['uid'];                //推广人id
           } else if($code['otype'] == 6)
           {
                $rela['parent_user_id'] = $code['uid'];                //经纪人id
           }
        }

        //判断是否已经有删除的
        $uid = M('userinfo')->where('utel = '.$mobile.' and ustatus = 2 and otype = 4')->getField('uid');

        if($uid){

            M("userinfo")->where(array('uid' => $uid))->delete();
            M('accountinfo')->where(array('uid' => $uid))->delete();
            M('bankinfo')->where(array('uid' => $uid))->delete();
            M('UserinfoRelationship')->where(array('user_id' => $uid))->delete();
            M("UserinfoOpen")->where(array('user_id' => $uid))->delete();
        }

        $userinfo             = M("userinfo");
        $accountinfo          = M("accountinfo");
        $UserinfoRelationship = M("UserinfoRelationship");
        $userinfo->startTrans();

        $map['username']    = $mobile;
        $map['upwd']        = md5($password);
        $map['utel']        = $mobile;
        $map['utime']       = time();
        $map['agenttype']   = 0;
        $map['otype']       = 4;
        $map['ustatus']     = 0;
        $map['usertype']    = 0;  //不是微信用户
        $map['wxtype']      = 1;  //微信还没注册
        $map['nickname']    = '操盘手'.$mobile.'';//用户昵称
        $map['reg_ip']      = get_client_ip();    //用户注册ip
        $result = $userinfo->add($map);
        
        $account['uid']     = $result;
        $account['gold']    = gold();
        $info = $accountinfo->add($account);

        //用户关系表
        $rela['user_id']    = $result;
        $rela['user_type']  = 4;;
        $ship = $UserinfoRelationship->add($rela);

        if($result && $info && $ship){

            $userinfo->commit();
            sys_out_success('注册成功');

        } else {

            $userinfo->rollback();
            sys_out_fail('注册失败');
        }
    }

    /**
     * 用户登陆
     * @author wang <admin>
     */
    public function login()
    {
        $mobile     = trim(I("post.mobile"));
        $password   = trim(I('post.password'));

        $post_array = array('mobile','password');
        sys_check_post($post_array);
           
        $where['utel']    = $mobile;
        $where['upwd']    = md5($password);
        $where['otype']   = 4;
        $field  = 'uid,username,utel,ustatus,code';
        $user   = M('userinfo')->field($field)->where($where)->find();

        if($user){
            
            $operateId = parent_user_id($user['uid'],2);
            if(!$operateId)
            {
                sys_out_fail('该用户还没有运营中心');
            }

            if($user['ustatus'] == 1){

                sys_out_fail('该用户帐号被冻结');
            }

            if($user['ustatus'] == 2)
            {
                sys_out_fail('用户不存在');
            }

            session('operateId',$operateId);
            sys_set_token($user);

            if(session('token')){

                $map['lastlog']         = time();
                $map['last_login_ip']   = get_client_ip();
                $map['token']           = session('token');

                if(M("userinfo")->where(array('uid' => session('user_id')))->save($map))
                {   
                    $data['username']   = $_SESSION['username'];
                    $data['token']      = $_SESSION['token'];
                    $data['mobile']     = $_SESSION['mobile'];
                    $data['operateId']  = $_SESSION['operateId'];
                    $data['operateUser']  = M('userinfo')->where(array('uid'=>$_SESSION['operateId']))->getField('s_domain_name');
                    $data['balance']    = M('accountinfo')->where(array('uid' => $_SESSION['user_id']))->getField('balance');

                    $data['is_code']    = empty($user['code']) ? 0 : 1;

                    $bank = M('bankinfo')->where(array('uid' => $_SESSION['user_id']))->getField('banknumber');
                    $data['is_bank']    = empty($bank) ? 0 : 1;

                    sys_out_success('登陆成功',$data);
                }


            } else {

                sys_out_fail('用户名或密码输入错误');
            }
             
        } else {

            sys_out_fail('用户名或密码输入错误');
        }
    }

    /**
     * 忘记密码
     * @author wang <admin>
    */
    public function outpwd()
    {
        
        $mobile     = trim(I('post.mobile'));
        $password   = trim(I('post.password'));
        $smscode    = trim(I('post.smscode'));

        $post_array = array('mobile','password','smscode');
        sys_check_post($post_array);
        if(!APP_DEBUG){
            if($smscode != $_SESSION['mobile_code']){

                sys_out_fail('短信验证码不正确');
            }
        }


        $map['utel']              = $mobile;
        $map['otype']             = 4;

        $user = M("userinfo")->field('ustatus')->where($map)->find();

        if($user)
        {
            if($user['ustatus'] == 1){

                sys_out_fail('用户被冻结');
            }

            if($user['ustatus'] == 2)
            {
                sys_out_fail('用户不存在');
            }

            $res = M('userinfo')->where($map)->setField('upwd',md5($password));

            if($res){

                sys_out_success('修改成功');

            } else{

                sys_out_fail('修改失败');
            }
        } else {

            sys_out_fail('用户名或密码输入错误');
        }
    }


    /**
     * @functionname: get_mobile_code
     * @author: wang
     * @description: 获取手机验证码 起点接口
     * @note:
     * @return array
     * @param string $mobile  手机号
     * @param int $mobile_code_time  手机验证码有效期，默认2*60
     */
    public function get_mobile_code($mobile = '', $mobile_code_time = 2)
    {

        sys_check_post_single('mobile');

        if (!preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
            sys_out_fail('手机号格式错误');

        //一分钟内不能重复获取
        if (time() - session('mobile_code_time') < 60 * 1)
            sys_out_fail('您获取验证码太频繁了，请稍后再获取！');

        //判断该手机号码是否还在有效期内, 120s
        if (($mobile == session('mobiles')) && (time() - session('mobile_code_time') < 60 * $mobile_code_time))
            sys_out_fail('该号码在1分钟内已经获取过验证码，可继续使用！');

        $res    = sms_qidian_send_code($mobile);

        if ($res['ret_code'] == 1)
        {
            session('mobile_code', $res['ret_msg']);
            session('mobile_code_time', time());
            session('mobiles', $mobile);

            $mObj   = M();
            $addArr = array(
                'mobile'        => $mobile,
                'mobile_code'   => $res['ret_msg'],
                'type'          => 1
            );
            $mObj->table('log_mobile_code')->add($addArr);

            sys_out_success('短信发送成功');
        }
        else
        {
            sys_out_fail($res['ret_msg']);
        }
    }




     /**
      * 短信验证码
      * @author wang <admin>
      */
    public function smsverify(){
         
        $mobile = trim(I('post.mobile'));

        sys_check_post_single('mobile');

        $this->get_mobile_code($mobile);
    }


    /**
     * 订单选择界面
     * @author wang <admin>
     */

    public function buyup()
    {

    	$user_id 	= $this->checkLogin();

      	$id 	    = trim(I('post.id'));
      	$ostyle     = trim(I('post.ostyle'));
      	$type 	    = trim(I('post.type'));


      	$post_array  = array('id','ostyle','type');
        sys_check_post($post_array);

      	$exis  	= M('option')->field('id')->where(array('id'=>$id))->find();
      	if(!$exis)
      	{
      		sys_out_fail('商品不存在');
      	}

      	$operateId = parent_user_id($user_id,2);    //已用户查找运营中心id

    	$field 	  = 'a.id,a.capital_key,a.capital_name,a.bp,a.sp,a.currency,b.Bond,b.number,b.CounterFee,b.capital_length';
        $option   = M('option a')->field($field)->join('wp_option_info as b on a.id = b.option_id')->where(array('a.id' => $id))->find();

        init_common_function();  //加载自定义配置文件

      	$currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($option['id']).'');

      	$rate 	  =  $currency['rate'];

      	$code 	  = M('currency')->field('currency_sign')->where(array('currency_code' => $currency['code']))->find();

      	$option['rate']  = $rate;
          
      	if($ostyle == 0){
            $option['Price'] 		= sprintf("%.".$option['capital_length']."f",$option['sp']);
      	} else {
            $option['Price'] 		= sprintf("%.".$option['capital_length']."f",$option['bp']);
      	}

        // $commission = M('OptionUserSpecial')->where(array('user_id' => $operateId,'option_id' => $option['id']))->getField('commission');

        $special = M('OptionUserSpecial')->field('platform_commission,commission')->where(array('user_id' => $operateId,'option_id' => $option['id']))->find();

        $option['baozheng'] 		= round($option['Bond'] * $rate,2);

        // $option['foreign_sum'] 		= $option['Bond'] + $option['CounterFee'] + $commission;
        // $option['rmb_sum'] 			= round(($option['Bond'] + $option['CounterFee'] + $commission) * $rate,2);

        // $option['CounterFee'] 		= ($option['CounterFee'] + $commission);

        $option['foreign_sum']      = $option['Bond'] + $special['platform_commission'] + $special['commission'];
        $option['rmb_sum']          = round(($option['Bond'] + $special['platform_commission'] + $special['commission']) * $rate,2);

        $option['CounterFee']       = ($special['platform_commission'] + $special['commission']);
        $option['shouxu']   		= round($option['CounterFee'] * $rate,2);   //交易综合费

        $option['currency_sign'] 	= $code['currency_sign'];  //外汇标志
        $option['currency_name']	= '1'.$currency['name'].' = '.$rate.'人民币';	  //外汇名称
        $option['chicang']			= '持仓至'.deal_time_end($option['id']).'自动平仓';

     	//触发止损
      	$transaction = M('OptionTransaction')->where(array('option_id' => $option['id']))->select();

	    $data['option'] 		= $option;
	    $data['transaction'] 	= $transaction;
	    $data['ostyle'] 		= $ostyle;
	    $data['type']  			= $type;

	    sys_out_success('',$data);
    }


    /**
     * 交易 下单
     * @author wang <admin>
     */

    public function transaction(){


    	$user_id 	 = $this->checkLogin();

       	$post_array  = array('hand','profit','loss','Bond','fee','foreign','heji_rmb','ostyle','id','type_two');
       	sys_check_post($post_array);


        $hand      = trim(I('post.hand'));      //手数

        $profit    = trim(I('post.profit'));    //止盈

        $loss      = trim(I('post.loss'));      //止损金额

        $Bond      = trim(I('post.Bond'));      //止损保证金

        $fee       = trim(I('post.fee'));       //交易综合费

        $foreign   = trim(I('post.foreign'));   //合计费用外汇

        $heji_rmb  = trim(I('post.heji_rmb'));  //合计费用人民币

        $ostyle    = trim(I('post.ostyle'));    //买涨买跌类型

        $pid       = trim(I('post.id'));        //产品id

        $type_two  = trim(I('post.type_two'));  //1 实盘交易 2模拟交易

        $accountinfo = M('accountinfo');
        $userinfo    = M('userinfo');


     	$agent_id = parent_user_id($user_id,2);    //已用户查找运营中心id

     	init_common_function();  //加载自定义配置文件


        $data = array();

        $accoun = $accountinfo->field('balance,frozen,gold')->where(array('uid' => $user_id))->find();
        $user   = $userinfo->where(array('uid' => $user_id))->find();

        //判断id是否存在或是否为休市状态
        $option = M('option')->where(array('id'=>$pid))->find();
        if ($option) {

            if(shijian($pid) == '休市中'){
                sys_out_fail('该产品已休市');
            }

            if ($option['global_flag'] == 0 || $option['flag'] == 0) {
                sys_out_fail('该产品已休市');
            }
            if ($option['sell_flag'] == 0) {
                sys_out_fail('产品即将休市');
            }


            //判断用户提交的数据
            $transaction = M('OptionTransaction')->where(array('option_id' => $pid))->select();
            $profitArr = array();
            $lossArr   = array();
            foreach ($transaction as $key => $value) {
                array_push($profitArr,$value['stop_profit']);
                array_push($lossArr,$value['Stop_loss']);
            }
            if(!in_array($profit,$profitArr) || !in_array($loss,$lossArr))
            {
                sys_out_fail('止盈或止损参数错误');
            }

            $optionInfo = M('OptionInfo')->where(array('option_id' => $pid))->find();
            $offset = array_search($loss,$lossArr);
            $offset = ($offset)+1;
            $Bonds  = round(($optionInfo['Bond'] * $offset) * $hand,2);
            if($Bond != $Bonds) {
                sys_out_fail('保证金有误');
            }

            $special = M('OptionUserSpecial')->field('platform_commission,commission')->where(array('user_id' => $agent_id,'option_id' => $pid))->find();
            $fees = round(($special['platform_commission'] + $special['commission'])  * $hand,2);
            if($fees != $fee) {
                sys_out_fail('手续费有误');
            }

            $foreigns = round(($Bonds + $fees),2);
            if($foreigns != $foreign) {
                sys_out_fail('金额有误');
            }

            $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($pid).'');  //汇率
            $rate =  $currency['rate'];
            $heji_rmbs = round($foreigns * $rate,2);
            if($heji_rmbs != $heji_rmb) {
                sys_out_fail('人民币金额有误');
            }

            if($ostyle == 0){
                $new_price  = $option['sp'];   //小数点位
                $rivalprice = $option['bp'];   //对手价点位
            } else {
                $new_price  = $option['bp'];   //小数点位
                $rivalprice = $option['sp'];   //对手价点位
            }

        } else {
            sys_out_fail('参数错误！你不能购买');
        }

        //交易手数限制
        $sysDate    = get_setting_config('find', 'SYSTEM_OPTION_NUMBER');
        $sys_date   = explode('|',$sysDate['datas']['sys_date']);

        //如果为实盘交易
        if($type_two == '1'){

            if($accoun['balance'] < $heji_rmb){

                sys_out_fail('余额不足请充值');
            }

            $acc = M("accountinfo")->where(array('uid' => $agent_id))->find();

            /*冻结资金阈值*/
            if($acc['frozen_threshold'] == 0)
            {
                sys_out_fail('购买失败，请联系相关客服');
            }
            if($acc['balance'] <= $acc['frozen_threshold'])
            {
                sys_out_fail('购买失败，请联系相关客服');
            }
            /*冻结资金阈值*/

            if($acc['balance'] < $profit){
                sys_out_fail('购买失败，请联系相关客服');
            }

            //交易手数限制
            if($sys_date[0] != 0) {

                $count = M("order")->where('uid = '.$user_id.' and pid = '.$pid.' and type = 1 and ostaus = 0')->count();
                $count = ($hand + $count);
                if($count > $sys_date[0]) {
                    sys_out_fail('持仓中的商品请不要超过'.$sys_date[0].'手');
                }
            } else {
                sys_out_fail('商品暂时无法交易，请联系客服咨询');
            }

            $order['type'] = '1';
        } else {

            //交易手数限制
            if($sys_date[1] != 0) {

                $count = M("order")->where('uid = '.$user_id.' and pid = '.$pid.' and type = 2 and ostaus = 0')->count();
                $count = ($hand + $count);
                if($count > $sys_date[1]) {
                    sys_out_fail('持仓中的商品请不要超过'.$sys_date[1].'手');
                }
            } else {
                sys_out_fail('商品暂时无法交易，请联系客服咨询');
            }

            if($accoun['gold'] < $heji_rmb){

                sys_out_fail('金币不足请联系客服人员');
            }

            $order['type'] = '2';
        }

        if($user['ustatus'] == '1') {

            sys_out_fail('你的用户已被冻结 请联系相关管理员!');
        }


        $order['uid']       = $user_id;
        $order['pid']       = $pid;
        $order['ostyle']    = $ostyle;          //0涨 1跌，
        $order['buytime']   = time();
        $order['ostaus']    = 0;                //0交易，1平仓
        $order['buyprice']  = $new_price;       //入仓价
        $order['sellprice'] = $rivalprice;       //平仓价
        $order['endprofit'] = $profit;          //止盈
        $order['endloss']   = $loss;            //止损
        $order['fee']       = $fee / $hand;     //交易综合费
        $order['orderno']   = time().mt_rand(); //订单号
        $order['Bond']      = $Bond / $hand;    //止损保证金
        $order['extension'] = 1;                //推广金额 1未领取  2已领取
        $a = array();
        for($i = 1; $i <= $hand; $i++){

            //添加订单
            $result = M('order')->add($order);
            array_push($a, $result);
            //添加订单日志

            $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($option['id']).'');  //汇率
            $rate =  $currency['rate'];

            $data['jno']     = time().mt_rand(); //日志编号
            $data['uid']     = $user_id;
            $data['jtype']   = '建仓';
            $data['jtime']   = time();  //操作时间
            $data['number']  = '1';

            $data['remarks'] = $option['capital_name'];

            if($type_two == '1'){
                $data['type']    = '1';                                             //真实交易
                $data['balance'] = $accoun['balance'] - ($heji_rmb / $hand) * $i;  //用户余额
            } else{
                $data['balance'] = $accoun['gold'] - ($heji_rmb / $hand) * $i;  //用户金币
                $data['type']    = '2';
            }

            $data['jusername']  = $user['username'];
            $data['jostyle']    = $ostyle;   //涨跌
            $data['juprice']    = $order['Bond'] * $rate;  //产品单价
            $data['jfee']       = $order['fee'] * $rate;  //手续费
            $data['jbuyprice']  = $new_price;    //进仓价
            $data['jaccess']    = '-'.$heji_rmb / $hand;  //出入金额
            $data['oid']        = $result;
            $journal = M('journal')->add($data);
        }

        if($result && $journal){

            if($type_two == '1'){
                //生成手续流水单
                foreach ($a as $key => $value) {
                    $money_flow = $accountinfo->where(array('uid' => $user_id))->setDec('balance',$heji_rmb/$hand);  //减去用户余额

                    if($money_flow) {
                        //用户资金流水表
                        $map['uid']      = $user_id;
                        $map['type']     = 1;
                        $map['oid']      = $value;
                        $map['note']     = '用户购买'.$option['capital_name'].'扣除['.$heji_rmb / $hand.']元';
                        $map['balance']  = $accountinfo->where(array('uid' => $user_id))->sum('balance');
                        $map['op_id']    = $user_id;
                        $map['dateline'] = time();
                        M("MoneyFlow")->add($map);
                    }

                    $order     = M('order')->where(array('oid' => $value))->find();     //查询订单

                    $currency  = C('SYSTEM_CURRENCY_TYPE.'.Transformation($order['pid']).'');

                    $money_rmb     = $order['fee']  * $currency['rate']; //转换人民币

                    $user = M('userinfo')->where(array('uid' => $order['uid']))->find();   //查询购买的用户

                    $one = M()->query("SELECT * FROM wp_userinfo WHERE uid = ".$user['rid']." AND unix_timestamp(NOW()) < utime+365*24*60*60;");

                    if($one){

                        $one_money   = $order['fee'] * (commission_rate('class_a') / 100);   //收益

                        $one_money_rmb = $money_rmb * (commission_rate('class_a') / 100);    //收益人民币

                        $one_class['order_id']     = $value;         //订单id
                        $one_class['user_id']      = $one[0]['uid']; //领取人id 0表示交易所
                        $one_class['profit']       = $one_money;     //佣金收益
                        $one_class['profit_rmb']   = $one_money_rmb; //佣金收益人民币
                        $one_class['fee_rmb']      = $money_rmb;     //手续费人民币
                        $one_class['create_time']  = time();         //创建时间
                        $one_class['status']       = 2;              //1已经发放  2未发放
                        $one_class['type']         = 1;              //1用户 2交易所 3运营中心  4 经纪人
                        $one_class['purchaser_id'] = $user_id; //购买人
                        M('FeeReceive')->add($one_class);

                        //二级
                        $two = M()->query("SELECT * FROM wp_userinfo WHERE uid = ".$one[0]['rid']." AND unix_timestamp(NOW()) < utime+365*24*60*60;");
                        if($two){

                            $two_money     = $order['fee'] * (commission_rate('class_b') / 100);

                            $two_money_rmb = $money_rmb * (commission_rate('class_b') / 100);    //收益人民币

                            $two_class['order_id']     = $value;       //订单id
                            $two_class['user_id']      = $two[0]['uid'];   //领取人id 0表示交易所
                            $two_class['profit']       = $two_money; //佣金收益
                            $two_class['profit_rmb']   = $two_money_rmb;     //手续费人民币
                            $two_class['fee_rmb']      = $money_rmb;     //手续费人民币
                            $two_class['create_time']  = time();        //创建时间
                            $two_class['status']       = 2;             //1已经发放  2未发放
                            $two_class['type']         = 1;             //1用户 2交易所 3运营中心  4 经纪人
                            $two_class['purchaser_id'] = $user_id;  //购买人
                            M('FeeReceive')->add($two_class);
                        }

                    }

                    //交易所
                    $parent_user_id['order_id']     = $value;       //订单id
                    $parent_user_id['user_id']      = 0;             //领取人id 0表示交易所
                    $parent_user_id['profit']       = M('OptionInfo')->where(array('option_id' => $order['pid']))->sum('CounterFee'); //佣金收益
                    $parent_user_id['profit_rmb']   = M('OptionInfo')->where(array('option_id' => $order['pid']))->sum('CounterFee') * $currency['rate'];
                    $parent_user_id['fee_rmb']      = $money_rmb;     //手续费人民币
                    $parent_user_id['create_time']  = time();        //创建时间
                    $parent_user_id['status']       = 1;             //1已经发放  2未发放
                    $parent_user_id['type']         = 2;             //1用户 2交易所 3运营中心  4 经纪人
                    $parent_user_id['purchaser_id'] = $user_id;  //购买人
                    M('FeeReceive')->add($parent_user_id);


                    //查找运营中心
                    $operats = $agent_id;

                    if($operats){

                        $operats_money = M('OptionUserSpecial')->where(array('option_id' => $order['pid'],'user_id' => $operats))->sum('commission') * $currency['rate'];

                        $operat['order_id']     = $value;       //订单id
                        $operat['user_id']      = $operats;      //领取人id 0表示交易所
                        $operat['profit']       = M('OptionUserSpecial')->where(array('option_id' => $order['pid'],'user_id' => $operats))->sum('commission');
                        $operat['profit_rmb']   = $operats_money;
                        $operat['fee_rmb']      = $money_rmb;     //手续费人民币
                        $operat['create_time']  = time();         //创建时间
                        $operat['status']       = 1;              //1已经发放  2未发放
                        $operat['type']         = 3;              //1用户 2交易所 3运营中心  4 经纪人
                        $operat['purchaser_id'] = $user_id; //购买人
                        M('FeeReceive')->add($operat);
                        $one_money_rmb = round($one_money_rmb,2);
                        $two_money_rmb = round($two_money_rmb,2);
                        $balance_money = round($operats_money - ($one_money_rmb + $two_money_rmb),2);
                        $operat_status = M('accountinfo')->where(array('uid' => $operats))->setInc('balance',$balance_money);
                        if($operat_status) {
                            //运营中心资金流水表
                            $operat_flow['uid']      = $operats;
                            $operat_flow['type']     = 5;
                            $operat_flow['oid']      = $value;
                            $operat_flow['note']     = '用户购买'.$option['capital_name'].'运营中心增加佣金['.$balance_money.']元';
                            $operat_flow['balance']  = $accountinfo->where(array('uid' => $operats))->sum('balance');
                            $operat_flow['op_id']    = $user_id;
                            $operat_flow['user_type']= 2;
                            $operat_flow['dateline'] = time();
                            M("MoneyFlow")->add($operat_flow);
                        }
                    }
                }

            } else {
                $accountinfo->where(array('uid' => $user_id))->setDec('gold',$heji_rmb);  //减去用户金币
            }

            if($accountinfo){

                sys_out_success('购买成功');

            } else {

				sys_out_fail('购买失败');
            }
        }
    }


    /**
     * 持仓记录
     * @author wang <admin>
     */

   	public function position(){

       	$post_array  = array('pid','type');
       	sys_check_post($post_array);

       	$pid  = trim(I('post.pid')); 
       	$type = trim(I('post.type'));


    	$user_id = $this->checkLogin();


    	init_common_function();  //加载自定义配置文件

       	$order  = M('order')->where(array('uid' => $user_id , 'pid' => $pid,'ostaus' => 0,'type' => $type))->select();

       	$currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($order[0]['pid']).''); //外汇定义

       	$rate = $currency['rate'];

       	$option = M('option a')->field('a.currency,a.Price,a.id,a.capital_key,a.bp,a.sp,b.*')->join('wp_option_info as b on a.id = b.option_id')->where(array('id' => $pid))->find();
       	$option['Price'] = sprintf("%.".$option['capital_length']."f",$option['Price']);
       	$option['new_pricetop'] = sprintf("%.".$option['capital_length']."f",$option['bp']);   //小数点位
       	$option['new_priceup'] = sprintf("%.".$option['capital_length']."f",$option['sp']);   //小数点位
       
       	foreach($order as &$val){
            
            $val['buyprice']  = sprintf("%.".$option['capital_length']."f",$val['buyprice']);
            $val['endprofit'] = $val['endprofit'].' '.$currency['name'];
            $val['endloss']   = $val['endloss'].' '.$currency['name'];
            $val['RMB']       = round($val['ploss'] * $rate,2);   //人民币
       	}

   		$sum['type']      = $currency['name'];   //外汇类型
        //持仓总收益
        $sum['sum'] = M('order')->where(array('uid' => $user_id, 'pid' => $pid,'ostaus' => 0))->sum('ploss');
        $sum['sum_rmb'] = $sum['sum'] * $rate;

        $data['option'] = $option;
        $data['order']	= $order;
        $data['sum']	= $sum;

        sys_out_success('',$data);
   	}


    /**
     * 持仓请求数据
     * @author wang <admin>
     */
   	public function PositionData(){

       	$post_array  = array('pid','type');
       	sys_check_post($post_array);

       	$pid  = trim(I('post.pid')); 
       	$type = trim(I('post.type'));


    	$user_id = $this->checkLogin();

    	init_common_function();  //加载自定义配置文件

        $order  = M('order')->where(array('pid' => $pid,'ostaus' => 0 ,'uid' => $user_id,'type' => $type))->select();

        $option = M('option a')->field('a.*,b.*')->join('wp_option_info as b on a.id = b.option_id')->where(array('id' => $pid))->find();

        $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($option['id']).''); //外汇定义

        $rate = $currency['rate'];

        foreach($order as &$val){

            $val['ploss_rmb']    = round($val['ploss'] * $rate,2);

            $val['new_pricetop'] = sprintf("%.".$option['capital_length']."f",$option['bp']);   //小数点位

            $val['new_priceup'] = sprintf("%.".$option['capital_length']."f",$option['sp']);   //小数点位
        }

        //持仓总收益
    	$sum['sum'] = M('order')->where(array('pid' => $pid,'ostaus' => 0,'uid' => $user_id, 'type' => $type))->sum('ploss');
        $sum['sum_rmb'] 	= sprintf('%.2f',($val['sum'] * $rate));

        $data['order'] 		= $order;
        $data['sum']	 	= $sum;

        if($order) {

         	sys_out_success('',$data);

        } else {

        	sys_out_fail('没有持仓的商品');
        }
   	}


	/**
     * 单个平仓
     * @author wang <admin>
     */
   	public function Manual(){

       	$post_array  = array('oid','type');
       	sys_check_post($post_array);

		$user_id 	= $this->checkLogin();

		$operateId = parent_user_id($user_id,2);    //已用户查找运营中心id

    	init_common_function();  //加载自定义配置文件

        $Order       = M('order');
        $Accountinfo = M('accountinfo');
        $userinfo    = M('userinfo');
        $option      = M('option');
 
        $oid       = trim(I('post.oid'));
        $type      = trim(I('post.type'));
        

        $true = $Order->field('oid')->where(array('oid' => $oid,'ostaus' => 1))->find();
        $return = array();

        if($true){
            sys_out_fail('系统已经自动平仓了');
        }


        $orderInfo = $Order->field('pid,ostyle,sellprice,buyprice')->where(array('oid' => $oid,'uid' => $user_id,'type' => $type, 'ostaus' => 0))->find();

        $optionInfo = $option->field('wave,capital_dot_length')->where(array('id' => $orderInfo['pid']))->find();

        $Order->startTrans(); //开启事务

        $data['selltime']  	= time();
        $data['ostaus']    	= 1;
        $data['display'] 	= 1;
        $data['auto']    	= 1;


        if ($orderInfo['ostyle'] == 0) {
            $ploss = (round($orderInfo['sellprice']  -  $orderInfo['buyprice'],3) * $optionInfo['wave']) * $optionInfo['capital_dot_length'];
            $data['sellprice'] 	= $orderInfo['sellprice'];
            $data['ploss'] 		= $ploss;
        } else {
            $ploss = (round($orderInfo['buyprice']  -  $orderInfo['sellprice'],3) * $optionInfo['wave']) * $optionInfo['capital_dot_length'];
            $data['sellprice'] 	= $orderInfo['sellprice'];
            $data['ploss'] 		= $ploss;
        }

        $ostaus = $Order->where(array('oid' => $oid, 'ostaus' => 0 ,'uid' => $user_id ,'type' => $type))->save($data);

      	if($ostaus)
      	{
            $order   	= $Order->field('pid,ploss,Bond,sellprice,oid')->where(array('oid' => $oid,'uid' => $user_id,'type' => $type))->find();

            $currency 	= C('SYSTEM_CURRENCY_TYPE.'.Transformation($order['pid']).'');//外汇定义

            $rate 		= $currency['rate'];
              
            $yingkui 	= $order['ploss'] * $rate;

            $money   	= ($order['Bond'] + $order['ploss']) * $rate;  //转换人民币
                
         	if($type == 1){

                //设置运营中心余额 (盈亏)
                $ex_yingkui = $yingkui < 0 ? (abs($yingkui)) : -$yingkui;

                $Accountinfo->where(array('uid' => $operateId))->setInc('balance',$ex_yingkui);

                if($yingkui >= 0) {

                   $Accountinfo->where(array('uid' => $user_id))->setInc('income_total',abs($yingkui));

                } else {

                   $Accountinfo->where(array('uid' => $user_id))->setInc('loss_total',abs($yingkui));
                }
                
                $account = $Accountinfo->where(array('uid' => $user_id))->setInc('balance',$money);
                $gold 	 = $Accountinfo->where(array('uid' => $user_id))->getField('balance');
                       
         	} else{
                        
                    $account = $Accountinfo->where(array('uid' => $user_id))->setInc('gold',$money);
                    $gold = $Accountinfo->where(array('uid' => $user_id))->getField('gold');
                 }

          	$bond    = ($order['Bond'] + $order['ploss']) * $rate;  //出入金额
          	$ploss   = $order['ploss'] * $rate;  //盈亏金额 
          	$jstate  = $order['ploss'] > 0 ? 1:0;

          	$select = "INSERT INTO wp_journal 
                    (
                    `jno`,`jtype`,
                     `uid`,`jtime`,
                     `number`,`remarks`,
                     `type`,`balance`,
                     `jstate`,`jusername`,
                     `jostyle`,`juprice`,
                     `jfee`,`jbuyprice`,
                     `jsellprice`,`jaccess`,
                     `jploss`,`oid`,`auto`
                    )
                   	SELECT 
                          ".time().mt_rand().",
                          '平仓', 
                           uid,
                           ".time().",
                           number,
                           remarks,
                           type,
                           ".$gold.",
                           ".$jstate.",
                           jusername,
                           jostyle,
                           juprice,
                           jfee,
                           jbuyprice,
                           ".$order['sellprice'].",
                           ".$bond.",
                           ".$ploss.",
                           oid,
                           1
                           FROM wp_journal 
                    where oid = ".$order['oid']." ";

          	M()->query($select);
          	if($type == 1){

              	$id = M()->query('select last_insert_id() as last_insert_id');
              	$name = M('journal')->field('remarks')->where(array('id' => $id[0]['last_insert_id']))->find();
              //用户资金流水表
              $map['uid']      = $user_id;
              $map['type']     = 2;
              $map['oid']      = $id[0]['last_insert_id'];
              $map['note']     = '用户对'.$name['remarks'].'进行平仓增加['.$bond.']元';
              $map['balance']  = $gold;
              $map['op_id']    = $user_id;
              $map['dateline'] = time();
              M("MoneyFlow")->add($map);

              //运营中心资金流水表
              $operate_loss = $ex_yingkui >= 0 ? '增加['.$ex_yingkui.']' : '扣除['.$ex_yingkui.']';
              $operat_flow['uid']      = $operateId;
              $operat_flow['type']     = 2;
              $operat_flow['oid']      = $id[0]['last_insert_id'];
              $operat_flow['note']     = '用户对'.$name['remarks'].'进行平仓'.$operate_loss.'元';
              $operat_flow['balance']  = M('accountinfo')->where('uid='.$operateId)->sum('balance');
              $operat_flow['op_id']    = $user_id;
              $operat_flow['user_type']= 2;
              $operat_flow['dateline'] = time();
              M("MoneyFlow")->add($operat_flow);
              }
        }
            if($ostaus && $account){

                $Order->commit();
                sys_out_success('平仓成功');
            } else {

                $Order->rollback();
                sys_out_fail('平仓失败');
            }
   }


    /**
     * 一键平仓
     * @author wang <admin>
     */
    
    public function All(){
        
       	$post_array  = array('pid','oid','type');
       	sys_check_post($post_array);


		$user_id 	= $this->checkLogin();

		$operateId = parent_user_id($user_id,2);    //已用户查找运营中心id

    	init_common_function();  //加载自定义配置文件

        $Order       = M('order');
        $Accountinfo = M('accountinfo');
        $userinfo    = M('userinfo');
        $option      = M('option');
        $journal     = M('journal');
    
        $id           = trim(I('post.oid'));
        $pid          = trim(I('post.pid'));
        $type         = trim(I('post.type'));    //1实盘 2虚拟

        $orderInfo = $Order->field('ostyle,buyprice,sellprice,oid,pid')->where('oid in('.$id.') and uid = '.$user_id.' and type = '.$type.' and ostaus = 0 and pid = '.$pid.'')->select();

        $optionInfo = $option->field('wave,capital_dot_length')->where(array('id' => $pid))->find();
            
        $data['selltime']  	= time();
        $data['ostaus']    	= '1';
        $data['display'] 	= 1;
        $data['auto']    	= 1;
            
        $Order->startTrans();

        $return = array();
        $true 	= $Order->field('oid')->where('oid in('.$id.') and pid = '.$pid.' and ostaus = 1')->select();

        if($true){
            sys_out_fail('系统已经自动平仓了');
        }


        foreach ($orderInfo as $key => $value) {
            if ($value['ostyle'] == 0) {
               $ploss = (round($value['sellprice'] - $value['buyprice'],3) * $optionInfo['wave']) * $optionInfo['capital_dot_length'];
               $data['sellprice'] = $value['sellprice'];
               $data['ploss'] = $ploss;
            } else {
               $ploss = (round($value['buyprice'] - $value['sellprice'],3) * $optionInfo['wave']) * $optionInfo['capital_dot_length'];
               $data['sellprice'] = $value['sellprice'];
               $data['ploss'] = $ploss;
            }

            $ostaus_top  = $Order->where( 'pid = '.$pid.' and ostaus = 0 and uid = '.$user_id.' and type = '.$type.' and oid = '.$value['oid'].'')->save($data);
        }

            
        $order   	= $Order->where('pid = '.$pid.' and uid = '.$user_id.' and type = '.$type.' and oid in('.$id.')')->select();

        $currency 	= C('SYSTEM_CURRENCY_TYPE.'.Transformation($order[0]['pid']).'');//外汇定义
        $rate 		= $currency['rate'];

        $money 		= 0;

        foreach ($order as $val) {

            if(!$Order->where(array('oid' => $val['oid'],'ostaus' => 1,'display' => 1,'auto' => 1))->find())
            {
                return false;
            }

            $yingkui = $val['ploss'] * $rate;   //盈亏
            $money   = ($val['Bond'] + $val['ploss']) * $rate;  //转换人民币

         	if($type == '1'){
                                    
              	$ex_yingkui = $yingkui < 0 ? (abs($yingkui)) : -$yingkui;
             
              	$Accountinfo->where(array('uid' => $operateId))->setInc('balance',$ex_yingkui);
              	if($yingkui >= 0) {
                  $Accountinfo->where(array('uid' => $user_id))->setInc('income_total',abs($yingkui));
              	} else {
                  $Accountinfo->where(array('uid' => $user_id))->setInc('loss_total',abs($yingkui)); 
              	}
              	$account 	= $Accountinfo->where(array('uid' => $user_id))->setInc('balance',$money);
              	$gold 		= $Accountinfo->where(array('uid' => $user_id))->getField('balance');
                  
            } else{

                  $account 	= $Accountinfo->where(array('uid' => $user_id))->setInc('gold',$money);
                  $gold 	= $Accountinfo->where(array('uid' => $user_id))->getField('gold');
             }
                   
            //生成订单信息
          	$bond    = ($val['Bond'] + $val['ploss']) * $rate;  //出入金额
          	$ploss   = $val['ploss'] * $rate;  //盈亏金额
         	$jstate  = $val['ploss'] > 0 ? 1:0;

          	$select = "INSERT INTO wp_journal 
	                    (
	                    `jno`,`jtype`,
	                     `uid`,`jtime`,
	                     `number`,`remarks`,
	                     `type`,`balance`,
	                     `jstate`,`jusername`,
	                     `jostyle`,`juprice`,
	                     `jfee`,`jbuyprice`,
	                     `jsellprice`,`jaccess`,
	                     `jploss`,`oid`,`auto`
	                    )
                       SELECT
                              ".time().mt_rand().",
                              '平仓',
                               uid,
                               ".time().",
                               number,
                               remarks,
                               type,
                               ".$gold.",
                               ".$jstate.",
                               jusername,
                               jostyle,
                               juprice,
                               jfee,
                               jbuyprice,
                               ".$val['sellprice'].",
                               ".$bond.",
                               ".$ploss.",
                               oid,
                               1
                               FROM wp_journal
                        where oid = ".$val['oid']." ";

          		M()->query($select);
              	if($type == 1) {
                  $id   = M()->query('select last_insert_id() as last_insert_id');
                  $name = M('journal')->field('remarks')->where(array('id' => $id[0]['last_insert_id']))->find();
                  $map['uid']      = $user_id;
                  $map['type']     = 2;
                  $map['oid']      = $id[0]['last_insert_id'];
                  $map['note']     = '用户对'.$name['remarks'].'进行平仓增加['.$bond.']元';
                  $map['balance']  = $gold;
                  $map['op_id']    = $user_id;
                  $map['dateline'] = time();
                  M("MoneyFlow")->add($map);

                  //运营中心资金流水表
                  $operate_loss = $ex_yingkui >= 0 ? '增加['.$ex_yingkui.']' : '扣除['.$ex_yingkui.']';
                  $operat_flow['uid']      = $operateId;
                  $operat_flow['type']     = 2;
                  $operat_flow['oid']      = $id[0]['last_insert_id'];
                  $operat_flow['note']     = '用户对'.$name['remarks'].'进行平仓'.$operate_loss.'元';
                  $operat_flow['balance']  = M('accountinfo')->where('uid='.$operateId)->sum('balance');
                  $operat_flow['op_id']    = $user_id;
                  $operat_flow['user_type']= 2;
                  $operat_flow['dateline'] = time();
                  M("MoneyFlow")->add($operat_flow);
              	}
            }

            if($ostaus_top && $account){

                $Order->commit();
                sys_out_success('平仓成功');

            } else {

             	$Order->rollback();
             	sys_out_fail('平仓失败');
            }           
    }
   

	/**
	 * 结算
	 * @author wang <admin>
	*/
  	public function settlement(){

       	$post_array  = array('pid','type');
       	sys_check_post($post_array);


		$user_id 	= $this->checkLogin();

       	init_common_function();  //加载自定义配置文件

       	$pid  = trim(I('post.pid'));
       	$type = trim(I('post.type'));

        $p    = trim(I('post.p'));

        $p    = !empty($p) ? $p : 1;

       	$map['a.uid'] 		= $user_id;
       	$map['a.pid'] 		= $pid;
       	$map['a.ostaus'] 	= 1;
       	$map['a.type'] 		= $type;
       	$map['b.jtype'] 	= '平仓';
       	$map['b.uid'] 		= $user_id;

       	$count  = M('order a')->join('wp_journal as b on a.oid = b.oid')->join('wp_option_info as c on a.pid = c.option_id')->where($map)->count();

        $pagecount 	= 10;
        $Page       = new \Think\Page($count,$pagecount);// 实例化分页类 传入总记录数和每页显示的记录数

       	$order  = M('order a')->field('a.*,b.jploss,c.capital_length')->join('wp_journal as b on a.oid = b.oid')->join('wp_option_info as c on a.pid = c.option_id')->where($map)->order('a.selltime desc')->page($p,$pagecount)->select();

       	$currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($order[0]['pid']).'');//外汇定义
       
       	foreach($order as &$val){

            $val['endprofit'] = $val['endprofit'].' '.$currency['name']; //止盈 外汇
            $val['endloss']   = $val['endloss'].' '.$currency['name'];   //止损 外汇
            $val['buyprice']  = sprintf("%.".$val['capital_length']."f",$val['buyprice']);  //买入价格
            $val['sellprice'] = sprintf("%.".$val['capital_length']."f",$val['sellprice']); //卖出价格
            $val['ploss_rmb'] = round($val['jploss'],2);
            $val['color']     = $val['ploss'] >= 0 ? '#DA2F34' : '#539B53';
            $val['selltime']     = date('Y-m-d H:i:s',$val['selltime']);
       	}

	   	$data = array();

	   	$data['type']  = $type;
	   	$data['pid']   = $pid;
	   	$data['order'] = $order;
        $data['p']     = $p+1;

	   	if($order)
	   	{
	   		sys_out_success('',$data);

	   	} else {

	   		sys_out_fail('没有数据');
	   	}
   	}

    /**
     * 新闻
     * @author wang
     */
    public function news()
    {
        $arr = file_get_contents("http://m.jin10.com/flash?maxId=0");

        $arr = json_decode($arr);
  
        $arr = array_slice($arr,0,25);  //分割数组
        
        foreach ($arr as $key => $value) {

                 $lista=explode("#", $value);

                 $time=substr($lista[2], 11);
                 
                 if(strlen($time)<=8){

                    $a[$key]['time']=$time;

                    $a[$key]['content'] = preg_replace("/<img.+?\/>/", "", $lista[3]);
                      
                    $a[$key]['url']=$lista[4];
                 }
        }

        $this->assign('a',$a);
        $this->display();
    }



    /**
     * 获取个人信息
     * @author wang
     */
    public function getPrice()
    {

        $user_id    = $this->checkLogin();

        $userObj    = M('accountinfo');

        $data       = $userObj->field('balance,gold')->where(array('uid' => $user_id))->find();

        $userinfo   = M('userinfo')->field('ustatus')->where(array('uid' => $user_id))->find();

        $data['ustatus'] = $userinfo['ustatus'];

        if(!$data)
        {
            sys_out_fail('没有数据');
        } else {
            sys_out_success('',$data);
        }
    }


    /**
     * 提现申请
     * @author wang <admin>
     */
    public function withdraw(){

        $user_id    = $this->checkLogin();

        $balance    = M('accountinfo')->where(array('uid' => $user_id))->getField('balance');

        $bank       = M('bankinfo')->where(array('uid' => $user_id))->getField('bankname');


        $data['bankname'] = $bank;

        $data['balance'] = $balance;

        sys_out_success('',$data);
    }

    /**
     * 提现审核
     * @author wang <admin>
     */

    public function withdraw_check(){

        $post_array  = array('amount','banks');
        sys_check_post($post_array);

        $user_id    = $this->checkLogin();


        $data = array();
        $amount = trim(I('post.amount')); //提现金额
        $banks  = trim(I('post.banks'));  //提现银行

        if(empty($amount)){

            sys_out_fail('提现金额不能为空');
        }

        if($amount <= 0){

            sys_out_fail('请输入正确的提现金额');
        }

        if(!is_numeric($amount)){

            sys_out_fail('请输入金额');
        }

        if(empty($banks)){

            sys_out_fail('银行名称不能为空');
        }

        $account = M('accountinfo')->where(array('uid' => $user_id))->find();
        $user    = M('userinfo')->where(array('uid' => $user_id))->find();
        if($account['balance'] < $amount){

            sys_out_fail('余额不足');
        }

        $data['bptype']     = '普通会员申请提现';
        $data['bptime']     = time();               //操作时间
        $data['bpprice']    = $amount;              //提现金额
        $data['uid']        = $user_id;             //用户id
        $data['isverified'] = 0;                    //0未通过
        $data['balanceno']  = $this->number();      //订单编号
        $data['shibpprice'] = $account['balance'];  //用户余额
        $data['b_type']     = 2;                    //流水类型，1充值，2提现
        $data['status']     = 0;                    //0待处理  1完成

        $res = M('balance')->add($data);
        if($res){

            M("accountinfo")->where(array('uid' => $user_id))->setDec('balance',$amount);
            M("accountinfo")->where(array('uid' => $user_id))->setInc('money_total',$amount);

            //添加出入金流动表
            $map['uid']      = $user_id;
            $map['type']     = 3;
            $map['oid']      = $res;
            $map['note']     = '用户申请提现扣除['.$amount.']元';
            $map['balance']  = M('accountinfo')->where(array('uid' => $user_id))->sum('balance');
            $map['op_id']    = $user_id;
            $map['dateline'] = time();
            M("MoneyFlow")->add($map);

            sys_out_success('申请提现成功');

        } else{
            sys_out_fail('申请提现失败');
        }
    }


    /**
     * 提现记录
     * @author wang <admin>
     */

    public function record(){

        $user_id    = $this->checkLogin();

        $record = M('balance')->field('bptime,isverified,status,cltime,bpprice')->where(array('uid' => $user_id,'b_type' => 2))->select();

        foreach ($record as $key => $value) {
            
            $record[$key]['bptime'] = date('Y-m-d H:i:s',$value['bptime']);

            if(!empty($value['cltime']))
            {
                if($value['isverified'] == 0 && $value['status'] == 0)
                {
                     $record[$key]['status'] = '未通过';

                } else {    

                    $record[$key]['status'] = '已通过';
                }
            } else {

                $record[$key]['status'] = '已提交';
            }
        }

        if($record)
        {
            sys_out_success('',$record);
        } else {

            sys_out_fail('暂无申请记录');
        }
    }


    /**
     * 绑定银行卡
     * @author wang <admin>
     */

    public function banks(){

        $user_id    = $this->checkLogin();

        $bank       = M('bankinfo')->where(array('uid' => $user_id))->find();
        
        $bank['province_name']  = M('city')->where(array('id' => $bank['province']))->getField('joinname');

        $bank['city_name']      = M('city')->where(array('id' => $bank['city']))->getField('name');

        $data['bank'] = $bank;  

        sys_out_success('',$data);
    }


    /**
     * 绑定银行卡或实名认证
     * @author wang <admin>
     */
    public function bankBinding(){

        $data = array();

        if (IS_AJAX) {

            $post_array  = array('j_name','Card','j_bankPhone','bankName','province','city','branch','j_bankNo','j_bankNoNote');
            sys_check_post($post_array);

            $user_id    = $this->checkLogin();


            $j_name       = trim(I('post.j_name'));  //姓名
            $Card         = trim(I('post.Card'));   // 身份证号码
            $j_bankPhone  = trim(I('post.j_bankPhone')); //银行预留手机号
            $bankName     = trim(I('post.bankName'));  //银行名称
            $province     = trim(I('post.province'));  //开户所在省
            $city         = trim(I('post.city'));  //开户所在市
            $branch       = trim(I('post.branch'));    //支行名称
            $j_bankNo     = trim(I('post.j_bankNo'));  //银行卡号码
            $j_bankNoNote = trim(I('post.j_bankNoNote'));  //再次确认银行卡号码

           if (empty($j_name)) {
               sys_out_fail('持卡人不能为空');
           }

           if (is_numeric($j_name) || mb_strlen($j_name) > 15) {

               sys_out_fail('持卡人填写不正确');
           }

           if(empty($Card)) {

               sys_out_fail('身份证号码不能为空');
           }

          if(!preg_match("/(^\d{15}$)|(^\d{17}([0-9]|X)$)/",$Card)) {

               sys_out_fail('身份证号码填写不正确');
           }

           if (empty($j_bankPhone)) {

               sys_out_fail('银行预留手机号不能为空');
           }

           if (!preg_match('/^1\d{10}$/', $j_bankPhone)) {

               sys_out_fail('手机号填写错误');
           }

           if (empty($bankName)) {

               sys_out_fail('银行名称不能为空');
           }

           if (empty($province)) {

               sys_out_fail('请填写开户所在省');
           }

           if (empty($city)) {

               sys_out_fail('请填写开户所在市');
           }

           if (empty($branch)) {

               sys_out_fail('支行名称不能为空');
           }

           if (empty($j_bankNo) || empty($j_bankNoNote)) {

               sys_out_fail('银行卡号不能为空');

           }

           if (!is_numeric($j_bankNo) || !is_numeric($j_bankNoNote)) {

               sys_out_fail('银行卡号填写不正确');
           }

           if($j_bankNo != $j_bankNoNote) {

               sys_out_fail('银行卡号填写不一致');
           }


            $data['uid']        = $user_id;
            $data['busername']  = $j_name;
            $data['bankname']   = $bankName;
            $data['banknumber'] = $j_bankNo;
            $data['branch']     = $branch;
            $data['tel']        = $j_bankPhone;
            $data['card']       = $Card;
            $data['province']   = $province;
            $data['city']       = $city;

            $bankinfoObj = M('bankinfo');
            $is_exist = $bankinfoObj->field('busername,bankname,banknumber,branch,tel')->where(array('uid' => $data['uid']))->find();
            if ($is_exist) {//若存在，更新
                if($is_exist['busername']==$data['busername'] && $is_exist['bankname']==$data['bankname'] && $is_exist['banknumber']==$data['banknumber']&&$is_exist['branch']==$data['branch']&&$is_exist['tel']==$data['tel']){
                    $bank=1;//提交的数据和原始数据一致，则不更改数据库
                }else{
                    $bank = $bankinfoObj->where(array('uid' => $data['uid']))->save($data);
                }
            } else {//不存在则添加
                $bank = $bankinfoObj->add($data);
            }

            if ($bank) {
                sys_out_success('绑定成功');
            } else {
                sys_out_fail('绑定失败');
            }
        }
        sys_out_fail('您访问的页面不存在');
    }


    /**
     * 资金明细
     * @author wang <admin>
     */
    public function capital(){

        $user_id    = $this->checkLogin();

        $p          = trim(I('post.p'));

        $p          = !empty($p) ? $p : 1;

        $count      = M("MoneyFlow")->where(array('uid' => $user_id))->count();

        $pagecount  = 10;
        $Page       = new \Think\Page($count,$pagecount);

        $flow       = M("MoneyFlow")->where(array('uid' => $user_id))->field('note,dateline')->order('dateline desc')->page($p,$pagecount)->select();

        foreach ($flow as $key => $value) {

            $flow[$key]['account'] = substr($value['note'],strrpos($value['note'],'[')+1);
            $flow[$key]['account'] = preg_replace("/]/", "",$flow[$key]['account']);
            $note  = explode('[',$flow[$key]['note']);
            $flow[$key]['note']     = $note[0];
            $flow[$key]['dateline'] = date('Y-m-d H:i:s',$value['dateline']); 
        }

        $data['flow'] = $flow;
        $data['p']    = $p+1;

        if(!$flow)
        {
            sys_out_fail('没有数据');
        } else {
            sys_out_success('',$data);
        }
    }


    /**
     * 模拟明细
     * @author wang <admin>
     */
    public function simulation(){

        $user_id    = $this->checkLogin();

        $p          = trim(I('post.p'));

        $p          = !empty($p) ? $p : 1;

        $count      = M('journal')->where(array('uid' => $user_id, 'type' => 2))->count();

        $pagecount  = 10;

        $Page       = new \Think\Page($count,$pagecount);

        $journal = M('journal')->field('jtime,remarks,jfee,juprice,jploss,jtype')->where(array('uid' => $user_id, 'type' => 2))->order('jtime desc')->page($p,$pagecount)->select();

        foreach ($journal as $key => $value) {
            
            $journal[$key]['jtime'] = date('Y-m-d H:i:s',$value['jtime']);
        }

        $data['journal'] = $journal;
        $data['p']       = $p+1;

        if(!$journal)
        {
            sys_out_fail('没有数据');
        } else {

            sys_out_success('',$data);
        }
    }


     /**
      * 确认推广
      * @author wang <admin>
      */
    public function ExtensionIs(){

        $user_id = $this->checkLogin();

        $map    = array();

        $is_code    = M('userinfo')->field('code')->where(array('uid' => $user_id))->find();
        $extension  = M('extension')->field('user_id')->where(array('user_id' => $user_id))->find();

        if(!empty($is_code['code']) && isset($extension)){

            sys_out_fail('你已经是推广员');

        } else {

            $code   = generate_code(4);

            $res    = M('userinfo')->where(array('uid' => $user_id))->setField('code',$code);

            $data['user_id']        = $user_id;
            $data['money']          = 0;
            $data['create_time']    = time();
            $re = M('extension')->add($data);
            if($res && $re){

                sys_out_success('推广成功');
            } else {
                sys_out_fail('推广失败');
            }
        }
    }


    /**
     * 推广赚钱
     * @author wang <admin>
     */

    public function extension(){

        $user_id    = $this->checkLogin();

        $dataArr    = array();

        $user = M('userinfo')->field('code,uid')->where(array('uid' => $user_id))->find();

        if(empty($user['code']))
        {
            sys_out_fail('你还不是推广员');
        }

        $agent_id    = parent_user_id($user_id,2);

        $s_domain    = M('userinfo')->where(array('uid' => $agent_id,'otype' => 5))->getField('s_domain');
        $url         = 'http://'.$s_domain.'.'.SYSTEM_DOMAIN.'/?code='.$user['code'];

        //一级
        $extension_on = "select * from wp_userinfo where unix_timestamp(NOW()) < utime+365*24*60*60 and rid = ".$user_id." ";

        $extension_one = M()->query($extension_on);

        $summm   = 0;
        $sum_two = 0;
        foreach ($extension_one as $value) {

            if(M('FeeReceive')->field('id')->where(array('purchaser_id' => $value['uid']))->find())  //交易用户
                $summm+=1;

            //二级
            $extension_tw = "select * from wp_userinfo where unix_timestamp(NOW()) < utime+365*24*60*60 and rid = ".$value['uid']." ";
            $extension_two = M()->query($extension_tw);

            if($extension_two){

                foreach ($extension_two as $value_two) {

                    if(M('FeeReceive')->field('id')->where(array('purchaser_id' => $value_two['uid']))->find())
                        $sum_two+=1;
                }
            }
        }

        //佣金结算统计
        $dataArr['RightMoney'] = M('FeeReceive')->where(array('user_id' => $user_id,'status' => 1))->sum('profit_rmb');
        $dataArr['WrongMoney'] = M('FeeReceive')->where(array('user_id' => $user_id,'status' => 2))->sum('profit_rmb');

        //佣金订单统计
        $dataArr['RightCount'] = M('FeeReceive')->where(array('user_id' => $user_id,'status' => 1))->count();
        $dataArr['WrongCount'] = M('FeeReceive')->where(array('user_id' => $user_id,'status' => 2))->count();


        $extension   = M('extension')->where(array('user_id' => $user_id))->find(); //可提佣金
        $count       = count($extension_one) + count($extension_two);               //我的用户
        $order_count = $summm+$sum_two;                                             //交易的用户

        $data['money']          = $extension['money'];
        $data['user_count']     = $count;
        $data['order_count']    = $order_count;
        $data['dataArr']        = $dataArr;
        $data['url']            = $url;
        $data['code']           = $user['code'];
        $data['one_rate']       = commission_rate('class_a');
        $data['two_rate']       = commission_rate('class_b');

        sys_out_success('',$data);

    }


    /**
     * 提取佣金
     * @author wang <admin>
     */

    public function Commission(){

        sys_check_post_single('money');

        $user_id            = $this->checkLogin();

        $extension_money    = M('extension')->where(array('user_id' => $user_id))->getField('money'); //可提佣金

        $money              = I('post.money'); //提取金额

        if(trim($money) > $extension_money){

            sys_out_fail('余额不足');
        }

        if(trim($money) < 100){

            sys_out_fail('提现金额不能小于100元');
        }

        $result = M('accountinfo')->where(array('uid' => $user_id))->setInc('balance',$money);

        if($result){

            //用户佣金出入金额
            $map['user_id']     = $user_id;
            $map['account']     = $money;
            $map['type']        = 1;
            $map['create_time'] = time();
            $journal = M("UserJournal")->add($map);
            $extens  = M("extension")->where(array('user_id' => $user_id))->setDec('money',$money);
            if($journal && $extens) {

                $where['uid']       = $user_id;
                $where['type']      = 5;
                $where['oid']       = $journal;
                $where['note']      = '用户佣金转入余额['.$money.']元';
                $where['balance']   = M('accountinfo')->where(array('uid' => $user_id))->sum('balance');
                $where['op_id']     = $user_id;
                $where['dateline']  = time();
                M("MoneyFlow")->add($where);

                sys_out_success('提取金额成功,页面正在跳转');
            }
        } else {

            sys_out_fail('提取金额失败');
        }
    }


    /**
     * 我的用户
     * @author wang <admin>
     */

    public function MyUser(){

        $user_id         = $this->checkLogin();

        $optionIdArr     = array();
        $optionIdArr_two = array();

        //查询一级用户
        $user_one = M("userinfo")->where(array('rid' => $user_id))->select();
        foreach ($user_one as $key => $value) {

            array_push($optionIdArr,$value['uid']);
        }

        $one_id = implode(',',$optionIdArr);
        $water  = M()->query("select a.create_time,a.purchaser_id,a.status,a.type,a.profit_rmb as profit_rmb,b.*,d.capital_name from wp_fee_receive as a left join wp_userinfo as b on a.purchaser_id = b.uid left join wp_order as c on a.order_id = c.oid left join wp_option as d on c.pid = d.id where unix_timestamp(now()) < b.utime+365*24*60*60 and a.type = 1 and a.purchaser_id in(".$one_id.") and a.user_id = ".$user_id." order by a.status desc");

        foreach ($water as $key => $val) {

            $aa[$key]['lavel']        = '一级';
            $aa[$key]['username']     = $val['username'];
            $aa[$key]['profit']       = $val['profit_rmb'];  //一级
            $aa[$key]['create_time']  = $val['create_time'];
            $aa[$key]['capital_name'] = $val['capital_name'];
            $aa[$key]['status']       = $val['status'];
        }

        $user_two = M()->query("select * from wp_userinfo where rid in(".$one_id.")");

        foreach ($user_two as $value) {

            array_push($optionIdArr_two,$value['uid']);
        }

        $water_two = implode(',',array_unique($optionIdArr_two));

        $two = M()->query("select a.create_time,a.purchaser_id,a.status,a.type,a.profit_rmb as profit_rmb,b.*,d.capital_name from wp_fee_receive as a left join wp_userinfo as b on a.purchaser_id = b.uid left join wp_order as c on a.order_id = c.oid left join wp_option as d on c.pid = d.id where unix_timestamp(now()) < b.utime+365*24*60*60 and a.type = 1 and a.purchaser_id in(".$water_two.") and a.user_id = ".$user_id." order by a.status desc");


        foreach ($two as $key => $value) {

            $bb[$key]['lavel']        = '二级';
            $bb[$key]['username']     = $value['username'];
            $bb[$key]['profit']       = $value['profit_rmb'];
            $bb[$key]['create_time']  = $value['create_time'];
            $bb[$key]['capital_name'] = $value['capital_name'];
            $bb[$key]['status']       = $value['status'];
        }
        
        $a = count($aa) >= count($bb) ? $aa : $bb;
        foreach ($a as $kkk => $vvv) {

            $user[] = $aa[$kkk];
            $user[] = $bb[$kkk];
        }

        $user = array_filter($user);
        
        $datetime = array();
        foreach ($user as $v) {
            $datetime[] = $v['create_time'];
        }

        array_multisort($datetime,SORT_DESC,$user);
        
        $p      = trim(I('post.p'));

        $page   = empty($p) ? 0 : $p;

        $pages  = $page * 10;

        $user = array_slice($user,$pages,10);

        foreach ($user as &$value) {

            $value['create_time'] = date('y-m-d',$value['create_time']);
            $value['username']    = substr_replace($value['username'],'****',3,4);
            $value['status']      = $value['status'] == 2 ? '未结算' : '已结算';
        }

        $data['user'] = $user;
        $data['p']    = $p+1;

        if($user)
        {
            sys_out_success('',$data);
        } else {

            sys_out_fail('没有数据');
        }
        
        
    }


    /**
     * 充值
     * @author wang <admin>
     */
    public function account_check(){

        $post_array  = array('paytype','money');
        sys_check_post($post_array);

        $user_id = $this->checkLogin();

        $data    = array();
        $paytype = trim(I('post.paytype'));  //支付方式
        $money   = trim(I('post.money'));    //充值金额
       
        if(empty($money)){
            sys_out_fail('支付金额不能为空');
        }

        // if($money < 100){
        //     sys_out_fail('支付金额不能小于100');
        // }

        if(empty($paytype)){
            sys_out_fail('请选择支付方式');
        }


        //生成订单信息
        $balance = M('accountinfo')->where(array('uid' => $user_id))->getField('balance');


        switch($paytype)
        {
            case 'wxpay_syx':
                $randN  = $this->number_syx();   //订单号
                $v_ymd  = date('Ymd'); //订单产生日期，要求订单日期格式yyyymmdd.
                $v_mid  = "10704";    //商户编号，和首信签约后获得,测试的商户编号444

                $num    = $v_ymd .'-' . $v_mid . '-' .$user_id.$randN;
                $redirectUrl        = 'pay_sxy';
                $data['pay_type']   = 2;
                break;

            case 'wxpay_syx_yl':
                $randN  = $this->number_syx();   //订单号
                $v_ymd  = date('Ymd'); //订单产生日期，要求订单日期格式yyyymmdd.
                $v_mid  = "10704";    //商户编号，和首信签约后获得,测试的商户编号444

                $num    = $v_ymd .'-' . $v_mid . '-' .$user_id.$randN;
                $redirectUrl        = 'pay_sxy_yinlian';
                $data['pay_type']   = 3;
                break;

            case 'weiXinWap_zn' : // 中南微信wap支付
                $num = $this->number_zn($user_id);  // 订单号
                $redirectUrl = 'pay_zn';
                $data['pay_type'] = 9;
                break;
        }


        $data['bptype']     = '充值';
        $data['remarks']    = '普通会员充值';
        $data['bptime']     = time();               //操作时间
        $data['bpprice']    = $money;               //充值金额
        $data['uid']        = $user_id;             //用户id
        $data['isverified'] = 0;                    //0未通过
        $data['balanceno']  = $num;                 //订单编号
        $data['shibpprice'] = $balance;             //用户余额
        $data['b_type']     = 1;                    //流水类型，1充值，2提现
        $data['status']     = 0;                    //0待处理  1完成


        $res = M('balance')->add($data);

        if($res){

            switch ($redirectUrl) {
                case 'pay_sxy':
                    $this->pay_sxy($data['balanceno'],$data['bpprice']);
                    break;
                
                case 'pay_sxy_yinlian':
                    $datas['type']  = 'yinlian';
                    $datas['url']   = 'http://'.$_SERVER['HTTP_HOST'].__CONTROLLER__.'/pay_sxy_yinlian?orderno='.Des::encrypt($data['balanceno']).'&money='.Des::encrypt($data['bpprice']).'';

                    sys_out_success('',$datas);
                    break;

                case 'pay_zn':
                    $this->pay_zn($data['balanceno'],$paytype);
                    break;
            }

        } else {

            sys_out_fail('充值错误，请稍后再试');
        }
    }


    //中南微信h5支付
    public function pay_zn($order_no,$method)
    {
        if (!$method) sys_out_fail('无效支付方式');

        $method2Type = array(
            'weiXinWap_zn' => 'wxwap'
        );

        $type = $method2Type[$method];
        if (empty($type)) sys_out_fail('无效支付方式');

        $balance = M('balance')->where(array('balanceno' => $order_no))->find();
        if (!$balance) sys_out_fail('无效订单');

        $q  = new \Org\Util\ZNanPay();
            
        $rs = $q->postOrder($type, $balance);
        

        if ($rs['status'] == 1) {
            $zn_rs['code_img_url'] = $rs['codeUrl'];
            $zn_rs['order_no'] = $order_no;

        } else {
            $zn_rs['code_img_url'] = $rs['codeUrl'];
        }

        dump($res);

        // if ($type=='wxwap' ){

        //     $datas['type']  = $method;
        //     $datas['url']   = $rs['codeUrl'];

        //     sys_out_success('',$datas);

        //     //redirect($rs['codeUrl']);
        // }

    }


    /**
     * 首信易扫码支付
     * @author wang <admin>
     */

    public function pay_sxy($orderno,$money)
    {

        $v_rcvname  = 'test'; //收货人姓名,建议用商户编号代替或者是英文数字。因为首信平台的编号是gb2312的
        $v_rcvaddr  = 'test'; //收货人地址，可用商户编号代替
        $v_rcvtel   = '82652626';   //收货人电话
        $v_rcvpost  = '100037';  //收货人邮编

        $v_oid      =  $orderno;
        $paycode    =  271;//trim(I('get.paycode'));   271支付宝扫码  254微信扫码

        $balance = M('balance')->where(array('balanceno' => $v_oid))->find();
        if(!$balance)
        {
            sys_out_fail('订单号不存在');
        }

        if($balance['bpprice'] != $money)
        {
            sys_out_fail('充值金额有误');
        }


        $dataArr    = array(
            'v_amount'      => $money,
            'v_rcvpost'     => $v_rcvpost,
            'v_rcvtel'      => $v_rcvtel,
            'v_rcvaddr'     => $v_rcvaddr,
            'v_rcvname'     => $v_rcvname,
            'v_oid'         => $v_oid,
            'pay_code'      => $paycode
        );

        $req        = new Shouxinyi();

        $data       = $req->get_pay_img($dataArr);



        Log::debugArr($data, 'shouxinyi');

        if($data)
        {   
            $datas['type']      = 'ma';
            $datas['url']       = (string)$data['bankurl'];
            $datas['oid']       = Des::encrypt($v_oid);

            sys_out_success('订单生成成功',$datas);

        } else {

            sys_out_fail('第三方支付系统错误');
        }
    }


        /**
     * @functionname: pay_sxy_yinlian
     * @date: 2017-01-13 15:05:21
     * @description: 首信易银联接口
     * @note:
     */
    public function pay_sxy_yinlian()
    {

        $v_oid      =  trim(I('get.orderno'));
        $money      =  trim(I('get.money'));

        if(empty($v_oid) || empty($money))
        {
            sys_out_fail('参数不能为空');
        }


        $v_rcvname  = 'test'; //收货人姓名,建议用商户编号代替或者是英文数字。因为首信平台的编号是gb2312的
        $v_rcvaddr  = 'test'; //收货人地址，可用商户编号代替
        $v_rcvtel   = '82652626';   //收货人电话
        $v_rcvpost  = '100037';  //收货人邮编


        $v_oid      = Des::decrypt($v_oid);
        $money      = Des::decrypt($money);

        $balance = M('balance')->where(array('balanceno' => $v_oid))->find();
        if(!$balance)
        {
            sys_out_fail('订单号不存在');
        }

        if($balance['bpprice'] != $money)
        {
            sys_out_fail('充值金额有误');
        }

        $return_url     = 'http://'.$_SERVER['HTTP_HOST'].'/Home/Paysxy/get_pay_result_yinlian';

        
        $dataArr    = array(
            'v_amount'      => $money,
            'v_rcvpost'     => $v_rcvpost,
            'v_rcvtel'      => $v_rcvtel,
            'v_rcvaddr'     => $v_rcvaddr,
            'v_rcvname'     => $v_rcvname,
            'v_oid'         => $v_oid,
            'v_url'         => $return_url
        );


        $req        = new ShouxinyiYinlian();


        $data = $req->opt_pay($dataArr);

        Log::debugArr($data, 'shouxinyi');

        if($data)
        {
            
            $url = 'https://pay.yizhifubj.com/customer/gb/pay_bank.jsp';

            $this->create($data,$url);

        } else {

            sys_out_fail('第三方支付系统错误');
        }

    }


    /**
     * @functionname: get_pay_result
     * @description: 获得支付结果
     * @note:
     */
    public function get_pay_result()
    {

        $this->checkLogin();

        sys_check_post_single('oid');

        $v_oid  = trim(I('post.oid'));

        $v_oid  = Des::decrypt($v_oid);

        $getArr = array('v_oid' => $v_oid);
        $req    = new Shouxinyi();
        $desc   = $req->get_result($getArr);

        $aa     = $desc['pstatus'];  //状态
        $amount = $desc['amount'];

        Log::debugArr($aa, 'shouxinyi_notify_url');

        $balance    = M('balance');
        $account    = M('accountinfo');

        if($aa == 1)
        {
            $order_no           = $v_oid;
            $order_time         = time();

            $data1 = $balance->where(array('balanceno' => $order_no))->find();


            if(!$data1)
            {
                sys_out_fail('查询失败，未找到充值流水！');
            }
            else
            {
                $data2 = $balance->where(array('status' => 1,'isverified' => 1,'bpid' => $data1['bpid']))->find();
                if($data2)
                {
                    sys_out_fail('已经充值了');
                }

                $order_amount       = $amount;
                $data['bpprice']    = $order_amount;
                $data['isverified'] = '1'; //入金成功
                $data['status']     = '1'; //完成
                $data['cltime']     = $order_time; //完成
                $data['shibpprice'] = $data1['shibpprice'] + $order_amount; //完成

                $case = $balance->where(array('balanceno' => $order_no))->save($data);
                if ($case)
                {
                    $money = $account->where(array('uid' => $data1['uid']))->setInc('balance', $order_amount);
                    $money_total = $account->where(array('uid' => $data1['uid']))->setInc('recharge_total', $order_amount);
                }
                    //用户资金流水表
                if($money && $money_total)
                {
                        $info = M('userinfo')->where(array('uid' => $data1['uid']))->find();
                        if($info['otype'] == 5)
                        {
                           $map['user_type'] = 2;
                        }
                        $map['uid']      = $data1['uid'];
                        $map['type']     = 4;
                        $map['oid']      = $data1['bpid'];
                        $map['note']     = '用户使用首信易支付充值金额['.$order_amount.']元';
                        $map['balance']  = $account->where(array('uid' => $data1['uid']))->sum('balance');
                        $map['op_id']    = $data1['uid'];
                        $map['dateline'] = time();
                        M("money_flow")->add($map);
                        sys_out_success('充值成功');
                } else {
                    sys_out_fail('充值失败');
                }
            }

        }
        else if($aa == 2)
        {
            sys_out_fail('尚未支付！');
        }
        else
        {
            sys_out_fail('尚未支付！');
        }

    }



    private function create($data, $submitUrl) {
        $inputstr = "";
        foreach ($data as $key => $v) {
            $inputstr .= '<input type="hidden"  id="' . $key . '" name="' . $key . '" value="' . $v . '"/>';
        }
        $form = '<form action="' . $submitUrl . '" name="pay" id="pay" method="POST">';
        $form .= $inputstr;
        $form .= '</form>';
        $html = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>请不要关闭页面,支付跳转中.....</title>
        </head><body>
        ';
        $html .= $form;
        $html .= '
        <script type="text/javascript">
           document.getElementById("pay").submit();
        </script>';
        $html .= '</body></html>';
        $this->Mheader('utf-8');
        echo $html;
        exit;

    }

    private function Mheader($type) {

        header("Content-Type:text/html;charset={$type}");
    }


    /**
     * 请求产品参数
     * @author wang <admin>
     */
    public function getdata() {
        
        sys_check_post_single('id');

        $id = trim(I('post.id'));
      
        if($id){

            $code = M('option')->where(array('id' => $id))->getField('capital_key');
            
            $data = file_get_contents('http://data.ronmei.com:8888/Price?code='.$code.'');
            $data = json_decode($data,true);

            $datas = array(
                'capital_key'   => $code,
                'Price'         => $data['Price'],
                'Open'          => $data['Open'],
                'Close'         => $data['LastClose'],
                'High'          => $data['High'],
                'Low'           => $data['Low'],
                'Diff'          => $data['Diff'],
                'DiffRate'      => $data['DiffRate'],
                'edit_time'     => $data['LastTime'],
                'bp'            => $data['BP1'],
                'bv'            => $data['BV1'],
                'sp'            => $data['SP1'],
                'sv'            => $data['SV1'],
                'TotalVol'      => $data['TotalVol']
            );

            if($data)
            {
                sys_out_success('',$datas);
            } else {

                sys_out_fail('没有数据');
            }
           
        } else{

            sys_out_fail('请传入商品编号');
        }
    }

    /*网站弹窗公告*/
    public function stretch()
    {
        $time = time();
        $info = M("SiteStretch")->where(''.$time.' >= start_time and '.$time.' <= end_time')->order('id desc')->find();
        $content['title']   = $info['title'];
        $content['content'] = html_entity_decode($info['content']);
        
        if($info)
        {
            sys_out_success('',$content);

        } else {
 
            sys_out_fail('没有数据');
        }
    }



    /**
     * 订单编号
     * @author wang <admin>
     */

    private function number(){

        return time().mt_rand();
    }


    /**
     * 中南支付订单编号
     * @author zhu
     */

    private function number_zn($user_id){
        return $user_id.time().mt_rand();
    }


    /**
     * @functionname: number_syx
     * @author: wang
     * @description: 针对于首信易的订单号
     * @note:
     * @return string
     */
    private function number_syx()
    {
        return substr(time(), 7, 4).mt_rand(1, 999);
    }

    /**
     * by wang admin
     * k线图
     */
    public function highstock()
    {
        $code = trim(I('get.capital_key'));
        $this->assign('code',$code);                  //代码
        $this->assign('interval',I('get.interval'));  //类型
        $this->assign('length',I('get.length'));    // 保留小数
        $this->display();
    }


    public function binding()
    {
        Gateway::$registerAddress = '127.0.0.1:1238';
        
        $uid    = trim(I('post.client_id'));

        $group  = explode(',',trim(I('post.group')));

        foreach ($group as $key => $value) {

            Gateway::joinGroup($uid,$value);
        }
        
        $data['client_id'] = trim(I('post.client_id'));
        $data['group']     = trim(I('post.group'));

        sys_out_success('',$data);
        //var_export(Gateway::getAllClientCount());
    }


    /**
     * 踢掉某个用户
     * @author wang <admin>
    */
    public function closeClient()
    {
        $status     = trim(I('post.status'));
        $client_id  = trim(I('post.client_id'));
        $group      = trim(I('post.group'));

        $post_array = array('status','client_id','group');
        sys_check_post($post_array);

        if($status == 'ok')
        {
            //echo json_encode($client_id);
            //Gateway::closeClient($client_id);

            $group  = explode(',',$group);

            foreach ($group as $key => $value) {
                Gateway::leaveGroup($client_id, $value);
                echo json_encode($value);
                Log::debugArr($value, 'websocket');
            }
        }
    }


    /*检测用户是否存在*/
    public function checkLogin()
    {
       $token      	= trim(I('post.token'));

       sys_check_post_single('token');

       	$user_id 	= M('userinfo')->where(array('token' => $token,'otype' => 4))->getField('uid');
    	if(!$user_id)
    	{
    		sys_out_fail('用户不存在');
    	}

    	return $user_id;
    }

    /*检测运营中心是否存在*/
    public function checkAgent()
    {
    	$operateId  	= trim(I('post.operateId'));

       	sys_check_post_single('operateId');

       	$agent_id = M('userinfo')->where(array('uid' => $operateId,'otype' => 5))->getField('uid');
    	if(!$agent_id)
    	{
			sys_out_fail('运营中心不存在');
    	}

    	return $agent_id;
    }

}