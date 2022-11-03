# 支付结果通知

通知类型：服务器异步通知（notify\_url）、页面跳转通知（return\_url）

请求方式：GET

请求参数说明：

| 字段名	   | 变量名	           | 必填	 | 类型	    | 示例值	                             | 描述                  |
| ------ | -------------- | --- | ------ | -------------------------------- | ------------------- |
| 商户ID   | pid            | 是   | Int    | 1001                             |                     |
| 支付订单号  | trade\_no      | 是   | String | 20200806151343349021             | Pay Fament订单号       |
| 商户订单号  | out\_trade\_no | 是   | String | 20200806151343349                | 商户系统内部的订单号          |
| 支付方式   | type           | 是   | String | alipay                           | 支付方式列表              |
| 商品名称   | name           | 是   | String | VIP会员                            |                     |
| 商品金额   | money          | 是   | String | 99.00                            |                     |
| 支付状态   | trade\_status  | 是   | String | TRADE\_SUCCESS                   | 只有TRADE\_SUCCESS是成功 |
| 业务扩展参数 | param          | 否   | String |                                  |                     |
| 签名字符串  | sign           | 是   | String | 202cb962ac59075b964b07152d234b70 | 签名算法与支付宝签名算法相同      |
| 签名类型   | sign\_type     | 是   | String | MD5                              | 默认为MD5              |

收到异步通知后，需返回success以表示服务器接收到了订单通知
