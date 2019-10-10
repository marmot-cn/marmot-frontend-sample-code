# 新闻管理接口示例

---

## 目录
* [参考文档](#参考文档)
* [参数说明](#参数说明)
* [接口示例](#接口示例)
	* [获取单条数据](#获取单条数据)
	* [获取列表数据](#获取列表数据)
	* [新增新闻](#新增新闻)
	* [编辑新闻](#编辑新闻)
	* [启用](#启用)
	* [禁用](#禁用)

## <a name="参考文档">参考文档</a>

* 项目字典
	* [通用项目字典](../Dictionary/common.md "通用项目字典")
	* [新闻项目字典](../Dictionary/news.md "新闻项目字典")
	* [委办局项目字典](../Dictionary/userGroup.md "委办局项目字典")

*  控件规范
	* [通用控件规范](../WidgetRule/common.md "通用控件规范")
	* [新闻控件规范](../WidgetRule/news.md "新闻控件规范")

* 错误规范
	* [通用错误规范](../ErrorRule/common.md "通用错误规范")
	* [新闻错误规范](../ErrorRule/news.md "新闻错误规范")

## <a name="参数说明">参数说明</a>


## <a name="参数说明">参数说明</a>
     
| 英文名称         | 类型        |请求参数是否必填  |  示例                                        | 描述            |
| :---:           | :----:     | :------:      |:------------:                                |:-------:       |
| title           | string     | 是            | 中央财经领导小组办公室副主任韩俊                   | 新闻标题         |
| source          | string     | 是            | 中国网财经                                     | 新闻来源         |
| content         | string     | 是            | 新闻内容                                       | 新闻内容         |
| publishUserGroup| array      |               | array('id'=>1, 'name'=>''发展和改革委员会)      | 发布委办局        |
| image           | array      | 是            | array("name"=>"新闻图片", "identify"=>"1.jpg") | 新闻图片         |
| attachments     | array      | 是            | array(array"name"=>"新闻附件", "identify"=>"1.doc")) | 新闻附件   |
| updateTime      | int        |               | 1535444931                                   | 更新时间         |
| creditTime      | int        |               | 1535444931                                   | 创建时间         |
| status          | int        |               | 0                                            | 状态  (0启用 -2禁用)|

## <a name="获取单条">获取单条</a>

### Request

**Url**

```
url:/api/news/{id}
```

**Method**

```
GET
```

### Response

**Status Success**

```json
{
    status: 1
}
```

**Properties**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| data       | 新闻信息     | array   |         |

**Properties data**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| title      | 新闻标题  　  | string |         |
| source     | 新闻来源 　   | string |         |
| content    | 新闻内容      | string |         |
| publishUserGroup | 新闻发布委办局 | array |    |
| status     | 状态  　      | int    |         |
| image      | 新闻图片  　   | array  |         |
| attachments| 新闻附件  　   | array  |         |
| createTime | 创建时间  　   | int    |         |
| updateTime | 更新时间  　   | int    |         |

**Properties image**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| name       | 图片名称  　  | string |         |
| identify   | 图片地址 　   | string |         |

**Properties attachments**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| name       | 附件名称  　  | string |         |
| identify   | 附件地址  　  | string |         |

**Properties publishUserGroup**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| name       | 委办局名称  　| string |         |

**示例**

	{
		"status": 1,
		"data": {
			"id": "MA",
			"title": "中央财经领导小组办公室副主任韩俊:农村金融要为农村服务",
			"source": "中国网财经",
			"createTime": 1535444931,
			"updateTime": 1535447167,
			"status": 0,
			"content": "中央财经领导小组办公室副主任韩俊:农村金融要为农村服务",
			"publishUserGroup": {
				"id": "MA",
				"name": "萍乡市发展和改革委员会"
			},
			"image": {
				"name": "新闻图片",
				"identify": "o_1cli98qc9dfud59mf5ivkgm9r.jpg"
			},
			"image": "2.jpg",
			"attachments": [
				{
					"name": "关于印发《体育市场黑名单管理办法》通知",
					"identify": "关于印发《体育市场黑名单管理办法》通知.docx"
				}
			]
		}
	}

## <a name="获取列表">获取列表</a>

### Request

**Url**

```
url:/api/news
```

**Method**

```
GET
```

**Parameters:** 

```json
{
	"page": 1,
	"limit": 10,
	"search": ["新闻标题"]
}
```

### Response

**Status Success**

```json
{
    status: 1
}
```

**Properties**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| total      | 总数        | int     |         |
| list       | 列表         | array  |         |

**Properties list**

| Properties  | Description | Type   | default |
| :---:       | :----:      | :----: | :----:  |
| id          | 新闻id       | string |         |
| title       | 新闻标题  　| string |         |
| source   | 新闻来源 　| string |         |
| updateTime  | 更新时间      | int    |         |
| publishUserGroup   | 新闻发布委办局 　| array |         |
| status       | 状态  　| int |         |

**Properties publishUserGroup**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| name       | 委办局名称  　| string |         |

**示例**

	{
		"status": 1,
		"data": {
			"total": 2,
			"list": [
				{
					"id": "MQ",
					"title": "中央财经领导小组办公室副主任韩俊:农村金融要为农村服务",
					"source": "中国网财经",
					"updateTime": 1535447689,
					"status": 0,
					"publishUserGroup": {
						"id": "MA",
						"name": "萍乡市发展和改革委员会"
					},
				},
				{
					"id": "MA",
					"title": "中央财经领导小组办公室副主任韩俊",
					"source": "中国网财经",
					"updateTime": 1535447167,
					"status": 0,
					"publishUserGroup": {
						"id": "MA",
						"name": "萍乡市发展和改革委员会"
					},
				}
			]
		}
	}

## <a name="新增新闻">新增新闻</a>

### Request

**Url**

```
url:/api/news/add
```

**Method**

```
POST
```

**Parameters:** 

```json
{
    "title": "新闻标题",
    "source": "新闻来源",
    "publishUserGroup": "MA",
    "image": {
    	"name":"图片名称",
    	"identify":"图片地址"
    },
    "attachments": [
		{"name":"附件名称","identify":"附件地址"},
		{"name":"附件名称","identify":"附件地址"},
		{"name":"附件名称","identify":"附件地址"}
	],
	"content": "内容",
}
``` 

### Reponse

**Status Success**

```json
{
    status: 1
}
```

**示例**

	{"status":1,"data":[]}

**Status Error**

```json
{
    status: 0
}
```

**Properties**

| Properties | Description | Type   | default |
| :---:      | :----       | :----: | :----:  |
| id         | 错误ID      | Number |         |
| title      | 错误标题     | String |         |
| code       | 错误码       | Number |         |
| detail     | 错误信息     | String |         |
| source     | 错误来源     | String |         |

**示例**

	{
	    "status":0,
	    "data":[]
	}

## <a name="编辑新闻">编辑新闻</a>

### Request

**Url**

```
url:/api/news/MA/edit
```

**Method**

```
GET
```

### Response

**Status Success**

```json
{
    status: 1
}
```

**Properties**

| Properties | Description | Type    | default |
| :---:      | :----       | :----:  | :----:  |
| data       | 新闻信息     | array   |         |

**Properties data**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| title      | 新闻标题  　  | string |         |
| source     | 新闻来源 　   | string |         |
| content    | 新闻内容      | string |         |
| publishUserGroup | 新闻发布委办局 | array |    |
| status     | 状态  　      | int    |         |
| image      | 新闻图片  　   | array  |         |
| attachments| 新闻附件  　   | array  |         |
| createTime | 创建时间  　   | int    |         |
| updateTime | 更新时间  　   | int    |         |

**Properties image**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| name       | 图片名称  　  | string |         |
| identify   | 图片地址 　   | string |         |

**Properties attachments**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| name       | 附件名称  　  | string |         |
| identify   | 附件地址  　  | string |         |

**Properties publishUserGroup**

| Properties | Description | Type   | default |
| :---:      | :----:      | :----: | :----:  |
| name       | 委办局名称  　| string |         |

**示例**

	{
		"status": 1,
		"data": {
			"id": "MA",
			"title": "中央财经领导小组办公室副主任韩俊:农村金融要为农村服务",
			"source": "中国网财经",
			"createTime": 1535444931,
			"updateTime": 1535447167,
			"status": 0,
			"content": "中央财经领导小组办公室副主任韩俊:农村金融要为农村服务",
			"publishUserGroup": {
				"id": "MA",
				"name": "萍乡市发展和改革委员会"
			},
			"image": {
				"name": "新闻图片",
				"identify": "o_1cli98qc9dfud59mf5ivkgm9r.jpg"
			},
			"image": "2.jpg",
			"attachments": [
				{
					"name": "关于印发《体育市场黑名单管理办法》通知",
					"identify": "关于印发《体育市场黑名单管理办法》通知.docx"
				}
			]
		}
	}

### Request

**Url**

```
url:/api/news/MA/edit
```

**Method**

```
POST
```

**Parameters:**

```json
{
    "title": "新闻标题",
    "source": "新闻来源",
    "image": {
    	"name":"图片名称",
    	"identify":"图片地址"
    },
    "attachments": [
		{"name":"附件名称","identify":"附件地址"},
		{"name":"附件名称","identify":"附件地址"},
		{"name":"附件名称","identify":"附件地址"}
	],
	"content": "内容",
}
``` 

### Response

**Status Success**

```json
{
    status: 1
}
```

**Status Error**

```json
{
    status: 0
}
```

**Properties**

| Properties | Description | Type   | default |
| :---:      | :----       | :----: | :----:  |
| id         | 错误ID       | Number |         |
| title      | 错误标题     | String |         |
| code       | 错误码       | Number |        |
| detail     | 错误信息     | String |         |
| source     | 错误来源     | String |         |

**示例**

	{
	    "status":0,
	    "data":[]
	}

## <a name="新闻启用">新闻启用</a>

### Request

**Url**

```
url:/api/news/MA/enable
```

**Method**

```
POST
```

### Response

**Status Success**

```json
{
    status: 1
}
```

**示例**

	{
	    "status":1,
	    "data":[]
	}
	
**Status Error**

```json
{
    status: 0
}
```

**Properties**

| Properties | Description | Type   | default |
| :---:      | :----       | :----: | :----:  |
| id         | 错误ID      | Number |         |
| title      | 错误标题     | String |         |
| code       | 错误码       | Number |         |
| detail     | 错误信息     | String |         |
| source     | 错误来源     | String |         |

**示例**

	{
	    "status":0,
	    "data":[]
	}

## <a name="新闻禁用">新闻禁用</a>

### Request

**Url**

```
url:/api/news/MA/disable
```

**Method**

```
POST
```

路由

	通过POST传参
	/news/1/disable

### Response

**Status Success**

```json
{
    status: 1
}
```

**示例**

	{
	    "status":1,
	    "data":[]
	}
	
**Status Error**

```json
{
    status: 0
}
```

**Properties**

| Properties | Description | Type   | default |
| :---:      | :----       | :----: | :----:  |
| id         | 错误ID      | Number |         |
| title      | 错误标题     | String |         |
| code       | 错误码       | Number |         |
| detail     | 错误信息     | String |         |
| source     | 错误来源     | String |         |

**示例**

	{
	    "status":0,
	    "data":[]
	}		