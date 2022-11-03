---
description: 此接口可用于服务器后端发起支付请求，会返回支付二维码链接或支付跳转URL。
---

# API接口支付

URL地址：`https://www.ipays.cc/mapi.php`

POST数据：`pid={商户ID}&type={支付方式}&out_trade_no={商户订单号}&notify_url={服务器异步通知地址}&return_url={页面跳转通知地址}&name={商品名称}&money={金额}&clientip={用户IP地址}&device={设备类型}&sign={签名字符串}&sign_type=MD5`

请求参数说明：

| 字段名	   | 变量名	           | 必填	 | 类型                | 示例值	                             | 描述                                             |
| ------ | -------------- | --- | ----------------- | -------------------------------- | ---------------------------------------------- |
| 商户ID   | pid            | 是   | In                | 1001                             |                                                |
| 支付方式   | type           | 是   | <p>String<br></p> | alipay                           | 支付方式列表                                         |
| 商户订单号  | out\_trade\_no | 是   | String            | 20160806151343349                |                                                |
| 异步通知地址 | notify\_url    | 是   | String            | http://xxx.com/notify\_url.php   | 服务器异步通知地址                                      |
| 跳转通知地址 | return\_url    | 否   | String            | http://www.com/return\_url.php   | 页面跳转通知地址                                       |
| 商品名称   | name           | 是   | String            | VIP会员                            |                                                |
| 商品金额   | money          | 是   | String            | 99.00                            |                                                |
| 用户IP地址 | clientip       | 是   | String            | 192.168.1.100                    | 用户发起的支付IP地址                                    |
| 设备类型   | device         | 否   | String            | pc                               | 根据当前用户浏览器的UA判断， 传入用户所使用的浏览器 或设备类型，默认为pc。设备类型列表 |
| 业务扩展参数 | param          | 否   | String            | 没有请留空                            | 支付后原样返回                                        |
| 签名字符串  | sign           | 是   | String            | 202cb962ac59075b964b07152d234b70 | 签名算法                                           |
| 签名类型   | sign\_type     | 是   | String            | MD5                              | 默认为MD5                                         |

返回结果（json）：

| 字段名	     | 变量名	      | 类型	    | 示例值	                                            | 描述                             |
| -------- | --------- | ------ | ----------------------------------------------- | ------------------------------ |
| 返回状态码    | code      | Int    | 1                                               | 1为成功，其他值为失败                    |
| 返回信息     | msg       | String |                                                 | 失败时返回原因                        |
| 订单号      | trade\_no | String | 20200806151343349                               | 支付订单号                          |
| 支付跳转url  | payurl    | String | http://fps.cloudfament.co/pay/wxpay/202010903/	 | 如果返回该字段，则直接跳转到该URL支付           |
| 二维码链接    | qrcode    | String | weixin://wxpay/bizpayurl?pr=04IPMKM             | 如果返回该字段，则根据该url生成二维码           |
| 小程序跳转url | urlscheme | String | weixin://dl/business/?ticket=xxx                | 如果返回该字段，则使用js跳转该url，可发起微信小程序支付 |

注：payurl、qrcode、urlscheme 三个参数只会返回其中一个。
