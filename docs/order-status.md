---
layout: post
title:  "订单状态"
date:   2018-09-19 09:44:45 +0800
category: order
---

{:toc}

## 订单状态(bizData)

业务状态码(bizCode)  | 数据库状态码(orderStatus) | 状态说明               |title(买家)        |title(卖家)        |text(买家)              |text(卖家)              |countDownTpl                        |express           |actions         |actions说明         
--------- |----------  | ----------------------|------------|----------------- |-----------------| ----------------|--------------|--------------|--------------|--------------
1         | **1**    | 等待付款                 |等待我付款      |      | 等待我付款        |         | 请在{time}内付款，逾期系统自动取消订单 | 无               | `cancel` `pay`  | `取消订单` `立即付款` 
2         | **2**  order.extension = 0 | 等待卖家发货             |等待卖家发货      |      | 我已付款，等待卖家发货 |  | 无 | 卖家正在备货         | `refund` `notifySendGoods` | `申请退款` `提醒发货` 
3        | **2**  order_count.likes < order.require_likes | 待成团               |待成团        |        | 待成团        |         | 无 | 无               | 无 | 无 
4        | **2** order_count.likes >= order.require_likes | 集赞成功               |集赞成功      |      | 集赞成功        |         | 无 | 无               | `refund` `notifySendGoods` | `申请退款` `提醒发货` 
5         | **4**    | 等待我收货              |等待我收货      |      | 卖家已发货，等待我收货 |  | 请在{time}内确认收货，逾期系统自动确认 | 最后一条物流动态 | `returnGoods` `expandReceivedTime` `confirmReceived` | `申请退货退款` `延长收货` `确认收货` 
6        | (16, 20) order_refund.type = 1 and order.ship_time = 0 | 申请退款(未发货)         |申请退款中(未发货)      |      | 退款申请已提交，等待卖家处理 |  | {time}内卖家不处理，系统默认同意申请 | 无               | `agreedDetail` `refundDetail` | `查看协商记录` `退款详情` 
7        | (16, 20) order_refund.type = 1 and order.ship_time > 0       | 申请退款(已发货)        |申请退款中(已发货)      |      | 退款申请已提交，等待卖家处理 |  | {time}内卖家不处理，系统默认同意申请 | 最后一条物流动态      | `agreedDetail` `refundDetail` | `查看协商记录` `退款详情` 
8         | **11,12** order_evaluation null and order.return_flag = 0 | 交易完成(待评价)         |交易完成      |      | 待评价     |      | 无 | 最后一条物流动态      | `review`  | `去评价` 
9         | **11,12** order_evaluation not null and order.return_flag = 0 | 交易完成(已评价)         |交易完成(买家收货/10天自动收)     |     | 交易完成    |     | 无 | 无               | 无 | 无 
10         | **15** order.extension = 0 AND order_log.type = 0 AND order_log.handle_id =  0 | 交易取消(系统取消)       |交易取消      |      | 交易取消    |     | 因超时未付款，系统自动取消订单 | 无               | 无 | 无 
11         | **15** order_log.type = 1 | 交易取消(买家取消)       |交易取消      |      | 交易取消    |     | 买家主动取消订单 | 无               | 无 | 无 
12         | **15** order_log.type = 2 AND order.return_flag = 0 | 交易取消(卖家取消)       |交易取消      |      | 交易取消    |     | 卖家主动取消订单(未付款) | 无               | 无 | 无 
13         | **15** order_log.type = 2 AND order.return_flag = 2 AND order_refund.agree = 0 | 交易取消(全额退款)       |交易取消      |      | 交易取消    |     | 全额退款成功，订单取消(无申请) | 无               | `refundDetail` | `查看退款详情` 
14 | **15** order.extension = 1 AND order_log.type = 0 | 交易取消(成团失败) |交易取消 | | 交易取消 |  | 全额退款成功，订单取消 | 无 | `refundDetail` | `查看退款详情` 
15        | (16, 20) order_refund.type = 2 | 申请退货退款           |申请退货中      |      | 退货申请已提交，等待卖家处理 |  | {time}内卖家不处理，系统默认同意申请 | 最后一条物流动态      | `agreedDetail` `refundDetail` | `查看协商记录` `查看退款详情` 
16        | (17) | 同意退货              |等待我退货      |      | 卖家同意退货，等待我处理 |  | 您需在{time}内处理，逾期默认撤销退款申请 | 最后一条物流动态       | `cancelReturnGoods` `sendReturnGoods` | `撤销申请` `发出退货` 
17        | (18)     | 已发退货             |等待卖家收货      |      | 我已发出退货，等待卖家收货 |  | 卖家需在{time}内确认收货，逾期自动收货 | 无               | `agreedDetail` `returnGoodsExpress` | `查看协商记录` `退货物流` 
18        | (19) order_refund.type = 1 | 卖家拒绝退款           |卖家拒绝退款      |      | 卖家拒绝退款，等待我处理 |  | 您需在{time}内处理，逾期默认撤销退款申请 | 最后一条物流动态      | `agreedDetail` `queryRefund` | `查看协商记录` `去处理退款申请` 
19        | (19) order_refund.type = 2 | 卖家拒绝退货           |卖家拒绝退货     |     | 卖家拒绝退货，等待我处理 |  | 您需在{time}内处理，逾期默认撤销退货申请 | 最后一条物流动态       | `agreedDetail` `queryReturnGoods` | `查看协商记录` `去处理退货申请` 
20        | (21) order_refund.type = 1 | 卖家同意退款            |退款结算中(同意退款/2天自动同意)      |      | 退款结算中   |    | 卖家同意退款，衣联系统正在结算 | 无               | `refundDetail` | `查看退款详情` 
21        | (21) order_refund.type = 2 | 收到退货             |退款结算中(卖家收货/10天自动收)      |      | 退款结算中   |    | 卖家确认收到退货，衣联系统正在结算 | 无               | `refundDetail` | `查看退款详情` 
22        | (22) order_arbitrate.status is null or != 1 | 买家申请仲裁         |客服介入处理      |      | 我已申请衣联客服介入 |  | 客服会在3个工作日内介入处理，请耐心等待 | 最后一条物流动态       | `cancelArbitrate` | `撤销介入申请` 
23        | (22) order_arbitrate.status = 1 and order_arbitrate.apply_flag = 1 | 客服介入中(买家申请) |客服介入处理      |      | 衣联客服已介入处理，请耐心等待 |  | 客服会联系您了解情况，请保持联系方式畅通 | 最后一条物流动态       | 无 | 无 
24        | (23) order_arbitrate.status is null or != 1 | 卖家申请仲裁         |客服介入处理      |      | 卖家申请衣联客服介入 |  | 客服会在3个工作日内介入处理，请耐心等待 | 最后一条物流动态       | 无 | 无 
25        | **12**(25) order_arbitrate.blame_flag = 1 | 客服介入完成(钱给买家)  |交易取消      | 交易取消 | 客服介入处理完毕 | 客服介入处理完毕 | 无 | 无               | `review`                                           | `待评价`                              
26        | **12**(25) order_arbitrate.blame_flag = 2 | 客服介入完成(钱给卖家)   |交易完成      |      | 客服介入处理完毕 | 客服介入处理完毕 | 无 | 无               | `review`                                           | `待评价`                              
27        |**12**(25) order_arbitrate.blame_flag = 3  | 客服介入完成(退一部分)   |交易完成      |      | 客服介入处理完毕 | 客服介入处理完毕 | 无 | 无               | `review` | `待评价` 
28        |**12**(25) order_arbitrate.blame_flag = 4  | 客服介入完成(财务处理) |交易完成      |      | 客服介入处理完毕 | 客服介入处理完毕 | 其他具体原因 | 无               | `review` | `待评价` 
29 | **12**(25) order_arbitrate is null | 退货退款交易完成(无平台介入) |交易完成 | | 交易完成 |  | 无 | 无 | `review` | `待评价` 
30 | (22) order_arbitrate.status = 1 and order_arbitrate.apply_flag = 2 | 客服介入中(卖家申请) |客服介入处理 | | 衣联客服已介入处理，请耐心等待 |  | 客服会联系您了解情况，请保持联系方式畅通 | 最后一条物流动态 | 无 | 无 
31 | **15** order.extension = 0 AND order_log.type = 0 AND order_log.handle_id >  0 | 交易取消(管理员操作) |交易取消 | | 交易取消 |  | 因超时未付款，系统自动取消订单 | 无 |  |  
32 | **15** order_log.type = 2 AND order.return_flag = 2 AND order_refund.agree > 0 | 交易取消(全额退款) |交易取消 | | 交易取消 | | 全额退款成功，订单取消(有申请) | 无 | `refundDetail` | `查看退款详情` 

### 返回数据字段说明

字段名              | 类型    | 说明
-------------------|-----------|-------
bizCode | int | 业务编号 
orderStatus | int | 订单状态 
title              | string   | 订单状态标题
text               |  string        | 订单状态描述
countDown          | int |       倒计时(秒)
countDownTpl       |string |  倒计时模板(模板变量 {time})
express            |string |  快递信息
expressTime        | int | 快递信息的时间戳(秒)
note               | string | 留言
actions            | list | 支持的操作<返回数据actions说明>

> bizData示例

```json
{
    "bizCode": 4,
    "orderStatus": 2,
    "title":"等待我发货",
    "text":"等待我付款",
    "countDown": 158838, 
    "countDownTpl":"请在{time}内付款，逾期系统自动取消订单",  
    "express":"",
    "expressTime":0,
    "note":"你买个表",
    "actions":[
        {"btn":"cancel", "name":"取消订单"},
        {"btn":"pay", "name":"立即支付"}
    ]
}
```

