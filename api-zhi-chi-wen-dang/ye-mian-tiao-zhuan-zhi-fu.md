---
description: 此接口可用于用户前台直接发起支付，使用form表单跳转或拼接成URL跳转。
---

# 页面跳转支付

URL地址：`https://www.ipays.cc/submit.php`POST数据：`pid={商户ID}&type={支付方式}&out_trade_no={商户订单号}&notify_url={服务器异步通知地址}&return_url={页面跳转通知地址}&name={商品名称}&money={金额}&sign={签名字符串}&sign_type=MD5`请求参数说明：

| 字段名    | 变量名            | 必填 | 类型     | 示例值                              | 描述        |
| ------ | -------------- | -- | ------ | -------------------------------- | --------- |
| 商户ID   | pi             | 是  | Int    | 1001                             | ​         |
| 支付方式   | type           | 是  | String | alipay                           | ​支付方式列表​  |
| 商户订单号  | out\_trade\_no | 是  | String | 20160806151343349                | ​         |
| 异步通知地址 | notify\_url    | 是  | String | http://xxx.com/notify\_url.php   | 服务器异步同步地址 |
| 跳转通知地址 | return\_url    | 是  | String | http://xxx.com/return\_url.php   | 页面跳转通知地址  |
| 商品名称   | name           | 是  | String | VIP会员                            | ​         |
| 商品金额   | money          | 是  | String | 99.00                            | ​         |
| 业务扩展参数 | param          | 否  | String | 没有请留空                            | 支付后原样返回   |
| 签名字符串  | sign           | 是  | String | 202cb962ac59075b964b07152d234b70 | 签名算法（查看）  |
| 签名类型   | sign\_type     | 是  | String | MD5                              | 默认为MD5    |
