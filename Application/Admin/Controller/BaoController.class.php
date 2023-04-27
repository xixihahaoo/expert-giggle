<?php

namespace Admin\Controller;
class BaoController extends BaseController {
	public function price(){
		$source=file_get_contents("xh/you.txt");
		return $source;
    }
	public function byprice(){
		$source=file_get_contents("xh/baiyin.txt");
		return $source;
    }
	public function toprice(){
		$source=file_get_contents("xh/tong.txt");
		return $source;
    }
	public function olist(){
		//获取所有没有平仓的订单
		$tq=C('DB_PREFIX');
		$orders = D('order');
		$jo = D('journal');
		$detailed = A('Home/Detailed');
		$orderno = $detailed->build_order_no();
		$field = $tq.'order.oid as oid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.onumber as onumber,'.$tq.'productinfo.wave as wave,'.$tq.'order.endprofit as endprofit,'.$tq.'order.endloss as endloss,'.$tq.'catproduct.cid as cid,'.$tq.'productinfo.uprice as uprice,'.$tq.'order.uid as uid,'.$tq.'order.ptitle as ptitle,'.$tq.'order.pid as pid,'.$tq.'accountinfo.balance as balance,'.$tq.'userinfo.username as username,'.$tq.'order.ostyle as ostyle,'.$tq.'order.fee as fee,'.$tq.'catproduct.myat as myat,'.$tq.'productinfo.gefee as gefee,'.$tq.'order.overday as overday,'.$tq.'order.buytime as buytime';
		$order=$orders->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid')
        ->join($tq.'catproduct on '.$tq.'productinfo.cid='.$tq.'catproduct.cid')->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid')->join($tq.'accountinfo on '.$tq.'order.uid='.$tq.'accountinfo.uid')->field($field)->where('ostaus=0')->select();
		//获取最新产品价格
		$yprice = $this->price();//油价
		$byprice = $this->byprice();//白银价
		$toprice = $this->toprice();//铜价
		if(($yprice <= 0) || ($byprice <= 0) || ($toprice <= 0))
		{
			return false;
		}
		//设置盈亏比，爆仓
		foreach($order as $k => $v){
			$uid = $order[$k]['uid'];					//用户id
			$pid = $order[$k]['pid'];					//产品id
			$balance = $order[$k]['balance'];			//账户余额
			$username = $order[$k]['username'];			//用户名
			// $fee = $order[$k]['fee'];					//手续费
			$fee = 0;					//手续费
			$ptitle = $order[$k]['ptitle'];				//产品
			$endprofit = $order[$k]['endprofit']/100;	//止盈
			$endloss = $order[$k]['endloss']/100;		//止亏
			$buyprice = $order[$k]['buyprice'];			//买入价格
			$onumber = $order[$k]['onumber'];			//买入数量
			$cid = $order[$k]['cid'];					//产品分类id，用于区分产品现价，1代表油价、2代表白银、3代表铜
			$ostyle = $order[$k]['ostyle'];				//涨、跌，0代表涨、1代表跌
			$wave = $order[$k]['wave'];					//浮动
			$uprice = $order[$k]['uprice'];				//单价
			$oid = $order[$k]['oid'];					//订单id
			$overday1 = $order[$k]['overday'];				//隔夜利息
			$buytime1 = $order[$k]['buytime'];				//隔夜利息
			$gefee = $order[$k]['gefee'];				//隔夜利息
			$myat=1;									//波动，目前只有油的波动是100，其他的都是1
			$payprice = $onumber*$uprice;				//保障金
			if($ostyle==0){
				if($cid==1){
					$ploss = round(($yprice-$buyprice)*$onumber*$wave*$myat,2);			//盈亏资金	
				}elseif($cid==2){
					$ploss = round(($byprice-$buyprice)*$onumber*$wave*$myat,2); 		//盈亏资金
				}else{
					$ploss = round(($toprice-$buyprice)*$onumber*$wave*$myat,2);		//盈亏资金
				}
			}else{
				if($cid==1){
					$ploss = round(($buyprice-$yprice)*$onumber*$wave*$myat,2);			//盈亏资金	
				}elseif($cid==2){
					$ploss = round(($buyprice-$byprice)*$onumber*$wave*$myat,2);		//盈亏资金
				}else{
					$ploss = round(($buyprice-$toprice)*$onumber*$wave*$myat,2);		//盈亏资金
				}
			}
			$surplus = $payprice+$ploss;									//本单盈余	
			$myprice=M('accountinfo')->where('uid='.$uid)->find();
			$shengmoney = $myprice['balance'];
			if($cid == 1){
				$this->gefee($oid,$uid,$balance,$gefee,$surplus,$ploss,$overday1,$buytime1,$yprice);
			}else if($cid == 2){
				$this->gefee($oid,$uid,$balance,$gefee,$surplus,$ploss,$overday1,$buytime1,$byprice);
			}else{
				$this->gefee($oid,$uid,$balance,$gefee,$surplus,$ploss,$overday1,$buytime1,$toprice);
			}
			$i = M("order")->where("oid=".$oid)->getField("ostaus");
			if($i == 1){
				continue;
			}
			if(getIsbuy($pid) == 1){
				continue;
			}
			//止盈
			if($endprofit > 0)
			{
				if($ploss > 0)
				{
					if(($ploss/$payprice) >= $endprofit)
					{
						$acco= M('accountinfo');
						$acco->uid=$uid;
						$acco->balance=$myprice['balance']+$surplus;
						$acco->save();
						/**
						 * 写入记录
						 * 爆仓记录
						 * */
						$jour['jno'] = $orderno;			
						$jour['uid'] = $uid;
						$jour['jtype'] = '平仓';
						$jour['jtime'] = date(time());
						$jour['number'] = $onumber;
						$jour['remarks'] = $ptitle;
						$jour['balance'] = $myprice['balance']+$surplus;
						$jour['jusername'] = $username;
						$jour['jostyle'] = $ostyle;
						$jour['juprice'] = $uprice;
						$jour['jfee'] = $fee;
						$jour['jincome'] = $surplus;
						$jour['jbuyprice'] = $buyprice;
						if($cid==1){
							$jour['jsellprice'] = $yprice;	
						}elseif($cid==2){
							$jour['jsellprice'] = $byprice;
						}else{
							$jour['jsellprice'] = $toprice;
						}
						$jour['jaccess'] = $surplus;
						$jour['jploss'] = $ploss;
						if($ploss>0){$jour['jstate']=1;}else{$jour['jstate']=0;}
						$jour['oid'] = $oid;
						$jour['explain'] = '系统止盈';
						
						/**
						 * 保障金亏空，自动平仓
						 * 按盈亏比判断是否爆仓
						 * */
						//判断盈余是否为0，小于0表示保证金已经亏空自动平仓
						if($cid==1){
							$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$yprice,'ploss'=>$ploss,'is_hide'=>1));
						}elseif($cid==2){
							$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$byprice,'ploss'=>$ploss,'is_hide'=>1));
						}else{
							$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$toprice,'ploss'=>$ploss,'is_hide'=>1));
						}
						$jo->add($jour);
					}
				}
			}
			//止损
			if($endloss > 0)
			{
				if($ploss < 0)
				{
					if(abs($ploss/$payprice) >= $endloss)
					{
						$acco= M('accountinfo');
						$acco->uid=$uid;
						$acco->balance=$myprice['balance']+$surplus;
						$acco->save();
						/**
						 * 写入记录
						 * 爆仓记录
						 * */
						$jour['jno'] = $orderno;			
						$jour['uid'] = $uid;
						$jour['jtype'] = '平仓';
						$jour['jtime'] = date(time());
						$jour['number'] = $onumber;
						$jour['remarks'] = $ptitle;
						$jour['balance'] = $myprice['balance']+$surplus;
						$jour['jusername'] = $username;
						$jour['jostyle'] = $ostyle;
						$jour['juprice'] = $uprice;
						$jour['jfee'] = $fee;
						$jour['jincome'] = $surplus;
						$jour['jbuyprice'] = $buyprice;
						if($cid==1){
							$jour['jsellprice'] = $yprice;	
						}elseif($cid==2){
							$jour['jsellprice'] = $byprice;
						}else{
							$jour['jsellprice'] = $toprice;
						}
						$jour['jaccess'] = $surplus;
						$jour['jploss'] = $ploss;
						if($ploss>0){$jour['jstate']=1;}else{$jour['jstate']=0;}
						$jour['oid'] = $oid;
						$jour['explain'] = '系统止盈';
						
						/**
						 * 保障金亏空，自动平仓
						 * 按盈亏比判断是否爆仓
						 * */
						//判断盈余是否为0，小于0表示保证金已经亏空自动平仓
						if($cid==1){
							$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$yprice,'ploss'=>$ploss,'is_hide'=>1));
						}elseif($cid==2){
							$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$byprice,'ploss'=>$ploss,'is_hide'=>1));
						}else{
							$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$toprice,'ploss'=>$ploss,'is_hide'=>1));
						}
						$jo->add($jour);
					}
				}
			}
			//判断是否爆仓
			if($ploss < 0)
			{
				if(abs($ploss) >= $payprice ){
					/*** 写入爆仓记录***/
					$jour['jno'] = $orderno;			
					$jour['uid'] = $uid;
					$jour['jtype'] = '自动爆仓';
					$jour['jtime'] = date(time());
					$jour['number'] = $onumber;
					$jour['remarks'] = $ptitle;
					$jour['balance'] = $shengmoney;
					$jour['jusername'] = $username;
					$jour['jostyle'] = $ostyle;
					$jour['juprice'] = $uprice;
					$jour['jfee'] = 0;
					$jour['jincome'] = $surplus;
					$jour['jbuyprice'] = $buyprice;
					if($cid==1){
						$jour['jsellprice'] = $yprice;	
					}elseif($cid==2){
						$jour['jsellprice'] = $byprice;
					}else{
						$jour['jsellprice'] = $toprice;
					}
					$jour['jaccess'] = 0;
					$jour['jploss'] = '-'.$payprice;
					$jour['jstate']=0;
					$jour['oid'] = $oid;
					$jour['explain'] = '系统自动爆仓';
					
					/**
					 * 保障金亏空，自动平仓
					 * 按盈亏比判断是否爆仓
					 * */
					//判断盈余是否为0，小于0表示保证金已经亏空自动平仓
					if($cid==1){
						$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$yprice,'ploss'=>$payprice*(-1),'is_hide'=>1));
					}elseif($cid==2){
						$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$byprice,'ploss'=>$payprice*(-1),'is_hide'=>1));
					}else{
						$orders->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$toprice,'ploss'=>$payprice*(-1),'is_hide'=>1));
					}
					$jo->add($jour); 
				}else{
					continue;
				}
			}else{
				continue;
			}
		}
		echo "自动检测爆仓完成！";
	}
	//返金系统
	public function backMoney($oid,$type,$ploss,$fee)
	{
		$field = "o.uid,o.fee.o.ploss,u.otype,u.ouid,o.onumber,p.uprice,o.oid,o.";
		$order = M("order o")->field($field)->join("wp_userinfo u on o.uid=u.uid")->join("wp_productinfo p on p.pid = o.pid")->where("o.oid=".$oid)->find();
		if($order['otype'] != 0)
		{
			return true;
		}
		$payprice = $order['onumber']*$order['uprice'];//保证金
		$ploss = $order['ploss'];//盈亏资金
		$fee   = $order['fee'];//手续费
		$ouid  = $order['ouid']; //会员单位uid
		$uppre = M("userinfo")->where("uid=".$ouid)->find();
		$rebate = $uppre['rebate'];//盈亏返点比
		$feerebate = $uppre['feerebate'];//手续费返点比
		$gefeebate = $uppre['gefeebate'];//隔夜利息反比
		$upone = M("userinfo")->join("wp_accountinfo on wp_accountinfo.uid = wp_userinfo.uid")->where("uid=".$order['oid'])->find();
		if($upone['otype'] = 1){//上级是经纪人
			$uponerebate = $upone['rebate']/100;
			$uponefeerebate = $upone['feerebate']/100;
			if($ploss > 0){//赚
				$jaccess = $fee*$uponefeerebate;
				$uponeshengmoney = $upone['balance']+$jaccess; 
				addshuju($oid,3,$order['uid'],$uponeshengmoney,$jaccess,$ploss);
			}
			
			$uptwo = M("userinfo")->join("wp_accountinfo on wp_accountinfo.uid = wp_userinfo.uid")->where("uid=".$upone['oid'])->find();//经纪人上级必须有普通会员
			$uptworebate = $uptwo['rebate']/100;
			$uptwofeerebate = $uptwo['feerebate']/100;
			$upstr = M("userinfo")->join("wp_accountinfo on wp_accountinfo.uid = wp_userinfo.uid")->where("uid=".$uptwo['oid'])->find();//普通会员上级必须有会员单位
			$upstrrebate = $upstr['rebate']/100;
			$upstrfeerebate = $upstr['feerebate']/100;
		}else if($upone['otype'] = 4){//上级是普通会员
			
		}else if($upone['otype'] = 2){//上级是会员单位
			
		}
		
		
	}
	public function addshuju($oid,$type,$uid,$shengmoney,$jaccess,$ploss,$gefee){
		if($type == 1){
			$jtype = "隔夜利息扣除";
		}else if($type == 2){
			$jtype = "盈亏资金返金";
		}else if($type == 3){
			$jtype = "手续费返金";
		}else if($type == 4){
			$jtype = "隔夜负值平仓";
		}
		$detailed = A('Home/Detailed');
		$orderno = $detailed->build_order_no();
		$field ="wp_order.onumber,wp_productinfo.ptitle,wp_order.ostyle,wp_productinfo.uprice,wp_order.buyprice,wp_order.sellprice";
		$username = M("userinfo")->where("uid=".$uid)->getField('username');
		$order = M("order")->field($field)->join("wp_productinfo on wp_productinfo.pid = wp_order.pid")->where("wp_order.oid=".$oid)->find();
		$jour['jno'] = $orderno;			
		$jour['uid'] = $uid;
		$jour['jtype'] = $jtype;
		$jour['jtime'] = date(time());
		$jour['number'] = $order['onumber'];
		$jour['remarks'] = $order['ptitle'];
		$jour['balance'] = $shengmoney;
		$jour['jusername'] = $username;
		$jour['jostyle'] = $order['ostyle'];
		$jour['juprice'] = $order['uprice'];
		$jour['jfee'] = 0;
		$jour['jincome'] = $order['onumber']*$order['uprice'];
		$jour['jbuyprice'] = $order['buyprice'];
		$jour['jsellprice'] = $order['sellprice'];	
		$jour['jaccess'] = $jaccess;
		$jour['jploss'] = $ploss;
		if($ploss > 0){
			$jour['jstate']=1;
		}else{
			$jour['jstate']=0;
		}
		if($gefee > 0){
			$jour['gefee']='-'.$gefee;
		}else{
			$jour['gefee']=0;
		}
		$jour['explain'] = $jtype;
		M("journal")->add($jour); 
	}
	public function gefee($oid,$uid,$balance,$gefee,$surplus,$ploss,$overday1,$buytime1,$byprice){
		//隔夜利息
		$nowtime = strtotime(date("Y-m-d 00:00:00",time()));
		$buyt = strtotime(date("Y-m-d 00:00:00",$buytime1));
		$overday = ($nowtime-$buyt)/86400;
		
		$a = date("Y-m-d",time());
		$aa = strtotime($time." 04:00:00");
		if(time() < $aa){
			return true;
		}
		if(!$overday1){
			if($overday > 0 ){
				$newd['balance'] = $balance-$gefee;
				if($newd['balance'] < 0){
					$shengmoney = $balance+$surplus;
					//余额为负值平仓
					$this->addshuju($oid,4,$uid,$shengmoney,$surplus,$ploss,$gefee);
					M("order")->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$byprice,'ploss'=>$ploss,'is_hide'=>1));
				}else{
					M("accountinfo")->where("uid=".$uid)->save($newd);
					$this->addshuju($oid,1,$uid,$newd['balance'],0,0,$gefee);
					$data['overday'] = 1;
					$data['gefee'] = $gefee;
					M("order")->where("oid=".$oid)->save($data);
					//第一次扣费
				}
			}
		}else{
			if($overday > 0){//过期超过1天
				//第二次扣费
				if($overday > $overday1){
					$nd['balance'] = $balance-$gefee;
					if($nd['balance'] < 0){
						//余额为负值平仓
						$shengmoney = $balance+$surplus;
						$this->addshuju($oid,4,$uid,$shengmoney,$surplus,$ploss,$gefee);
						M("order")->where('oid='.$oid)->setField(array('selltime'=>date(time()),'ostaus'=>'1','sellprice'=>$byprice,'ploss'=>$ploss,'is_hide'=>1));
					}else{
						//第N次扣费
						M("accountinfo")->where("uid=".$uid)->save($nd);
						$this->addshuju($oid,1,$uid,$nd['balance'],0,0,$gefee);
						//更新订单隔夜利息扣款次数
						$data['overday'] = $overday;
						$data['gefee'] = $gefee;
						M("order")->where("oid=".$oid)->save($data);
					}
				}
			}
		}
	}
	
	}