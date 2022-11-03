# \[API]查询商户信息

URL地址：`https://www.ipays.cc/api.php?act=query&pid={商户ID}&key={商户密钥}`请求参数说明：

| 字段名  | 变量名 | 必填 | 类型     | 示例值                              | 描述      |
| ---- | --- | -- | ------ | -------------------------------- | ------- |
| 操作类型 | act | 是  | String | query                            | 此API固定值 |
| 商户ID | pid | 是  | int    | 1001                             | ​       |
| 商户密钥 | key | 是  | String | 89unJUB8HZ54Hj7x4nUj56HN4nUzUJ8i | ​       |

返回结果：

| 字段名   | 变量名            | 类型         | 示例值                              | 描述                     |
| ----- | -------------- | ---------- | -------------------------------- | ---------------------- |
| 返回状态码 | code           | Int        | 1                                | 1为成功，其他为失败             |
| 商户ID  | pid            | int        | 1001                             | 所创建的商户ID               |
| 商户密钥  | key            | String(32) | 89unJUB8HZ54Hj7x4nUj56HN4nUzUJ8i | 所创建的商户密钥               |
| 商户状态  | active         | Int        | 1                                | 1为正常，0为封禁              |
| 商户余额  | money          | String     | 0.00                             | 商户所拥有的余额               |
| 结算方式  | type           | Int        | 1                                | 1:支付宝,2:微信,3:QQ,4:USDT |
| 结算账号  | account        | String     | admin@pay.com                    | 结算的支付宝账号               |
| 结算姓名  | username       | String     | 张三                               | 结算的支付宝姓名               |
| 订单总数  | orders         | Int        | 30                               | 订单总数统计                 |
| 今日订单  | order\_today   | Int        | 15                               | 今日订单数量                 |
| 昨日订单  | order\_lastday | Int        | 15                               | 昨日订单数量                 |
