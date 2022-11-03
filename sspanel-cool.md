---
description: SSPANEL COOL版对接教程
---

# SSPanel - Cool

{% file src=".gitbook/assets/SSPanel Cool.zip" %}

1. 把压缩包内的文件上传至Cool根目录
2. 在config.php支付下方添加内容

```
$_ENV['ipays']=[
    'partner'       => "你的商户号",               //Ipays 商户号
    'key'           => "你的商户Key",              //Ipays 商户key
    'sign_type'     => strtoupper('MD5'),
    'input_charset' => strtolower('utf-8'),
    'subjects'      => "油爆海鸥",                 //商品名称，目前无意义
    'transport'     => 'https',                   //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    'appname'       => $_ENV['appName'],
    'min_price'     => '1'                        //最小支付金额(请填正数)
];
```

3\. 在cool\_config.php支付中将支付宝和微信支付设置为`Ipays`

```
$Cool_Config['pay_alipay']     = 'ipays';     // 支付宝默认
$Cool_Config['pay_wxpay']      = 'ipays';     // 微信默认
$Cool_Config['pay_crypto']     = 'none';      // 数字货币支付
$Cool_Config['mix_amount']     = 0;           // 限制每次最低充值, 商店购买套餐不受此限制。（因为商店扣除余额后可能出现很低的金额）
```
