<?php

namespace Admin\Controller;


class ToolsController extends CommonController
{

    /**
     * @functionname: setting_opt
     * @author: FrankHong
     * @date: 2016-11-14 15:07:02
     * @description: 系统当前交易币种及汇率设置
     * @note:
     * 定义新的常量 SYSTEM_CURRENCY_TYPE
     */
    public function setting_opt()
    {
        if (IS_AJAX)
        {

            $moneyName  = I('post.money_name');
            $moneyCode  = I('post.money_code');
            $moneyRate  = I('post.money_rate');

            $moneyRs      = array();
            foreach($moneyCode as $k => $v)
            {
                if(!empty($v))
                {
                    $moneyRs[$v]['name']    = trim($moneyName[$v]);
                    $moneyRs[$v]['code']    = trim($v);
                    $moneyRs[$v]['rate']    = trim($moneyRate[$v]);
                }
            }

           // vD($moneyRs);
           // die();

            $datas      = serialize($moneyRs);

            if (set_setting_config('SYSTEM_CURRENCY_TYPE', $datas))
            {
                $this->clear_cache();
                $this->success('保存成功！');
            }
            else
            {
                $this->error('保存失败！');
            }
        }
    }


    /**
     * @functionname: setting_list
     * @author: FrankHong
     * @date: 2016-11-14 15:35:56
     * @description: 系统配置列表
     * @note:
     */
    public function setting_list()
    {

        $systemCurrency = M('currency')->select();

        $currencyRs = get_setting_config('find', 'SYSTEM_CURRENCY_TYPE');

        $this->assign('currencyRs', $currencyRs['datas']);

        $this->assign('systemCurrency', $systemCurrency);


        $this->display();
    }


    /**
     * @functionname: clear_cache
     * @author: FrankHong
     * @date: 2016-11-14 16:56:10
     * @description: 当前配置项，全部在父类中进行初始化，加载到系统中，做了修改后，这里需要清空缓存，重新读取
     * @note:
     */
    private function clear_cache()
    {
        S('DB_CONFIG_DATA', null);
    }
  

    /**
     * @functionname: basic
     * @author: FrankHong
     * @date: 2016-11-14 15:35:56
     * @description: 系统基本设置
     * @note:
     */
    public function basic(){
          
          $config = M("webconfig")->find();
          $this->assign('conf',$config);
          $this->display();
    }


    /**
     * @functionname: product_sell_time
     * @author: FrankHong
     * @date: 2016-12-09 15:21:37
     * @description: 系统商品强制平仓时间设置
     * @note:
     */
    public function product_sell_time()
    {
        $sysDate    = get_setting_config('find', 'SYSTEM_OPTION_TIME');

        $this->assign('sys_date',$sysDate['datas']['sys_date']);
        $this->display();
    }


    /**
     * @functionname: product_sell_time_opt
     * @author: FrankHong
     * @date: 2016-12-09 15:31:35
     * @description: 系统平仓时间
     * @note: SYSTEM_OPTION_TIME
     */
    public function product_sell_time_opt()
    {
        if (IS_AJAX)
        {

            $sys_date   = I('post.sys_date');


            $systemDate = array('sys_date' => $sys_date);

            $datas      = serialize($systemDate);

            if (set_setting_config('SYSTEM_OPTION_TIME', $datas))
            {
                $this->clear_cache();
                $this->success('保存成功！');
            }
            else
            {
                $this->error('保存失败！');
            }
        }
    }

    /**
     * @functionname: commission_rate
     * @author: wang
     * @date: 2016-12-09 15:31:35
     * @description: 佣金比率
     */
    public function commission_rate()
    {
        $systemCurrency = M('UserinfoRate')->select();

        $this->assign('systemCurrency', $systemCurrency);

        $this->display();
    }

    /**
     * @functionname: commission_add
     * @author: wang
     * @date: 2016-12-09 15:31:35
     * @description: 佣金修改
     */
    public function commission_add()
    {
        if (IS_AJAX)
        {

            $moneyName  = I('post.money_name');
            $moneyRate  = I('post.money_rate');
            $id         = I('post.id');
            
            for ($i=0; $i < count($moneyName) ; $i++) { 
                  
                  $data['aa'][] = $moneyName[$i];
                  $data['bb'][] = $moneyRate[$i];
                  $data['cc'][] = $id[$i];
                
              }  
              
           
            foreach ($data['aa'] as $key => $value) {
                  
                   $d[$key]['name'] = $data['aa'][$key];
                   $d[$key]['rate'] = $data['bb'][$key];
                   $d[$key]['id']   = $data['cc'][$key];
            }
            
            foreach ($d as $key => $val) {
             
                 $map['name'] = $val['name'];
                 $map['rate'] = $val['rate'];
                 $save[] = M('UserinfoRate')->where(array('id' => $val['id']))->save($map);
            }

           
            if($save)
            {

                $this->success('保存成功！');
            }
            else
            {
                $this->error('保存失败！');
            }
        }
    }

    /**
     * @functionname: product_number
     * @author: wang
     * @date: 2016-12-09 15:21:37
     * @description: 用户交易手数限制
     * @note:SYSTEM_OPTION_NUMBER
     */
    public function product_number()
    {
        $sysDate    = get_setting_config('find', 'SYSTEM_OPTION_NUMBER');
        $this->assign('sys_date',$sysDate['datas']['sys_date']);
        $this->display();
    }


    /**
     * @functionname: product_number_opt
     * @author: wang
     * @date: 2016-12-09 15:31:35
     * @description: 用户交易手数限制
     * @note: SYSTEM_OPTION_NUMBER
     */
    public function product_number_opt()
    {
        if (IS_AJAX)
        {

            $sys_date   = I('post.sys_date');


            $systemDate = array('sys_date' => $sys_date);

            $datas      = serialize($systemDate);

            if (set_setting_config('SYSTEM_OPTION_NUMBER', $datas))
            {
                $this->clear_cache();
                $this->success('保存成功！');
            }
            else
            {
                $this->error('保存失败！');
            }
        }
    }
}