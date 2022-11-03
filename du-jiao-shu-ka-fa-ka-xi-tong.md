---
description: 独角数卡对接文档
---

# 独角数卡-发卡系统

1、进入后台 → 配置 → 支付网关

### &#x20;<a href="#zhi-fu-bao" id="zhi-fu-bao"></a>

添加 → 支付名称【`支付宝扫码`】→ 支付标识【Ipays】→ 支付方式【跳转】→ 商户ID 【粘贴 Ipays 的商户ID】 → 商户key【粘贴 Ipays 的商户KEY】→ 支付处理路由【`/pay/yipay`】。选择启用，保存即可。

### &#x20;<a href="#wei-xin" id="wei-xin"></a>

添加 → 支付名称【`微信扫码`】→ 支付标识【Ipays】→ 支付方式【跳转】→ 商户ID 【粘贴 Ipays 的商户ID】 → 商户key【粘贴 Ipays 的商户KEY】→ 支付处理路由【`/pay/yipay`】。选择启用，保存即可。
