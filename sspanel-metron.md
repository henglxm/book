---
description: SSPanel - Metron 对接教程
---

# SSPanel - Metron

{% file src=".gitbook/assets/SSPanel-metron-payfament.zip" %}

​1、把压缩包里的文件上传至网站根目录

2、按照步骤添加

在 `config/config.php` 添加

```php
$_ENV['payfament']=[
    'partner' => "xxx", //商户号 （xxx代表需要手动填写的信息）
    'key' => "xxx", //商户key（xxx代表需要手动填写的信息）
    'apiurl' => "https://www.ipays.cc", 
    'sign_type' => strtoupper('MD5'),
    'input_charset' => strtolower('utf-8'),
    'subjects' => "饰品",                  //商品名称，没有实际意义，勿动
    'transport' => 'https',                   //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    'appname' => $_ENV['appName'],           //网站英文名
    'min_price' => '1'                       //最小支付金额(请填正数)
];

```

编辑 `config/.metron_setting.php` 将支付方式设置为 `payfament`

```php
$_MT['pay_alipay']     = 'ipays';        // 支付宝默认
$_MT['max_alipay_num'] = 0;     // 使用支付宝支付时, 金额大于等于设定值, 使用下方支付方式 (设置 0 不使用)
$_MT['max_alipay_pay'] = 'none';      // 支付金额大于上面设置的值时, 使用此支付方式

$_MT['pay_wxpay']      = 'ipays';      // 微信默认
$_MT['max_wxpay_num']  = 0;     // 使用微信支付时, 金额大于等于设定值, 使用下方支付方式 (设置 0 不使用)
$_MT['max_wxpay_pay']  = 'none';  // 支付金额大于上面设置的值时, 使用此支付方式


```
