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
        if(isset($this->errorMsg[$code])){
            echo $this->errorMsg[$code];
        }else{
            echo "<h2>错误代码:{$code}<a href="http://wiki.open.qq.com/wiki/%E3%80%90QQ%E7%99%BB%E5%BD%95%E3%80%91%E5%85%AC%E5%85%B1%E8%BF%94%E5%9B%9E%E7%A0%81%E8%AF%B4%E6%98%8E">手册点我</a></h2>";
        }
        die;
    }
}
