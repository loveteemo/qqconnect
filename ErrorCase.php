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
namespace loveteeemo\qqconnect;

class ErrorCase{

    //定义错误
    private $errorMsg;

    //错误代码
    public function __construct(){
        $this->errorMsg = array(
            "20001" => "<h2>配置文件损坏或无法读取</h2>",
            "30001" => "<h2>The state does not match. You may be a victim of CSRF.</h2>",
            "50001" => "<h2>可能是服务器无法请求https协议</h2>可能未开启curl支持,请尝试开启curl支持，重启web服务器，如果问题仍未解决，请联系我们"
            );
    }

    //显示错误
    public function showError($code, $description = '$'){
        $recorder = new Recorder();
        if(! $recorder->readInc("errorReport")){
            die();
        }

        echo "<meta charset=\"UTF-8\">";
        if($description == "$"){
            die($this->errorMsg[$code]);
        }else{
            echo "<h3>error:</h3>$code";
            echo "<h3>msg  :</h3>$description";
            exit();
        }
    }

    public function showTips($code, $description = '$'){
    }
}
