<?php
ini_set('date.timezone', 'Asia/Shanghai'); //设置时区

$db_host = '127.0.0.1';
$db_database = 'db_weiqihuo';
$db_username = 'root';
$db_password = '0032d5a9f34989df';
$connection = mysql_connect($db_host, $db_username, $db_password); //连接到数据库
mysql_query("set names 'utf8'"); //编码转化
if (!$connection) {
	die("could not connect to the database:</br>" . mysql_error()); //诊断连接错误
}
$db_selecct = mysql_select_db($db_database); //选择数据库
if (!$db_selecct) {
	die("could not to the database</br>" . mysql_error());
}

ignore_user_abort(); //关闭浏览器仍然执行
set_time_limit(0); //让程序一直执行下去
$interval = 80000; //每隔一定时间运行
do {

//计算用户的金额
	$option_price = "SELECT * FROM wp_option"; //查询所有产品
	$option_price = mysql_query($option_price);

	while ($row = mysql_fetch_array($option_price)) //将$option_price中的数据逐行转换成数组$row
	{
		$pid = $row['id']; //产品id
		$Price = $row['Price']; //最新价格
		$silver_price = "SELECT * from wp_order where ostaus = 0 and pid = " . $pid . " and display = 0"; //查询用户订单
		$silver_price = mysql_query($silver_price);
		while ($order = mysql_fetch_array($silver_price)) {

			$oid = $order['oid'];
            $sellprice = $order['ostyle'] == 0 ? $row['bp'] : $row['sp'];
            
			if ($order['ostyle'] == 0) {
				//0涨 1跌，

				$ploss = (round($row['bp'] - $order['buyprice'], 5) * $row['wave']) * $row['capital_dot_length']; //买涨金额
				$ploss * $order['onumber'];

			} else {

				$ploss = (round($order['buyprice'] - $row['sp'], 5) * $row['wave']) * $row['capital_dot_length']; //买跌金额
				$ploss = $ploss * $order['onumber'];
			}

			$silver = "UPDATE wp_order set ploss = " . $ploss . ",sellprice = ".$sellprice." WHERE  oid = " . $oid . " AND ostaus = 0";
			if (mysql_query($silver)) {

				//echo 'ok;';
			}


            //止损 止盈  时间 强制平仓
            if($ploss >= $order['endprofit'] || $ploss <= -$order['endloss'] || $row['sell_flag'] == 0 || $row['flag'] == 0 || $row['global_flag'] == 0){
                
                if($ploss >= $order['endprofit']){

					$price_top = ($order['endprofit'] / $row['wave']) / $row['capital_dot_length'];
					$ying = $order['ostyle'] == 0 ? $order['buyprice']+$price_top : ($order['buyprice']-$price_top);
					$close = "UPDATE wp_order set ostaus = '1', selltime = " . time() . ", sellprice = " . $ying . ",ploss = ".$order['endprofit']."  WHERE  oid = " . $oid . " AND ostaus = 0 and display = 0";
				}

				if($ploss <= -$order['endloss']){

					$price_up = ($order['endloss'] / $row['wave']) / $row['capital_dot_length'];
					$sun = $order['ostyle'] == 0 ? ($order['buyprice']-$price_up) : $order['buyprice']+$price_up;
					$close = "UPDATE wp_order set ostaus = '1', selltime = " . time() . ", sellprice = " . $sun . ",ploss = -".$order['endloss']."  WHERE  oid = " . $oid . " AND ostaus = 0 and display = 0";
				}

				if($row['sell_flag'] == 0 || $row['flag'] == 0 || $row['global_flag'] == 0){
                   
                    $date = date('Y-m-d H:i',time());
                    $date = strtotime($date);
                  	$close = "UPDATE wp_order set ostaus = '1', selltime = " . $date . ", sellprice = " . $sellprice . "  WHERE  oid = " . $oid . " AND ostaus = 0 and display = 0";
				}
				
                if(mysql_query($close)) {

                    // echo 'close';
                }

            }

		}

		// 对平仓的订单回款
		$Payment = "SELECT * FROM wp_order where ostaus = 1 AND pid = " . $pid . " AND display = 0";
		$Payment = mysql_query($Payment);
		if ($Payment) {

			while ($ensure = mysql_fetch_array($Payment)) {

				$ensure_id = $ensure['oid'];
				$uid = $ensure['uid'];

				$journal = 'select id from wp_journal where oid = '.$ensure_id.' and jtype = "平仓" and uid = '.$uid.'';
				$journal_result = mysql_query($journal);
                $journal_data   = mysql_fetch_array($journal_result);
                if(!$journal_data)
                {

				$setting = "SELECT datas from wp_setting where name = 'SYSTEM_CURRENCY_TYPE' ";

				$setting = mysql_query($setting);

				while ($qq = mysql_fetch_array($setting)) {

					$currency = $row['currency'];
					$cc = unserialize($qq['datas']);

					$rate = ($ensure['Bond'] + $ensure['ploss']) * $cc[$currency]['rate']; //总和转换人民币
					$profit = $ensure['ploss'] * $cc[$currency]['rate']; //盈亏金额
					$yingkui = $profit < 0 ? (abs($profit)) : -$profit; //计算运营商是否盈亏

				}

				$jl = 'select id from wp_journal where oid = '.$ensure_id.' and jtype = "平仓" and uid = '.$uid.'';
				$jr = mysql_query($jl);
                $jd   = mysql_fetch_array($jr);
                if($jd)
                {
                	continue;
                }

				$update = "UPDATE wp_order set display = 1,auto = 2  WHERE  `oid` = " . $ensure_id . " AND ostaus = 1";
				if (mysql_query($update)) {

					//取出运营中心的余额
					$exchange = exchange($uid, 2);
					$exchange = mysql_query("SELECT balance,uid FROM wp_accountinfo where uid = $exchange");
					$exchange_res = mysql_fetch_array($exchange);

					if ($ensure['type'] == '1') {

							//运营中心扣除
							$ress = "UPDATE wp_accountinfo set balance = balance+" . $yingkui . "  WHERE  uid = " . $exchange_res['uid'] . " ";
							mysql_query($ress);

							//用户金额扣除
							$accoun = "UPDATE wp_accountinfo set balance = balance+" . $rate . "  WHERE  uid = " . $uid . " ";
							//用户亏损计算
							if($profit >= 0) {
								 $income_total = abs($profit);
                                 $income = 'UPDATE wp_accountinfo set income_total = income_total+'.$income_total.' WHERE uid = '.$uid.'';
                                 mysql_query($income);
							} else {
                                 $loss_total = abs($profit);
                                 $loss = 'UPDATE wp_accountinfo set loss_total = loss_total+'.$loss_total.' WHERE uid = '.$uid.'';
                                 mysql_query($loss);
							}

						} else {
							$accoun = "UPDATE wp_accountinfo set gold = gold+" . $rate . "  WHERE  uid = " . $uid . " ";
						}

						if (mysql_query($accoun)) {
							//生成订单日志
							$res = "SELECT balance,gold FROM wp_accountinfo WHERE uid = " . $uid . " ";
							$result = mysql_query($res);
							while ($balance = mysql_fetch_array($result)) {

								if ($ensure['type'] == '1') {
									$gold = $balance['balance'];
								} else {
									$gold = $balance['gold'];
								}
							}

							$bond = $rate; //出入金额
							$ploss = $profit; //盈亏金额
							$jstate = $ensure['ploss'] > 0 ? 1 : 0;

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
                                            " . time() . mt_rand() . ",
                                            '平仓',
                                            uid,
                                            " . time() . ",
                                            number,
                                            remarks,
                                            type,
                                            " . $gold . ",
                                            " . $jstate . ",
                                            jusername,
                                            jostyle,
                                            juprice,
                                            jfee,
                                            jbuyprice,
                                            " . $ensure['sellprice'] . ",
                                            " . $bond . ",
                                            " . $ploss . ",
                                            oid,
                                            2
                                        FROM wp_journal
                                           where oid = " . $ensure['oid'] . " ";
							if (mysql_query($select)) {
													        //用户平仓流水表
		                        if ($ensure['type'] == 1) {
									$id = mysql_query("select last_insert_id() as last_insert_id");
									$last_id = mysql_fetch_array($id);
									if($last_id) {
										$jounal = mysql_query('SELECT uid,id,remarks FROM wp_journal where id = '.$last_id['last_insert_id'].'');
										$jour = mysql_fetch_array($jounal);
										$flow = "INSERT INTO wp_money_flow (`uid`,`type`,`oid`,`note`,`balance`,`op_id`,`dateline`) VALUES ($jour[uid],2,$jour[id],'用户对".$jour['remarks']."进行平仓增加[".$bond."]元',".$gold.",$jour[uid],".time().")";
										mysql_query($flow);
										//运营中心流水
										$operat_id = exchange($jour['uid'],2);
										$operate_loss = $yingkui >= 0 ? '增加['.$yingkui.']' : '扣除['.$yingkui.']';
										$operate_money = ($exchange_res['balance'] + $yingkui);
										$operat_flow = "INSERT INTO wp_money_flow (`uid`,`type`,`oid`,`note`,`balance`,`op_id`,`user_type`,`dateline`) VALUES (".$operat_id.",2,$jour[id],'用户对".$jour['remarks']."进行平仓".$operate_loss."元',".$operate_money.",$jour[uid],2,".time().")";
										mysql_query($operat_flow);
									}
								}
							}
					 	}
			       }
			    }
			}
		}
	}

	usleep($interval); //等待时间，进行下一次操作。
} while (true);

//取出运营中心
function exchange($user_id, $number) {

	$sql = "SELECT user_id,parent_user_id,user_type FROM wp_userinfo_relationship where user_id = $user_id ";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	if(isset($row))
	{
		if (trim($number) == 2) {

			if ($row['user_type'] != 5) {

				return exchange($row["parent_user_id"], $number);
			}
		}

		if(isset($row['user_id']))
		{
			return $row['user_id'];
		}
	} else {

		return null;
	}
}

mysql_close($connection); //关闭连接
