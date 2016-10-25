# ThinkPHP 5 & Oauth2.0 QQ登录

类库是基于Oauth2.0结合ThinkPHP 5 修改部分内容，仅适配 ThinkPhP 5

## 安装方法

composer安装:

``` bash
composer require loveteemo/qqconnect
```

添加公共配置:
``` php
// QQ 互联配置
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
<a href="{:url('index/oauth/qqlogin')}">QQ登录</a>
```

### 控制器编写:

登录
``` php
namespace app\index\controller;
use loveteemo\qqconnect\QC;
class Oauth
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
class Oauth
{
    public function callback()
    {
        $qc = new QC();
        // ...
        // 用户逻辑
        return ['err'=>0,'msg'=>'登录成功'];
    }
}
```
