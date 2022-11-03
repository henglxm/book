---
description: 风铃发卡系统对接教程
---

# 风铃-发卡系统

项目地址：[https://github.com/Tai7sy/card-system](https://github.com/Tai7sy/card-system)​

进入后台 -> 渠道设置 -> 添加

## 支付宝

驱动： `Epay` 方式： `alipay` 配置： `JSON`

```
{
  "gateway": "https://www.ipays.cc",
  "pid": "商户ID",
  "key": "商户KEY"
}
```

### &#x20;<a href="#wei-xin-zhi-fu" id="wei-xin-zhi-fu"></a>

## 微信支付

驱动： `Epay` 方式： `wxpay` 配置： `JSON`

```
{
  "gateway": "https://www.ipays.cc",
  "pid": "商户ID",
  "key": "商户KEY"
}
```

