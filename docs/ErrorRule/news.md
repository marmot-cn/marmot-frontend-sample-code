# 新闻类错误提示规范（1001-2000）


### ER-数字

**id**

错误的唯一id

**code**

程序用的错误状态码,用字符串表述

**title**

简短的,可读性高的问题总结.

**detail**

针对该问题的高可读性解释

**links**

可以在请求文档中取消应用的关联资源

---

* ER-1001: 新闻来源格式不正确
* ER-1002: 新闻内容格式不正确
* ER-1003 - ER-2000: 新闻类错误预留

### ER-1001

**id**

`1001`

**code**

`NEWS_SOURCE_FORMAT_ERROR`

**title**

新闻来源格式不正确

**detail**

新闻来源格式不正确

**links**

待补充

### ER-1002

**id**

`1002`

**code**

`NEWS_CONTENT_FORMAT_ERROR`

**title**

新闻内容格式不正确

**detail**

新闻内容格式不正确

**links**

待补充

### ER-1003 - ER-2000

用户通用错误预留字段