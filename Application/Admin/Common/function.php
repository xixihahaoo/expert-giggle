<?php
	function getIsbuy($mypid){
	$time = date("Y-m-d",time());
	if($mypid == 1 || $mypid == 2 || $mypid == 3){
		$ultime = strtotime($time." 09:30:00");
		$urtime = strtotime($time." 11:30:00");
		$dltime = strtotime($time." 13:00:00");
		$drtime = strtotime($time." 15:00:00");
		if((time() > $ultime && time() < $urtime) || (time() > $dltime && time() < $drtime))
		{
			return 0;
		}else{
			return 1;
		}
	}else{
		$m = date("Y-m",time());
		$a = date("Y",time());
		$ml = strtotime($a."-09-30 00:00:00");
		$mr = strtotime(($a+1)."-04-00 00:00:00");
		if(time() > $ml && time() < $mr){//夏令时9月底~4月
			$mltime = strtotime($time." 04:00:00");
			$mrtime = strtotime($time." 06:00:00");
			if(time() > $mltime && time() < $mrtime){
				return 1;
			}
		}else{
			$mltime = strtotime($time." 05:00:00");
			$mrtime = strtotime($time." 07:00:00");
			if(time() > $mltime && time() < $mrtime){
				return 1;
			}
		}
	}
	$y = date('w',time());
	if($y == 6 || $y == 0)
	{
		return 1;
	}
}
	function islogin(){
		
	  $uid=$_SESSION['userid'];
	  // $uid = $_COOKIE['userid'];
	  return $uid;
	  
	}
	
	function getDownuids($uid,$type=1){
		$oid=M('userinfo')->field('uid,username')->where('oid='.$uid." and otype!=0")->select();//查询当前用户下级所有非客户的uid
        for($i=0; $i<count($oid); $i++ ) {
			$oid[$i]=$oid[$i]['uid'];
		}
		
		if(!empty($oid)){//如果有,继续查询下级所有非客户的uid
			$oid1=M('userinfo')->where('oid in('.implode(',',$oid).') and ustatus=0 and otype!=0 and vertus = 1')->select();
			for($i=0; $i<count($oid1); $i++ ) {
				$oid1[$i]=$oid1[$i]['uid'];
			}
		}
		
		if(!empty($oid))
		{
			if(!empty($oid1))
			{
				$olds = array_merge(array_merge($oid,$oid1),array($uid));
			}else{
				$olds = array_merge($oid,array($uid));
			}
		}else{
			$olds = array($uid);
		}
		$us = M('userinfo')->where('oid in('.implode(',',array_filter($olds)).') and ustatus=0 and otype=0 and vertus = 1')->select();
		foreach ($us as $key => $value) {
    		$arruid[]=$value['uid'];
    	}
		
		if($type == 1)//下级所有客户，经纪人，普通会员，会员单位
		{
			$arruid = array_merge($arruid,$olds);
		}else{//下级所有客户
			$arruid = $arruid;
		}
		return $arruid;
	}

?>