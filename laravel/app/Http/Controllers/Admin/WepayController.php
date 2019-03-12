<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;


class WepayController extends CommonController
{
    public function w_pay(Request $request)
    {
        require_once  "/data/wwwroot/default/laravel/app/Libs/WxPay/lib/WxPay.Api.php";
        require_once  "/data/wwwroot/default/laravel/app/Libs/WxPay/example/WxPay.NativePay.php";
        require_once  '/data/wwwroot/default/laravel/app/Libs/WxPay/example/log.php';
        //初始化日志
        $logHandler= new \CLogFileHandler("/data/wwwroot/default/laravel/app/Libs/WxPay/logs/".date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);
        $notify = new \NativePay();
        $url1 = $notify->GetPrePayUrl("123456789");

        //模式二
        /**
         * 流程：
         * 1、调用统一下单，取得code_url，生成二维码
         * 2、用户扫描二维码，进行支付
         * 3、支付完成之后，微信服务器会通知支付成功
         * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
         */

        $input = new \WxPayUnifiedOrder();
        $input->SetBody("test");
        $input->SetAttach("test");
        $input->SetOut_trade_no("sdkphp123456789".date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://paysdk.weixin.qq.com/notify.php");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");

        $result = $notify->GetPayUrl($input);

        $url2 = $result["code_url"];
        $url='http://shop.lbjames23.cn/main/qrcode2?data='.urlencode($url2);
        return view('blog.w_pay',['url'=>$url]);

    }


    public function qrcode2(){
        require_once '/data/wwwroot/default/laravel/app/Libs/WxPay/example/phpqrcode/phpqrcode.php';
        $data = request() -> all();

        $url = urldecode($data["data"]);

        if(substr($url, 0, 6) == "weixin"){
            header('Content-Type:image/png');
            \QRcode::png($url , false , 'H' ,8 , 3);
        }else{
            header('HTTP/1.1 404 Not Found');
        }


    }


    public function qrcode3(){
        #生成二维码
        $uniqidz_id=uniqid();
        $url='http://shop.lbjames23.cn/wechat_code?uid='.$uniqidz_id;
        include '/data/wwwroot/default/laravel/app/Libs/phpqrcode/phpqrcode.php';
        $file_name='/data/wwwroot/default/laravel/public/qrcode/'.$uniqidz_id.'.png';
        \QRcode::png($url,$file_name,'H',5,1);

        return view('blog.qrlogin',['uid'=>$uniqidz_id]);
    }


    public function wx_pay(){
        $uniq_id = uniqid();
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $param = [
            'appid' => 'wx3d751ea7a2f7c064',
            'mch_id' =>'1499304962',
            'nonce_str' => uniqid(),
            'sign_type' => 'MD5',
            'body' => '1805test',
            'detail' => '1805 test detail',
            'out_trade_no' => date('Ymd') . rand(10000, 99999),
            'total_fee' => 1,
            'spbill_create_ip' => $_SERVER['SERVER_ADDR'],
            'notify_url' => 'http://limq.wx1027.cn/blog/wpay',
            'trade_type' => 'JSAPI',
            'openid'=>'ooz740REvCMGN81PvePLCWTR7LME'
        ];
        ksort($param);
        $sign_str = urldecode(http_build_query($param));
        $sign_str .= '&key=sdg634fghgu5654rtghfghgfy4575htg';
        $sign_str= md5($sign_str);
        $param['sign'] = strtoupper($sign_str);


        function CurlPost($url, $param = [], $is_Post = 1, $timeout = 120)
        {
            //初始化curl
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url); // 设置请求的路径
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            if ($is_Post) {
                curl_setopt($curl, CURLOPT_POST, 1); //设置POST提交
                curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
                //提交数据
                if (is_array($param)) {
                    #不能使用http_bulid_query
                    curl_setopt($curl, CURLOPT_POSTFIELDS, ($param));
                    //            @curl_setopt($curl, CURLOPT_POSTFIELDS, ($param));
                } else {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
                }
            }
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //显示输出结果
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
            //执行请求
            $data = $data_str = curl_exec($curl);
            //处理错误
            if ($error = curl_error($curl)) {
                $logdata = array(
                    'url' => $url,
                    'param' => $param,
                    'error' => '<span style="color:red;font-weight: bold">' . $error . '</span>',
                );
                var_dump($logdata);
                exit;
            }
            curl_close($curl);
            //json数据转换为数组
            $data = json_decode($data, true);
            if (!is_array($data)) {
                $data = $data_str;
            }
            return $data;
        }


        $xml=$this->arr2Xml($param);

        $result=CurlPost($url,$xml);
        $arr = json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

//        if($arr['return_code']=='SUCCESS'){
//            include '/data/wwwroot/default/laravel/app/Libs/phpqrcode/phpqrcode.php';
//            header("content-type:image/png;");
//            $file_name = '/data/wwwroot/default/laravel/public/qrcode/' . $uniq_id . '.png';
//            QRcode::png($arr['code_url'],$file_name,'H',6,2);
//        }

        $jsapi_arr=[
            'appId' => 'wx3d751ea7a2f7c064',
            'timeStamp'=>time(),
            'nonceStr'=>uniqid(),
            'package'=>'prepay_id='.$arr['prepay_id'],
            'signType'=>'MD5'

        ];
        ksort($jsapi_arr);

        $key='sdg634fghgu5654rtghfghgfy4575htg';
        $sign_str = urldecode(http_build_query($jsapi_arr)).'&key='.$key;



        $sign_str= md5($sign_str);
        $jsapi_arr['paySign'] = strtoupper($sign_str);


        $url = 'http://www.phpclub.top/wxpay/demo.php?data=' . urlencode(json_encode( $jsapi_arr )) ;

        header('location:'.$url);


        #return view('blog.wechat.wpay',['uid'=>$uniq_id]);
    }
    function arr2Xml($arr)
    {
        if(!is_array($arr) || count($arr) == 0) return '';

        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }




    public function lo(){
        #判断session中是否有用户信息
        session_start();
        if(!empty($_SESSION['wechat_info'])){
            header('location:http://shop.lbjames23.cn/main/wx_pay');
        }else{
            #授权 第一步
            $app_id='wxbcd626591ca69ae0';

            $redirect_uri='http://shop.lbjames23.cn/main/lo2';

            #普通授权，需要用户允许，可以获取基本信息
            $type='snsapi_userinfo';
            #$type='snsapi_base';

            $code_url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.
                $app_id.'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope='.
                $type.'&state=STATE#wechat_redirect';

            header('location:'.$code_url);


        }

    }
    public function lo2(){
        if(!isset($_REQUEST['code'])){
            exit('code not exists');
        }
        session_start();

        if(!empty($_SESSION['wechat_info'])){
            echo '<pre/>';
            print_r($_SESSION['wechat_info']);
            exit;
        }
        $app_id='wxbcd626591ca69ae0';
        $app_key='6732d79e39a36f46be5ed8703eb5350f';
        $code=$_REQUEST['code'];
        $access_token_url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$app_id.'&secret='.$app_key.'&code='.$code.'&grant_type=authorization_code';
        $result=json_decode(file_get_contents( $access_token_url));

        $get_user_info='https://api.weixin.qq.com/sns/userinfo?access_token='.$result->access_token.'&openid='.$result->openid.'&lang=zh_CN';
        $user_info=json_decode( file_get_contents($get_user_info),true);

        $_SESSION['wechat_info']=$user_info;

        echo '<pre/>';

        header('location:http://shop.lbjames23.cn/main/wx_pay');


    }



















}
