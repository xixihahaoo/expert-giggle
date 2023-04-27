<?php 
// 测试账号
// return array(
// 	'merchantId'        => 1001508,  // 商户号
// 	'merchantPassword' => '11111111',  // 证书密码，用工具生成证书时6次输入的那个密码
// 	'gatewayUrl'       => 'https://123.56.119.177:8443/pay/pay.htm', // 支付接口url
// );

// 正式账号
return array(
	'merchantId'        => 168666999001200,  // 商户号
	'merchantPassword' => 'n3imvjtfd5k6h6k1',  // 证书密码，用工具生成证书时6次输入的那个密码
	'gatewayUrl'       => 'http://api.zhongnanpay.com:3022/hmpay/online/createWxOrder.do', // 支付接口url
        'gatewayUrlDaifu'       => 'http://api.zhongnanpay.com:3022/hmpay/online/createDFOrder.do', // 代付接口url
);
