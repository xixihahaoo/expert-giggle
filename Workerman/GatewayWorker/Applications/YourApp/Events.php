<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\DbConnection;
use \Workerman\Connection\AsyncTcpConnection;
use \Workerman\Lib\Timer;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{

        /**
     * AsyncTcpConnection websocket异步客户端
     * 接收消息转发
     * 
     * @param $businessWorker 
     */

    public static function onWorkerStart($businessWorker) {

      if ($businessWorker->id == 0) {
        
        global $db;

        $db     = new DbConnection('127.0.0.1', '3306', 'root', '0032d5a9f34989df', 'db_weiqihuo');

        self::getData();

      }
    }



    public static function getData()
    {
        global $db;

        $option = $db->select('group_concat(distinct(capital_key))')->from('wp_option')->column();

        $dataId = $option[0];

        $conn    = new AsyncTcpConnection('ws://39.107.99.235/ws');

        $conn->onConnect = function($conn) use($dataId)
        {

            $payload = json_encode(array(
                'event' => 'REG',
                'Key' => $dataId
            ));

            $conn->send($payload);
        };

        $conn->onMessage = function($conn, $msg) {

            $data = json_decode($msg, true);
            $data = $data['body'];
            $code = $data['StockCode'];


            if(!empty($code))
            {
                $post_data = array(
                    'Price'     => $data['Price'],
                    'Open'      => $data['Open'],
                    'Close'     => $data['LastClose'],
                    'High'      => $data['High'],
                    'Low'       => $data['Low'],
                    'Diff'      => $data['Diff'],
                    'DiffRate'  => $data['DiffRate'],
                    'edit_time' => $data['LastTime'],
                    'bp'        => $data['BP1'],
                    'bv'        => $data['BV1'],
                    'sp'        => $data['SP1'],
                    'sv'        => $data['SV1']
                );

                global $db;
                $db->update('wp_option')->cols($post_data)->where("capital_key = '$code'")->query();
            }

            $send_data = array(
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

            $message = json_encode($send_data);
            Gateway::sendToGroup($code,$message);

        };

        $conn->onClose = function($conn) {
            $conn->reConnect(1);
        };

        $conn->connect();
    }



    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id) {
        Gateway::sendToClient($client_id, json_encode(array(
            'type'      => 'init',
            'client_id' => $client_id
        )));
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message) {
        // 向所有人发送 
        //Gateway::sendToAll("$client_id said $message");
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id) {
       // 向所有人发送 
       //GateWay::sendToAll("$client_id logout");
   }
}
