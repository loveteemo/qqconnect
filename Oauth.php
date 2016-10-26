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

class Oauth{

    //QQ互联版本
    const VERSION = "2.0";
    //授权地址
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
    //token地址
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
    //openid地址
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

    protected $recorder;

    public $urlUtils;

    protected $error;


    function __construct(){
        $this->recorder = new Recorder();
        $this->urlUtils = new URL();
        $this->error = new ErrorCase();
    }

    //登陆
    public function qq_login($callbakc_url = ''){
        $appid = $this->recorder->readInc("appid");
        $callback = $callbakc_url ? : $this->recorder->readInc("callback");
        $scope = $this->recorder->readInc("scope");

        $state = md5(uniqid(rand(), TRUE));
        $this->recorder->write('state',$state);

        $keysArr = array(
            "response_type" => "code",
            "client_id" => $appid,
            "redirect_uri" => $callback,
            "state" => $state,
            "scope" => $scope
        );

        return $this->urlUtils->combineURL(self::GET_AUTH_CODE_URL, $keysArr);
    }

    //回调
    public function qq_callback(){
        $state = $this->recorder->read("state");

        if($_GET['state'] != $state){
            $this->error->showError("30001");
        }

        $keysArr = array(
            "grant_type" => "authorization_code",
            "client_id" => $this->recorder->readInc("appid"),
            "redirect_uri" => urlencode($this->recorder->readInc("callback")),
            "client_secret" => $this->recorder->readInc("appkey"),
            "code" => $_GET['code']
        );

        //------构造请求access_token的url
        $token_url = $this->urlUtils->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
        $response = $this->urlUtils->get_contents($token_url);

        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);

            if(isset($msg->error)){
                $this->error->showError($msg->error, $msg->error_description);
            }
        }

        $params = array();
        parse_str($response, $params);

        $this->recorder->write("access_token", $params["access_token"]);
        return $params["access_token"];

    }

    //获取OPENID
    public function get_openid(){

        //-------请求参数列表
        $keysArr = array(
            "access_token" => $this->recorder->read("access_token")
        );

        $graph_url = $this->urlUtils->combineURL(self::GET_OPENID_URL, $keysArr);
        $response = $this->urlUtils->get_contents($graph_url);

        //--------检测错误是否发生
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
            $this->error->showError($user->error, $user->error_description);
        }

        //------记录openid
        $this->recorder->write("openid", $user->openid);
        return $user->openid;

    }
}
