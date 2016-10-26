<?php
// +----------------------------------------------------------------------
// | 青春博客 thinkphp5 版本
// +----------------------------------------------------------------------
// | Copyright (c) 2013~2016 http://loveteemo.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: long <admin@loveteemo.com>
// +----------------------------------------------------------------------
namespace loveteemo\qqconnect;

class ErrorCase{

    //定义错误
    private $errorMsg;

    //错误代码
    public function __construct(){
        $this->errorMsg = array(
            "20001" => "<h2>配置文件无法读取,独立配置文件请修改Recorder第22行 [配置文件名.qqconnect]</h2>",
            "30001" => "<h2>域名不匹配，这个请求可能是CSRF攻击.</h2>",
            "50001" => "<h2>可能是服务器无法请求https协议</h2>可能未开启curl支持,请尝试开启curl支持，重启web服务器，如果问题仍未解决，请联系我们"
            );
    }

    //显示错误
    public function showError($code, $description = '$'){
        echo "<meta charset=\"UTF-8\">";
        echo $this->errorMsg[$code];
        die;
    }
}
