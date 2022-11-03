---
description: SSPANEL MALIO主题对接教程
---

# SSPanel - Malio

{% file src=".gitbook/assets/SSPanel Malio.zip" %}

1. 把压缩包里的文件夹覆盖到malio根目录下
2. 编辑 `config/.config.php` 将支付渠道设置为 `$_ENV['payment_system']='MalioPay';`
3. 在下方添加以下内容

```php
$_ENV['ipays']=[
    'partner' => "xxx", //Ipays 商户号     xxx代表需要手动填写
    'key' => "xxx",      //Ipays 商户key    xxx代表需要手动填写
    'sign_type' => strtoupper('MD5'),
    'input_charset' => strtolower('utf-8'),
    'subjects' => "爆炒海鸥",
    'apiurl' => 'https://www.ipays.cc', 
    'transport' => 'https',
    'appname' => 'SSPanel',
    'min_price' => '1'      //最小支付金额(请填正数)
];
```

4\. 编辑 `config/.malio_config.php` 将支付方式设置为 `ipays`

```
// 支付宝目前支持 bitpayx | stripe | tomatopay | f2fpay | wolfpay | materialpay | payfament
$Malio_Config['mups_alipay'] = 'ipays';   // Malio 聚合支付系统里面的 支付宝 要用的支付平台  
// 微信支付目前支持 bitpayx | stripe | materialpay | payfament
$Malio_Config['mups_wechat'] = 'ipays';   // Malio 聚合支付系统里面的 微信支付 要用的支付平台
$Malio_Config['mups_qq']     = 'ipays';   // Malio QQ
```
