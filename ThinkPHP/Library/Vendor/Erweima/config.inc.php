<?php 
// 测试账号
// return array(
// 	'merchantId'        => 1001508,  // 商户号
// 	'merchantPassword' => '11111111',  // 证书密码，用工具生成证书时6次输入的那个密码
// 	'gatewayUrl'       => 'https://123.56.119.177:8443/pay/pay.htm', // 支付接口url
// );

// 正式账号
return array(
	'merchantId'        => 820350248160003,  // 商户号
	'merchantPassword' => '6125B8A9EE6A6CADB2B6E87DBBE042C9',  // 证书密码，用工具生成证书时6次输入的那个密码
	'gatewayUrl'       => 'http://api.posp168.com/passivePay', // 支付接口url
        'gatewayUrlFuwuhao'       => 'http://api.posp168.com/openPay', // 支付接口url
        'gatewayUrlDaifu'       => 'http://api.zhongnanpay.com:3022/hmpay/online/createDFOrder.do', // 代付接口url
);
