## 买家订单状态(bizData)

业务状态码(bizCode)  | 数据库状态码(orderStatus) | 状态说明               |title        |text              |countDownTpl                        |express           |actions         | 返回数据示例
--------- |----------  | ----------------------|:------------:|----------------- | -----------------------------------|-----------------| ----------------|--------------
1         | 1        | 等待付款                 |等待我付款      | 等待我付款        | 请在{time}内付款，逾期系统自动取消订单 | 无               | `cancel` `pay`  | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
2         | 2        | 等待卖家发货             |等待卖家发货      | 我已付款，等待卖家发货 | 无 | 卖家正在备货         | `refund` `notifySendGoods` | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
3         | 4        | 等待我收货              |等待我收货      | 卖家已发货，等待我收货 | 请在{time}内确认收货，逾期系统自动确认 | 最后一条物流动态 | `returnGoods` `expandReceivedTime` `confirmReceived` | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
4         | 12       | 交易完成(待评价)         |交易完成      | 待评价     | 无 | 最后一条物流动态      | `review`  | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
5         | 12       | 交易完成(已评价)         |交易完成(买家收货/10天自动收)     | 交易完成    | 请在{time}内付款，逾期系统自动取消订单 | 无               |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
6         | 15       | 交易取消(系统取消)       |交易取消      | 交易取消    | 因超时未付款，系统自动取消订单 | 无               |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
7         | 15       | 交易取消(买家取消)       |交易取消      | 交易取消    | 买家主动取消订单 | 无               |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
8         | 15       | 交易取消(卖家取消)       |交易取消      | 交易取消    | 卖家主动取消订单 | 无               |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
9         | 15       | 交易取消(全额退款)       |交易取消      | 交易取消    | 全额退款成功，订单取消 | 无               | `refundDetail` | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
10        | 6        | 申请退款(未发货)         |申请退款中（未发货）      | 退款申请已提交，等待卖家处理 | {time}内卖家不处理，系统默认同意申请 | 无               | `agreedDetail` `refundDetail` | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
11        | 6        | 申请退款(已发货)        |申请退款中（已发货）      | 退款申请已提交，等待卖家处理 | {time}内卖家不处理，系统默认同意申请 | 最后一条物流动态      | `agreedDetail` `refundDetail` | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
12        | 21       | 卖家同意退款            |退款结算中（同意退款/2天自动同意）      | 退款结算中   | 卖家同意退款，衣联系统正在结算 | 无               | `refundDetail` | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
13        | 19       | 卖家拒绝退款           |卖家拒绝退款      | 卖家拒绝退款，等待我处理 | 您需在{time}内处理，逾期默认撤销退款申请 | 最后一条物流动态      |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
14        | 16       | 申请退货退款           |申请退货中      | 退货申请已提交，等待卖家处理 | {time}内卖家不处理，系统默认同意申请 | 最后一条物流动态      |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
15        | 19       | 卖家拒绝退货           |卖家拒绝退货     | 卖家拒绝退货，等待我处理 | 您需在{time}内处理，逾期默认撤销退货申请 | 最后一条物流动态       |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
16        | 17       | 同意退货              |等待我退货      | 卖家同意退货，等待我处理 | 您需在{time}内处理，逾期默认撤销退款申请 | 最后一条物流动态       |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
17        | 18       | 已发退货             |等待卖家收货      | 我已发出退货，等待卖家收货 | 卖家需在{time}内确认收货，逾期自动收货 | 无               |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
18        | 21       | 收到退货             |退款结算中（卖家收货/10天自动收）      | 退款结算中   | 卖家确认收到退货，衣联系统正在结算 | 无               |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
19        | 22       | 买家申请仲裁         |客服介入处理      | 我已申请衣联客服介入 | 客服会在3个工作日内介入处理，请耐心等待 | 最后一条物流动态       |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
20        | 23       | 卖家申请仲裁         |客服介入处理      | 卖家申请衣联客服介入 | 客服会在3个工作日内介入处理，请耐心等待 | 最后一条物流动态       |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
21        | 22       | 客服介入中 |客服介入处理      | 衣联客服已介入处理，请耐心等待 | 客服会联系您了解情况，请保持联系方式畅通 | 最后一条物流动态       |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
22        | 22       | 客服介入完成(钱给买家)  |交易完成      | 客服介入处理完毕 | 无 | 无               |                                                      | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
23        | 23       | 客服介入完成(钱给卖家)   |交易完成      | 客服介入处理完毕 | 无 | 无               |                                                      | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
24        |22 or 23  | 客服介入完成(退一部分)   |交易完成      | 客服介入处理完毕 | 无 | 无               |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
25        |22 or 23  | 客服介入完成(财务处理) |交易完成      | 客服介入处理完毕 | 其他具体原因 | 无               |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
26        | 2        | 待成团               |待成团        | 待成团        | 无 | 无               |   | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`
27        | 2        | 集赞成功               |集赞成功      | 集赞成功        | 无 | 无               | `refund` `notifySendGoods` | `{"title":"等待我发货",text":"等待我付款", "countDown": 158838, "countDownTpl":"请在{time}内付款，逾期系统自动取消订单", "express":"","expressTime":0,"note":"你买个表", "actions":["cancel", "pay"]}`

### 返回数据字段说明

字段名              | 类型    | 说明
-------------------|-----------|-------
title              | string   | 订单状态标题
text               |  string        | 订单状态描述
countDown          | int |       倒计时(秒)
countDownTpl       |string |  倒计时模板(模板变量 {time})
express            |string |  快递信息
expressTime        | int | 快递信息的时间戳(秒)
note               | string | 留言
actions            | list | 支持的操作<返回数据actions说明>


> 返回数据actions说明

名称  | 含义
---------------------|----------
cancel               |    取消订单
pay                  | 立即付款
review               | 去评价
notifySendGoods      | 提醒发货

