---
description: SSPANEL MALIO 旧版对接教程
---

# SSPanel - Malio OLD

## 方法1 <a href="#fang-fa-1" id="fang-fa-1"></a>

{% hint style="success" %}
适用于`app/Services/Gateway/CustomPay.php` 存在的版本
{% endhint %}

{% file src=".gitbook/assets/CustomPay (2).php" %}

1. 替换 `app/Services/Gateway/CustomPay.php`
2. 在 `config/routes.php` 内的 `$app->run();` 前添加:

```
// Jshipay
$app->post('/Jshi_notify', 'App\Services\Payment:notify');
$app->get('/Jshi_notify', 'App\Services\Payment:notify');
$app->post('/Jshi_return', 'App\Services\Payment:returnhtml');
$app->get('/Jshi_return', 'App\Services\Payment:returnhtml');
// end of Jshipay
```

3\. 在 `.config.php` 下添加:

```
$_ENV['jshipid']  = 'xxx';// Ipays 商户号    xxx代表需要手动填写
$_ENV['jshikey']  = 'xxx';// Ipays 密钥    xxx代表需要手动填写
$_ENV['jshiapi']  = 'https://fps.cloudfament.co';
$_ENV['jshiname'] = '网站名称';
$_ENV['sitename'] = 'SSPANEL';
```

## 方法2 <a href="#fang-fa-2" id="fang-fa-2"></a>

{% hint style="success" %}
适用于`app/Services/Gateway/CustomPay.php` 不存在的版本
{% endhint %}

{% file src=".gitbook/assets/flyfoxpay.php" %}

1. 将压缩包内文件解压至 `Services/Gateway/`
2. 在 `config/.config.php` 里面找到相关内容并替换，在 `//其他面板显示设置` 这条注释上面

```
# flyfox
$_ENV['flyfoxpay'] = [
    'config' => [
        'hid'      => 'xxx',    // Ipays 商户号    xxx代表需要手动填写
        'key'      => 'xxx',    // Ipays 密钥    xxx代表需要手动填写
        'name'     => '网站名称',
        'sitename' => 'SSPANEL'
        
    ]
];
```
