***
API调用地址前缀：http://api.benefit.littlerokie.cn/<br />
图片前缀:http://benefit.image.alimmdn.com/ <br />
一律采用JSON格式输入、输出。<br />
接口调用，需传递以下额外头：<br />
```
JOKE: bensdfjasldfjxv!
Authorization: access_token（登陆后，会返回，需要前端存储，后续调用接口都带上此参数）
Accept: application/json
```

根据api_code属性判断是否成功<br />
成功，api_code 200，余下属性参考各个具体接口<br />
范例<br />
```
{
	"api_code": 200,
	"id": "vjx0j"
}
```

失败，api_code != 200，并且带api_msg属性：<br />
```
属性     解释	备注
api_msg	错误说明 必有
```
范例<br />
```
{
	"api_code": 401,
	"api_msg": "昵称已存在"
}
```