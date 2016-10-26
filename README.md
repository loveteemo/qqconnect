# ThinkPHP 5 & Oauth2.0 QQ登录

类库是基于Oauth2.0结合ThinkPHP 5 修改部分内容，仅适配 ThinkPhP 5

个人博客主页： http://www.loveteemo.com

## 安装方法

composer安装:

``` bash
composer require loveteemo/qqconnect
```

添加公共配置:
``` php
// QQ 互联配置 在config.php中添加
'qqconnect' => [
    'appid' => '',
    'appkey' => '',
    'callback' => '',
    'scope' => 'get_user_info',
    'errorReport' => true
]
```

## 示例

### 页面编写:

```
<a href="{:url('Base/qqlogin')}">QQ登录</a>
```

### 控制器编写:

登录
``` php
namespace app\index\controller;
use loveteemo\qqconnect\QC;
class Base
{
    public function qqlogin()
    {
        $qc = new QC();
        return redirect($qc->qq_login());
    }
}
```

回调
``` php
namespace app\index\controller;
use loveteemo\qqconnect\QC;
class Base
{
    public function callback()
    {
        $qc = new QC();
        $access_token =  $Qc->qq_callback();
        $openid = $Qc->get_openid();
        $Qc = new QC($access_token,$openid);
        $qq_user_info = $Qc->get_user_info();
        //打印数据
        //dump($qq_user_info);die;
        // ...
        // 用户逻辑
        return redirect(url('Index/index'));
    }
}
```

获取到的QQ数据
``` php
/**
     * array(18) {
    ["ret"] => int(0)
    ["msg"] => string(0) ""
    ["is_lost"] => int(0)
    ["nickname"] => string(21) "那年，烟雨重楼"
    ["gender"] => string(3) "男"
    ["province"] => string(6) "广东"
    ["city"] => string(6) "深圳"
    ["year"] => string(4) "1993"
    ["figureurl"] => string(73) "http://qzapp.qlogo.cn/qzapp/101232670/7C8F797F30B08554A6E39A537F9A324B/30"
    ["figureurl_1"] => string(73) "http://qzapp.qlogo.cn/qzapp/101232670/7C8F797F30B08554A6E39A537F9A324B/50"
    ["figureurl_2"] => string(74) "http://qzapp.qlogo.cn/qzapp/101232670/7C8F797F30B08554A6E39A537F9A324B/100"
    ["figureurl_qq_1"] => string(69) "http://q.qlogo.cn/qqapp/101232670/7C8F797F30B08554A6E39A537F9A324B/40"
    ["figureurl_qq_2"] => string(70) "http://q.qlogo.cn/qqapp/101232670/7C8F797F30B08554A6E39A537F9A324B/100"
    ["is_yellow_vip"] => string(1) "0"
    ["vip"] => string(1) "0"
    ["yellow_vip_level"] => string(1) "0"
    ["level"] => string(1) "0"
    ["is_yellow_year_vip"] => string(1) "0"
    }
*/
```


