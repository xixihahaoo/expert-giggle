<?php
/**
 * @author: FrankHong
 * @datetime: 2016-11-15 11:43:53
 * @filename: GoodsController.class.php
 * @description: 商品管理
 * @note:
 *
 */

namespace Admin\Controller;
class GoodsController extends CommonController
{


    public function gadd()
  {


    
    //实例化数据表
    $goods = D('productinfo');
    $goodtype = D('catproduct');
    //获取所有商品分类      
    $catgood = $goodtype->select();
    $this->assign('catgood',$catgood);
    //判断如果是post提交，则添加数据，否则显示视图
    if(IS_POST){
      if($goods->create()){
        $result = $goods->add();
        if($result){
//          echo "<script> alert('添加商品成功');window.location.href='{:U('Goods/glist')}';</script>";
          $this->success('添加商品成功',U('Goods/glist'));
        }else{
          $this->error('添加商品失败');
        }
      }else{
        $this->error($goods->getError());
      }
    }else{
      $this->display();
    }
  }

    /**
     * @functionname: add_goods_time
     * @author: FrankHong
     * @date: 2016-11-15 11:28:45
     * @description: 增加商品的交易时间
     * @note:
     */
    public function add_goods_time()
    {

  
        $this->display();
    }


    /**
     * @functionname: goods_list
     * @author: wang
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品分类
     */
    
    public function goods_classify(){
          
          $class = M('OptionClassify')->select();
          
          $this->assign('class',$class);
          $this->display();
    }
  
    /**
     * @functionname: goods_add
     * @author: wang
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品添加分类
     */
    
    public function goods_add(){
        if(IS_AJAX){
             
            $data = array(); 

            if(I('post.name') == ''){

                 $data['status'] = 0;
                 $data['msg']    = '栏目名称不能为空';
                 $this->ajaxReturn($data,'JSON');
            }

            $map['name']        = I('post.name');
            $map['create_time'] = time();
            $result = M('OptionClassify')->add($map);
            if($result){

                 $data['status'] = 1;
                 $data['msg']    = '栏目添加成功';
                 $this->ajaxReturn($data,'JSON');
            } else {

                 $data['status'] = 0;
                 $data['msg']    = '栏目添加失败';
                 $this->ajaxReturn($data,'JSON');
            }
        }
       $this->display();
    }


    /**
     * @functionname: classify_edit
     * @author: wang
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品分类修改
     */
     
     public function classify_edit(){
          
          if(IS_AJAX){
 
              $data = array();
              $name = I('post.name');
              $id   = I('post.id');
              if($name && $id){
                  
                  $result = M('OptionClassify')->where(array('id' => $id))->setField('name',$name);
                  if($result){
                       $data['status'] = 1;
                       $data['msg'] = '修改成功';
                       $this->ajaxReturn($data,'JSON');
                  } else {
                       $data['status'] = 0;
                       $data['msg'] = '修改失败';
                       $this->ajaxReturn($data,'JSON');
                  }

              } else {

                       $data['status'] = 0;
                       $data['msg'] = '栏目名称不存在';
                       $this->ajaxReturn($data,'JSON');
              }
          }


          $id = I('get.pid');
          $cate = M('OptionClassify')->where(array('id' => $id))->find();
          $this->assign('cate',$cate);
          $this->display();
     }

    /**
     * @functionname: classify_del
     * @author: wang
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品分类删除
     */
    
     public function  classify_del(){

        $id = I('post.id');

        if($id){
              
              $data   = array();
              $result = M('OptionClassify')->where(array('id' => $id))->delete();
              if(!$result){
                  
                    $data['msg']    = '删除失败';
                    $this->ajaxReturn($data,'JSON');
              } else {

                    $data['msg'] = '删除成功';
                    $this->ajaxReturn($data,'JSON');
              }
        }
     }
    

    /**
     * @functionname: goods_list
     * @author: FrankHong
     * @date: 2016-11-15 11:38:41
     * @description: 系统商品列表
     * @note: 目前只支持修改，不支持增加
     *
     * 跌：#090
     * 涨：#f00
     */
    public function goods_list()
    {  
  
        //产品分类
        if(I('get.pid')){

            $map['pid'] = trim(I('get.pid'));
            $this->assign('posiname',M('OptionClassify')->where(array('id' => I('get.pid')))->find());
        }

        $optionObj  = M('option');
        $optionRs   = $optionObj->where($map)->select();


        $optionInfoObj  = M('option_info');
        $optionInfoRs   = $optionInfoObj->select();
        foreach($optionInfoRs as $k => $v)
        {
            $optionInfoRs1[$v['option_id']] = $v;
        }

        $currencyRs     = C('SYSTEM_CURRENCY_TYPE');
        $optionIdArr    = array();
        $optionRs1      = array();
        $class          = array();  //分类
        foreach($optionRs as $k => $v)
        {
            $optionRs1[$v['id']]                = $v;
            $optionRs1[$v['id']]['style_color'] = ($v['Open'] - $v['Close'] > 0) ? 'num_red' : 'num_green';
            $optionRs1[$v['id']]['currency_v']  = $currencyRs[$v['currency']]['code'];
            $optionRs1[$v['id']]['currency_v1'] = $currencyRs[$v['currency']]['name'];

            if($v['global_flag'] == 1)
            {
                $optionRs1[$v['id']]['deal_status_check']   = 'checked="checked"';
                if($v['flag'] == 1)
                {
                    $optionRs1[$v['id']]['deal_status']         = '正常';
                    $optionRs1[$v['id']]['deal_status_style']   = 'num_red';
                }
                else
                {
                    $optionRs1[$v['id']]['deal_status']         = '休市';
                    $optionRs1[$v['id']]['deal_status_style']   = 'num_green';
                }
            }
            else
            {
                $optionRs1[$v['id']]['deal_status']         = '交易关闭';
                $optionRs1[$v['id']]['deal_status_check']   = '';
                $optionRs1[$v['id']]['deal_status_style']   = 'num_green';
            }


            $optionRs1[$v['id']]['fee']            = $optionInfoRs1[$v['id']]['CounterFee'];
            $optionRs1[$v['id']]['profit']         = $optionInfoRs1[$v['id']]['profit'];
            $optionRs1[$v['id']]['Bond']           = $optionInfoRs1[$v['id']]['Bond'];  //保证金基数
            $optionRs1[$v['id']]['commission']     = $optionInfoRs1[$v['id']]['commission']; 
            $optionRs1[$v['id']]['sort']           = $optionInfoRs1[$v['id']]['sort'];    //排序
            $optionRs1[$v['id']]['hs_code']        = $optionInfoRs1[$v['id']]['hs_code'];    //编号
            $optionRs1[$v['id']]['capital_length'] = $optionInfoRs1[$v['id']]['capital_length'];    //保留小数点



            $optionRs1[$v['id']]['sell_status'] = $v['sell_flag'] == 1 ? '正常持仓' : '强制平仓';
            if($v['sell_flag'] == 1)
            {
                $optionRs1[$v['id']]['sell_status_style']   = 'num_red';
            }
            else
            {
                $optionRs1[$v['id']]['sell_status_style']   = 'num_green';
            }
           
            array_push($optionIdArr, $v['id']);  //产品id
            array_push($class,$v['pid']);        //分类id
        }

        $optionIdStr    = implode(',', array_unique($optionIdArr));
        $class          = implode(',', array_unique($class));   //分类

        $dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->where('option_id in ('.$optionIdStr.')')->select();


        //vD($dealTimeRs);

        $dealTimeRs1    = array();
        foreach($dealTimeRs as $k => $v)
        {
            $start_time = substr($v['deal_time_start'], 0, 2).':'.substr($v['deal_time_start'], -2, 2);
            $end_time   = substr($v['deal_time_end'], 0, 2).':'.substr($v['deal_time_end'], -2, 2);

            $dealTimeRs1[$v['option_id']]['deal_time']  .= $start_time.'-'.$end_time.'<br>';
        }

        //止损列表
         $deal = array();
          $transaction = M('OptionTransaction')->where('option_id in ('.$optionIdStr.')')->select();
          foreach ($transaction as  $k => $v) {
              
              $deal[$v['option_id']]['Stop_loss']   .= $v['Stop_loss'].'<br/>';
              $deal[$v['option_id']]['stop_profit'] .= $v['stop_profit'].'<br/>';
          }
        

          //所属分类
         $aa = array();
         $classify = M('OptionClassify')->where(array('id in ('.$class.')'))->select();
        foreach ($classify as $key => $value) {
           
             $aa[$value['id']]['name'] = $value['name'];
        }   

        $this->assign('class',$aa);  //所属分类

        $this->assign('deal',$deal);  //止损列表
        
        $this->assign('dealTimeRs1', $dealTimeRs1);
        $this->assign('optionRs', $optionRs1);
        $this->display();
    }

    /**
     * @functionname: good_fee
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 设置每个商品属性
     * @note:
     */
    public function good_fee(){
          
          $data      = array();
          $option_id = I('post.option_id'); 
          $pass      = trim(I('post.pass'));   //每手的金额
          $field     = I('post.field');   //修改的字段

          if($field == 'capital_dot_length' || $field == 'wave'){

               $result = M("option")->where(array('id' => $option_id))->setField($field,$pass);
          } else{

              $info = M('OptionInfo')->where(array('option_id' => $option_id))->find();
              if(!$info){
                    
                    $map['option_id'] = $option_id;
                    $result = M('OptionInfo')->add($map);
              } else {
                    $result = M('OptionInfo')->where(array('option_id' => $option_id))->setField($field,$pass);
              }
          }

          if($result){

                $data['status'] = 1;
                $data['msg']    = '修改成功';
                $this->ajaxReturn($data,'JSON');

            } else {

                $data['status'] = 0;
                $data['msg']    = '修改失败';
                $this->ajaxReturn($data,'JSON');
            }

    }

    /**
     * @functionname: good_stop
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 设置每个商品的止损金额
     * @note:
     */ 
    public function good_stop(){
        
         $option_id = I('get.option_id');
         $transaction = M('OptionTransaction')->where(array('option_id' => $option_id))->select();

         $this->assign('option_id',$option_id);
         $this->assign('transaction',$transaction);
         $this->display();
    }

        /**
     * @functionname: good_stop
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 设置每个商品的止损金额
     * @note:
     */ 
    public function good_profit(){
        
         $option_id = I('get.option_id');
         $transaction = M('OptionTransaction')->where(array('option_id' => $option_id))->select();

         $this->assign('option_id',$option_id);
         $this->assign('transaction',$transaction);
         $this->display();
    }

    /**
     * @functionname: stop_edit
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 修改止损金额
     * @note:
     */ 
    public function stop_edit(){
          
          $return    = array();
          $option_id = I('post.option_id');
          $loss      = I('post.loss');     //数组
          $id        = I('post.id');
          $field     = I('post.field'); //要修改的字段
         
         if($loss == ''){

              $return['status'] = 0;
              $return['msg']    = '请输入要修改的内容';
              $this->ajaxReturn($return,'JSON');
         }

          
          for ($i=0; $i < count($loss) ; $i++) { 
              
              $data['aa'][] = $loss[$i];
              $data['bb'][] = $id[$i];
            
          }  
          
       
        foreach ($data['aa'] as $key => $value) {
              
               $d[$key]['loss'] = $data['aa'][$key];
               $d[$key]['id']   = $data['bb'][$key];
        }

        foreach ($d as $key => $val) {
             
             $map[$field] = $val['loss'];
             $save[] = M('OptionTransaction')->where(array('id' => $val['id'], 'option_id' => $option_id))->save($map);

             if(!$val['id']){

                  $map['option_id'] = $option_id;
                  $map[$field] = $val['loss'];
                  $add[] = M('OptionTransaction')->add($map);
             } 

        }
         
         if($save || $add){

              $return['status'] = 1;
              $return['msg']    = '保存成功';
              $this->ajaxReturn($return,'JSON');
         } else {

              $return['status'] = 0;
              $return['msg']    = '保存失败';
              $this->ajaxReturn($return,'JSON');
         }

    }

    /**
     * @functionname: loss_del
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 删除止损金额
     * @note:
     */ 
   public function loss_del(){

        $id = I('get.id');
        $map['id'] = $id;
        M('OptionTransaction')->where($map)->delete();
   }

    /**
     * @functionname: take
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 商品玩法
     * @note:
     */ 
   public function take(){

        if(IS_AJAX){

              $text = I('post.text');
  
              $option_id = I('post.option_id');
              $data = array();
              if(trim($text) == ''){

                   $data['status'] = 0;
                   $data['msg']    = '内容不能为空';
                   $this->ajaxReturn($data,'JSON');
              }

              $map['content']   = $text;
              $map['option_id'] = $option_id;
              $play = M('OptionPlay')->where(array('option_id' => $option_id))->find();
              if(!$play){

                $result = M('OptionPlay')->add($map);

              } else {

                $result = M("OptionPlay")->where(array('option_id' => $option_id))->setField('content',$text);
              }
               
               if($result){

                    $data['status'] = 1;
                    $data['msg'] = '添加成功';
                    $this->ajaxReturn($data,'JSON');
               } else{
                    $data['status'] = 0;
                    $data['msg']    = '添加失败';
                    $this->ajaxReturn($data,'JSON');
               }
               
        }

        $option_id = I('get.option_id');
        $this->assign('option_id',$option_id);
        $this->assign('content',M('OptionPlay')->where(array('option_id' => $option_id))->find());//玩法
        $this->display();
   }
    

    /**
     * @functionname: upload
     * @author: wang
     * @date: 2016-11-15 15:49:48
     * @description: 编辑器初始化
     * @note:
     */ 
 public function upload() {
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     3145728 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     ''; // 设置附件上传（子）目录
    // 上传文件 
    $info   =   $upload->upload();

    $url = './Uploads/'.$info['file']['savepath'] . $info['file']['savename'];
    $img = 'http://'.$_SERVER['HTTP_HOST'].'/Uploads/'.$info['file']['savepath'] . $info['file']['savename'];

    $image = new \Think\Image();//实例化图片处理类
    $image->open($url);//打开图片
    $image->thumb(400, 400)->save($url);//生成50X50的缩略图,并保存

        if ($info) {
            $result = array(
                'code' => 0,
                'msg'  => '上传成功',
                'data' => array(
                    'src'   => $img,
                    'title' => '图片'
                )
            );
        } else {
            $result = array(
                'code' => -1,
                'msg'  => '上传失败'
            );
        }

        $this->ajaxReturn($result,'JSON');
    }



    /**
     * @functionname: good_time_edit
     * @author: FrankHong
     * @date: 2016-11-15 15:49:48
     * @description: 设置每个商品的一天中的交易时间
     * @note:
     */
    public function good_time_edit()
    {
        $dealTimeObj    = M('option_deal_time');

        $optionId       = I('get.option_id');
        $goodTimeRs     = $dealTimeObj->where('option_id='.$optionId)->select();

        foreach($goodTimeRs as $k => $v)
        {
            $goodTimeRs[$k]['deal_time_start1'] = substr($v['deal_time_start'], 0, 2) . ':' . substr($v['deal_time_start'], -2, 2);
            $goodTimeRs[$k]['deal_time_end1']   = substr($v['deal_time_end'], 0, 2) . ':' . substr($v['deal_time_end'], -2, 2);

        }

//        if(empty($goodTimeRs))
//        {
//
//        }
//
//        $optionObj  = M('option');
//        $optionRs   = $optionObj->select();
//
//        $optionRs1  = array();
//        foreach($optionRs as $k => $v)
//        {
//            $optionRs1[$v['id']]                = $v;
//        }


        $this->assign('option_id', $optionId);
        $this->assign('goodTimeRs', $goodTimeRs);
        $this->display();
    }

    /**
     * @functionname: good_time_edit_opt
     * @author: FrankHong
     * @date: 2016-11-15 17:44:34
     * @description: 商品交易时间处理
     * @note: 先删除数据，重新增加数据
     *
     * array(1) {
            ["time_code"]=>
            array(2) {
            ["time_start"]=>
            array(6) {
                [0]=>
                string(5) "23:00"
                [1]=>
                string(5) "10:00"
                [2]=>
                string(0) ""
                [3]=>
                string(5) "11:00"
                [4]=>
                string(5) "10:00"
                [5]=>
                string(0) ""
                }
            ["time_end"]=>
            array(6) {
                [0]=>
                string(5) "12:26"
                [1]=>
                string(5) "13:00"
                [2]=>
                string(0) ""
                [3]=>
                string(5) "09:24"
                [4]=>
                string(5) "06:34"
                [5]=>
                string(0) ""
                }
            }
        }
     */
    public function good_time_edit_opt()
    {
        $timeCode   = I('post.time_code');
        $optionId   = I('post.option_id', 0);
        $dealType   = I('post.deal_type', 1);

//        vD($_POST);
//
//        die();

        if(!$optionId)
            outjson(array('status' => 0, 'ret_msg' => '参数错误'));

        $timeStart  = $timeCode['time_start'];
        $timeEnd    = $timeCode['time_end'];
        $timeType   = $dealType['time_type'];
        $dataAdd    = array();

        if(empty($timeStart) || empty($timeEnd))
            outjson(array('status' => 0, 'ret_msg' => '时间不能为空'));


        $dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->where('option_id='.$optionId)->select();
        $dealTimeCount  = count($dealTimeRs);

        $dealTimeObj->where('option_id='.$optionId)->limit($dealTimeCount)->delete();

        $count      = count($timeStart);
        $k          = 1;
        for($i = 0; $i < $count; $i++)
        {
            if(!empty($timeStart[$i]))
            {
                $dataAdd[$i]['deal_time_start'] = str_replace(':', '', $timeStart[$i]);
                $dataAdd[$i]['deal_time_end']   = str_replace(':', '', $timeEnd[$i]);
                $dataAdd[$i]['time_order']      = $k;
                $dataAdd[$i]['deal_time_type']  = $timeType[$i];
                $dataAdd[$i]['option_id']       = $optionId;

                $k++;
            }
        }


        $flag           = $dealTimeObj->addAll($dataAdd);
        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '保存成功'));
        
    }


    /**
     * @functionname: opt_deal_time
     * @author: FrankHong
     * @date: 2016-11-17 17:23:26
     * @description: 处理交易转状态
     * @note:
     */
    public function opt_deal_status()
    {
        $optionId   = I('post.option_id', 0);
        $dealStatus = I('post.flag', 1);

        if(!$optionId)
            outjson(array('status' => 0, 'ret_msg' => '参数错误'));

        $optionObj  = M('option');
        $flag       = $optionObj->where('id='.$optionId)->setField('global_flag', $dealStatus);

        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '操作成功'));
    }


  public function glist(){
 
    //判断用户是否登陆
    $user= A('Admin/User');
    $user->checklogin();
    
    $tq=C('DB_PREFIX');
    $goods = D('productinfo');
    $step = I('get.step');
    
    if($step == "search"){
      $keywords = '%'.I('post.keywords').'%';
      $where['ptitle|uprice|feeprice'] = array('like',$keywords);
      $goodlist = $goods->join($tq.'catproduct on '.$tq.'catproduct.cid='.$tq.'productinfo.cid')->where($where)->order($tq.'productinfo.pid desc')->select();     
      if($goodlist){
        $this->ajaxReturn($goodlist); 
      }else{
        $this->ajaxReturn("null");
      }
    }else{
      $count = $goods->count();
          $pagecount = 20;
          $page = new \Think\Page($count , $pagecount);
          $page->parameter = $row; //此处的row是数组，为了传递查询条件
          $page->setConfig('first','首页');
          $page->setConfig('prev','&#8249;');
          $page->setConfig('next','&#8250;');
          $page->setConfig('last','尾页');
          $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
      
          $show = $page->show();
      $goodlist = $goods->join($tq.'catproduct on '.$tq.'catproduct.cid='.$tq.'productinfo.cid')->order($tq.'productinfo.pid desc')->limit($page->firstRow.','.$page->listRows)->select();
      
      $this->assign('goodlist',$goodlist);
      $this->assign('page',$show);
    }
    $this->display();
  }
  public function gtype()
  {
    //判断用户是否登陆
    $user= A('Admin/User');
    $user->checklogin();
    
    $goodtype = D('catproduct');
    $typelist = $goodtype->select();
    
    $this->assign('typelist',$typelist);
    $this->display();
  }
  
  public function gtypeadd()
  {
    //判断用户是否登陆
    $user= A('Admin/User');
    $user->checklogin();
    if(IS_POST){
      //实例化数据表
      $goodtype = D('catproduct');
      //自动验证表单
      if($goodtype->create()){
        //添加数据
        $result = $goodtype->add();
        if($result){
          $this->success('添加成功',U('Goods/typelist'));
        }else{
          $this->error('添加失败');
        }
      }else{
        //自动验证返回结果
        $this->error($goodtype->getError());
      }
    }else{
      $this->display(); 
    }   
  }
        public function gedit()
  {
    //判断用户是否登陆
    $user= A('Admin/User');
    $user->checklogin();
    
    $tq=C('DB_PREFIX');
    $pinfo = D('productinfo');
    $catp = D('catproduct');
    //判断执行，如果是post提交，执行修改方法，否则显示页面
    if(IS_POST){
      //自动验证表单
      if($pinfo->create()){
        
        //获取修改表单的数据，并做处理
        $postpid = I('post.pid');
        $data['ptitle'] = I('post.ptitle');
        $data['company'] = I('post.company');
        //$data['cid'] = I('post.cid');
        $data['uprice'] = I('post.uprice');
        $data['feeprice'] = I('post.feeprice');
        $data['wave'] = I('post.wave');
        // $data['rate'] = I('post.rate');
        $data['gefee'] = I('post.gefee');
        $data2['rate'] = I('post.rate');
        // $data['patx'] = I('post.patx');
        // $data['patj'] = I('post.patj');
        
        $result = $pinfo->where('pid='.$postpid)->save($data);
        $cid=$pinfo->field("cid")->where('pid='.$postpid)->find();
 
        /*$caps= $pinfo->field("pid")->where('cid='.$cid['cid'])->select();
 
        foreach ($caps as $key => $value) {
          $a= $pinfo->where('pid='.$value['pid'])->save($data2);
        }*/
        
        // $b=$pinfo->getLastSql();
        // var_dump($b);die;
        if($result === FALSE){
          $this->error("修改失败！");
        }else{
          $this->success("修改成功",U('Goods/glist'));
        }
      }else{
        //自动验证返回结果
        $this->error($pinfo->getError());
      }
    }else{
      //通过获取的id查找该条数据

      $editgood = $pinfo->join($tq.'catproduct on '.$tq.'productinfo.cid='.$tq.'catproduct.cid')->where('pid='.$getpid)->find();
      //商品分类获取
      $pclist = $catp->select();
            vD($editgood);
      //获取油，白银，铜的实时价格
      $this->assign('pclist',$pclist);
      $this->assign('editgood',$editgood);
      $this->display();
    }
  }
  public function gdel(){
    $pinfo = D('productinfo');
    //批量删除id
    $arrpid = I('post.pid');
    //单个删除
    $pid = I('get.pid');
    
    if(IS_POST){
      //批量删除
      $result = $pinfo->where('pid in('.implode(',',$arrpid).')')->delete();
      if($result!==FALSE){
        $this->success("成功删除{$result}条！",U("Goods/glist"));
      }else{
        $this->error('删除失败！');
      }
    }else{
      //单条记录删除
      $result = $pinfo->where('pid='.$pid)->delete();
      if($result!==FALSE){
        $this->success("成功删除！",U("Goods/glist"));
      }else{
        $this->error('删除失败！');
      }
    }
  }


  public function number(){
 
    $you_z=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=0 and o.ostaus=0 and o.is_hide=0 and p.cid=1 group by p.cid ");
    $you_d=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=1  and o.ostaus=0 and o.is_hide=0 and p.cid=1 group by p.cid ");
    $yin_z=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=0   and o.ostaus=0 and o.is_hide=0 and p.cid=2 group by p.cid ");
    $yin_d=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=1  and o.ostaus=0  and o.is_hide=0 and p.cid=2 group by p.cid ");
    $tong_z=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=0 and o.ostaus=0 and o.is_hide=0 and p.cid=3 group by p.cid ");
    $tong_d=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=1 and o.ostaus=0 and o.is_hide=0 and p.cid=3 group by p.cid ");
    $num=array();
    $you_z1=$you_z[0]['num'];
    $you_d1=$you_d[0]['num'];
    $yin_z1=$yin_z[0]['num'];
    $yin_d1=$yin_d[0]['num'];

    $tong_z1=$tong_z[0]['num'];
    $tong_d1=$tong_d[0]['num'];
    $num['you_z']=empty($you_z1)?0:$you_z1;
    $num['you_d']=empty($you_d1)?0:$you_d1;
    $num['yin_z']=empty($yin_z1)?0:$yin_z1;
    $num['yin_d']=empty($yin_d1)?0:$yin_d1;
    $num['tong_z']=empty($tong_z1)?0:$tong_z1;
    $num['tong_d']=empty($tong_d1)?0:$tong_d1;
    $this->ajaxReturn($num);
  }

//  //删除栏目
//  public function newtypedel(){
//    $newsclass = D('newsclass');
//    //单个删除
//    $fid = I('get.fid');
//    $result = $newsclass->where('fid='.$fid)->delete();
//    if($result!==FALSE){
//      $this->success("成功删除！",U("News/typelist"));
//    }else{
//      $this->error('删除失败！');
//    }
//  }
  //获取动态油的价格，显示到页面
    public function price(){
         $source=file_get_contents("xh/you.txt");
         $msg = explode(',',$source);
         $myprice[0] = round(str_replace('price:', '',str_replace('"','',$msg[1])));//最新
         $myprice[8] = round(str_replace('jk:', '',str_replace('"','',$msg[4])));//今开
         $myprice[7] = round(str_replace('zk:', '',str_replace('"','',$msg[5])));//昨开
         $myprice[4] = round(str_replace('zg:', '',str_replace('"','',$msg[6])));//最高
         $myprice[5] = round(str_replace('zd:', '',str_replace('"','',$msg[7])));//最低
         //$myprice[12] = $myprice[0]-$myprice[8];   
     $this->ajaxReturn($myprice);
    }
    //获取动态白银的价格，显示到页面
    public function byprice(){
         $source=file_get_contents("xh/baiyin.txt");
         $msg = explode(',',$source);
         $myprice[0] = round(str_replace('price:', '',str_replace('"','',$msg[1])));//最新
         $myprice[8] = round(str_replace('jk:', '',str_replace('"','',$msg[4])));//今开
         $myprice[7] = round(str_replace('zk:', '',str_replace('"','',$msg[5])));//昨开
         $myprice[4] = round(str_replace('zg:', '',str_replace('"','',$msg[6])));//最高
         $myprice[5] = round(str_replace('zd:', '',str_replace('"','',$msg[7])));//最低
         //$myprice[12] = $myprice[0]-$myprice[8];
         $this->ajaxReturn($myprice);
    }
    //获取动态铜的价格，显示到页面
    public function toprice(){
         $source=file_get_contents("xh/tong.txt");
         $msg = explode(',',$source);
         $myprice[0] = round(str_replace('price:', '',str_replace('"','',$msg[1])));//最新
         $myprice[8] = round(str_replace('jk:', '',str_replace('"','',$msg[4])));//今开
         $myprice[7] = round(str_replace('zk:', '',str_replace('"','',$msg[5])));//昨开
         $myprice[4] = round(str_replace('zg:', '',str_replace('"','',$msg[6])));//最高
         $myprice[5] = round(str_replace('zd:', '',str_replace('"','',$msg[7])));//最低
         //$myprice[12] = $myprice[0]-$myprice[8];
         $this->ajaxReturn($myprice);
    }
  //调取分类的点差
    public function diancha($cname){
        $at= M('catproduct')->where("cname='$cname'")->find();
        return $at;
    }


}