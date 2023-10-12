<?php
namespace Workerman;
use \Workerman\Worker;
use \Workerman\Connection\AsyncTcpConnection;
require_once __DIR__ . '/Autoloader.php';
require_once __DIR__ . '/Mysql/Connection.php';
require_once __DIR__ . '/Gateway/Gateway.php';

$worker  = new Worker();

$worker->onWorkerStart = function($worker)
{

	global $Gateway,$db,$dataId;

	$Gateway = new Gateway\Gateway();
	$Gateway::$registerAddress = '127.0.0.1:1238';

	$db = new MySQL\Connection('127.0.0.1', '3306', 'root', 'hjba', 'db_hengjinbao');
    
	$option = $db->select('capital_key')->from('wp_option')->column();
	$dataArr = array();
	foreach ($option as $key => $value) {
		array_push($dataArr, $value);
	}

	$dataId = implode(',', $dataArr);

    $con = new AsyncTcpConnection('ws://data.ronmei.com:8888/ws');
    $con->onConnect = function($con) {
    	global $dataId;

    	$payload = json_encode(array(
            'event' => 'REG',
            'Key' => $dataId
        ));
        $con->send($payload);
    };

    $con->onMessage = function($con, $msg) {

        $data = json_decode($msg, true);
        $data = $data['body'];
        $code = $data['StockCode'];

        if(!empty($code))
        {
	    	$post_data = array(
	    		'Price' 	=> $data['Price'],
	    		'Open' 		=> $data['Open'],
	    		'Close' 	=> $data['LastClose'],
	    		'High' 		=> $data['High'],
	    		'Low' 		=> $data['Low'],
	    		'Diff' 		=> $data['Diff'],
	    		'DiffRate' 	=> $data['DiffRate'],
	    		'edit_time' => $data['LastTime'],
	    		'bp' 		=> $data['BP1'],
	    		'bv' 		=> $data['BV1'],
	    		'sp' 		=> $data['SP1'],
	    		'sv' 		=> $data['SV1']
	    	);
    	}

	    global $db,$Gateway;
	    
		$db->update('wp_option')->cols($post_data)->where("capital_key = '$code'")->query();

    	$send_data = array(
    		'capital_key' 	=> $code,
    		'Price' 		=> $data['Price'],
    		'Open' 			=> $data['Open'],
    		'Close' 		=> $data['LastClose'],
    		'High' 			=> $data['High'],
    		'Low' 			=> $data['Low'],
    		'Diff' 			=> $data['Diff'],
    		'DiffRate' 		=> $data['DiffRate'],
    		'edit_time' 	=> $data['LastTime'],
    		'bp' 			=> $data['BP1'],
    		'bv' 			=> $data['BV1'],
    		'sp' 			=> $data['SP1'],
    		'sv' 			=> $data['SV1'],
    		'TotalVol'  	=> $data['TotalVol']
    	);


		$message = json_encode($send_data);
		$Gateway::sendToGroup($code,$message);  //对客户端发送消息

    };


    $con->onClose = function($con) {
        $con->reConnect(1);
    };

    $con->connect();
};

Worker::runAll();
