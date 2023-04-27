<?php
// +----------------------------------------------------------------------
// | 商品控制器
// +----------------------------------------------------------------------
// | Author wang <admin>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
use Org\Util\Gateway;

class IndexController extends CommonController {


    public function _initialize(){

        if(I('get.code'))
        {
            $this->assign('code',I('get.code'));
            $this->display('User/reg');
            die();
        }

        parent::_initialize();
    }
   
   public function pay(){

     $this->display('Ucenter/account');
   }
  
    /**
     * 产品列表
     * @author wang <admin>
     */
    
    public function index(){

        /*是否显示模拟交易*/
        $trade = M('userinfo')->where(array('uid' => $this->agent_id))->getField('s_domain_trade');
        $this->assign('trade',$trade);

        //产品分类
        $data = array();
        $class = M('OptionClassify')->order('id asc')->select();   //分类  desc
        foreach ($class as $key => $value) {

         $map['b.user_id'] = $this->agent_id;
         $map['b.status']  = 1;  //1为可售
         $map['a.pid'] = array('in',$value['id']);
         $result = M('option a')->field('a.*,b.status,b.type,b.option_id,b.user_id,b.commission,b.option_intro,c.sort,c.capital_length')->join(' left join wp_option_user_special as b on a.id = b.option_id')->join('left join wp_option_info as c on a.id = c.option_id')->where($map)->order('c.sort asc')->select();
         
     
             foreach ($result as $k => &$val) {

                 $val['Price']    = sprintf("%.".$val['capital_length']."f",$val['Price']); 

                 if($val['flag'] == 0 || $val['global_flag'] == 0 || shijian($val['id']) == '已休市'){
                      $val['color'] = $val['option_key'].'z';
                      $val['flag']  = 0;
                 }

                 if ($val['global_flag'] == 1)
                     $dd[$value['name']][$k]   = $val;
             }

        }
        
        $this->assign('result',$dd);    
        
        //头部广告
        $add = M('newsclass')->field('fid')->where(array('fid' => 5,'isshow' => 1))->find();
        $news   = M("newsinfo")->where(array('ncategory' => $add['fid']))->select();
        $this->assign("news",$news);
        
        //网站公告            
        $site = M("SiteStretch")->field('id')->order('id desc')->find();
        $time = time();
        $info = M("SiteStretch")->where(''.$time.' >= start_time and '.$time.' <= end_time and id = '.$site[id].'')->find();
        $content['title']   = $info['title'];
        $content['content'] = html_entity_decode($info['content']);
        $this->assign('info',$content);

        $this->assign('user',M('userinfo')->field('code')->where(array('uid' => $this->user_id))->find());
        $this->display();
    }

    /**
     * 新手指引
     * @author wang <admin>
     */
    public function newtrader(){
           
           //广告详情
           if(I('get.nid')){
                 
                $news = M("newsinfo")->where(array('nid' => I('get.nid')))->find();
                $data['news'] = html_entity_decode($news['ncontent']);
                $data['title'] = $news['ntitle'];
                $this->assign('news',$data);
                $this->display('Index/advert');

           } else{
                 $class = M('newsclass')->where(array('fid' => 6,'isshow' => 1))->find();
                 $news  = M('newsinfo')->where(array('ncategory' => $class['fid']))->find();
                 $nwes = html_entity_decode($news['ncontent']);
                 $this->assign('news',$nwes);
                 $this->display();
           }
    }


    /**
     * 产品详情
     * @author wang <admin>
     */
    public function product(){

        $id = trim(I('get.id'));

        if(empty($id))
        {
            $first = M("option a")->
                        field('a.id')->
                        join('wp_option_info as b on a.id = b.option_id')->
                        join('wp_option_user_special as c on a.id = b.option_id')->
                        where(array('a.global_flag' => 1,'c.status' => 1,'user_id' => $this->agent_id))->
                        order('b.sort asc')->
                        find();
            if($first)
            {
                $id = $first['id'];
            } else {
                $this->redirect('index');
            }
        }


        $product = M('option a')->join('wp_option_info as b on a.id = b.option_id')->where(array('a.id' => $id))->find();
            
        $product['Price']    = sprintf("%.".$product['capital_length']."f",$product['Price']);   //小数点位
        $product['bp']       = sprintf("%.".$product['capital_length']."f",$product['bp']);
        $product['sp']       = sprintf("%.".$product['capital_length']."f",$product['sp']);

        if(shijian($product['id']) == '已休市')
            $product['flag'] = 0 ;

        $this->assign('product',$product);
        $this->assign('type',1);     //真实交易

        $map['b.user_id'] = $this->agent_id;
        $map['b.status']  = 1;  //1为可售
        $option = M('option a')->field('a.*,b.status,b.type,b.option_id,b.user_id,b.commission,b.option_intro,c.sort')->join(' left join wp_option_user_special as b on a.id = b.option_id')->join('left join wp_option_info as c on a.id = c.option_id')->where($map)->order('c.sort asc')->select();  //所有产品(用于下拉框)
        $this->assign('option',$option);

        //查询持仓中的商品个数
        $count = M('order')->where(array('uid' => $this->user_id,'ostaus' => 0, 'pid' => $product['id'],'type' => 1))->count();
        $this->assign('count',$count);

      //取出用户余额
        if(isset($this->user_id)) {

            //账号余额
            $user=M('accountinfo')->where(array('uid' => $this->user_id))->find();
            
            $this->assign('user',$user);
        }

        /**闪电下单选择订单**/
        $transaction = M('OptionTransaction')->where(array('option_id' => $product['id']))->select();

        $currency = C('SYSTEM_CURRENCY_TYPE.'.Transformation($product['id']).'');

        $code = M('currency')->field('currency_sign')->where(array('currency_code' => $currency['code']))->find();
        $info = M('OptionInfo')->where(array('option_id' => $product['id']))->find();

        /*运营中心手续费*/
        $special = M('OptionUserSpecial')->field('platform_commission,commission')->where(array('user_id' => $this->agent_id,'option_id' => $product['id']))->find();

        $info['CounterFee'] = ($special['platform_commission'] + $special['commission']);
        /*运营中心手续费*/

        $info['foreign']     = round($info['Bond'] + $info['CounterFee'],2);                       //合计支付 外汇
        $info['foreign_rmb'] = round(($info['Bond'] + $info['CounterFee']) * $currency['rate'],2); //合计支付 人民币

        $this->assign('transaction',$transaction);
        $this->assign('currency',$currency);
        $this->assign('code',$code['currency_sign']);
        $this->assign('info',$info);
        /**闪电下单选择订单 End**/
        
        $this->assign('user_id',$this->user_id);
        $this->display();
    }


    /**
     * 获取是否休市
     * @author wang <admin>
     */
   public function Hugh(){
        
         $op_id = I('get.op_id');
         if(!$op_id){
            $this->ajaxReturn('error');
         } else{

             $hugh = M("option")->where(array('id' => $op_id))->find();
             
                if($hugh['flag'] == 0 || $hugh['global_flag'] == 0 || shijian($hugh['id']) == '已休市'){
                     
                       echo '0';  //休市         
                } else{

                       echo '1'; //可交易
                }
         }
   }

  /**
   * 商品玩法
   * @author wang <admin>
   */

  public function play(){
        $uid=  $this->agent_id;
        $option_id = trim(I('get.option_id'));

        $special = M('OptionUserSpecial a');
        $field = 'a.*,b.capital_type,capital_name,capital_key,b.currency,a.commission as commission,platform_commission';
        $map['a.user_id'] = $uid;
        $map['c.option_id'] = $option_id;
        $special_data = $special->
                        field($field)->
                        join('inner join wp_option as b on a.option_id = b.id')->
                        join('inner join wp_option_info as c on a.option_id = c.option_id')->
                        where($map)->
                        find();
        
        $totalFee = $special_data['platform_commission'] + $special_data['commission'];
        
        
        $news = M('OptionPlay')->where(array('option_id' => $option_id))->find();
        
        $news = html_entity_decode($news['content']);
        $news = str_replace('$$$$',$totalFee,$news);
        $this->assign('news',$news);

        $this->assign('option',M('option')->field('capital_name')->where(array('id' => $option_id))->find());
        $this->display();
   }


    //echarts
    public function echarts(){
        $type = trim(I('get.type'));

        $this->assign('code',trim(I('get.capital_key')));   //代码
        $this->assign('interval',trim(I('get.interval')));  //类型
        $this->assign('length',trim(I('get.length')));      //保留小数

        //加密 sign
        $key   = '6A1Yw45TZkazFB5E8KjSwiJOOK4Wrk3tfSq84FvBJCrvO3MKnATQoZMKqtXeCXzv';
        $stamp = time();
        $sign  = strtolower(md5($key.$stamp));

        $this->assign('stamp',$stamp);
        $this->assign('sign',$sign);

        $this->display($type);
    }


    /**
     * 查询网站是否关闭
     * @author wang <admin>
     */
    public function isopen(){
        $stye=M('webconfig')->select();
        return $stye[0]['isopen'];
    }


    public function binding()
    {
        Gateway::$registerAddress = '127.0.0.1:1510';
        
        $uid    = trim(I('post.client_id'));

        $group  = explode(',',trim(I('post.group')));

        foreach ($group as $key => $value) {

            Gateway::joinGroup($uid,$value);
        }

        //$message = 'hello';
        //Gateway::sendToGroup('group', $message);  //发送信息

        //var_export(Gateway::getClientCountByGroup($group));  //获取分组当前在线成员数
        
        var_export(Gateway::getAllClientCount());   //获取当前在线连接总数（多少client_id在线）。
    }

    //从redis中取出数据
    public function getData()
    {
        $code        = trim(I('get.codes'));
        $interval    = trim(I('get.interval'));
        $rows        = trim(I('get.rows'));

        if($interval == '1d') //如果是1日的数据
            $rows = 40;


        if(!empty($code))
        {
            //加密 sign
            $key   = 'LzzPuycH0wsZfMPf7a0XjD5jVQMgadkC82K1nRjRHQ3T3khJl978E33Qe2C44sY5';
            $stamp = time();
            $sign  = strtolower(md5($key.$stamp));
            $url     = 'http://39.107.99.235:1008/redis.php?code='.$code.'&time='.$interval.'&rows='.$rows.'&sign='.$sign.'&stamp='.$stamp;

            //$url     = 'http://39.107.99.235:1008/redis.php?code='.$code.'&time='.$interval.'&rows='.$rows.'';
            $json_data 	= $this->http_request($url);
            die($json_data);
        }

    }


    /**
     * curl 请求
     * @param wang li
     */
    public function http_request($URI, $isHearder = false, $post = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);          //单位 秒，也可以使用
        //        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);     //注意，毫秒超时一定要设置这个
        //        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000); //超时毫秒，cURL 7.16.2中被加入。从PHP 5.2.3起可使用
        curl_setopt($ch, CURLOPT_HEADER, $isHearder);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/tmp.cookie");
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/tmp.cookie");
        if(strpos($URI, 'https') === 0){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        if($post){
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}