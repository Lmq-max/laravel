<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDefault;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
class PaymentController extends CommonController{


    public function order_add(Request $request){
        if ($request->isMethod('post')){

            $cart_id = $request->post('cart_id','');
            $txt= $request->post('txt');
            $value = $request->session()->get('user_info');

            $cart_id_arr=array_filter(array_map('intval' ,explode(',',$cart_id)));

            $cart_info=Cart::join('shop_goods_sku','shop_cart.sku_id','=','shop_goods_sku.sku_id')
                ->join('shop_goods as g','g.goods_id','=','shop_goods_sku.goods_id')
                ->where('shop_cart.user_id',$value['user_id'])
                ->whereIn('shop_cart.cart_id',$cart_id_arr)
                ->get()->toArray();

            DB::beginTransaction();
            $user_id=$value['user_id'];
                // 1、写入订单表数据
                $order_no=$this->_creatOrderNo();
                $order_insert=[];
                $order_insert['user_id']=$user_id;
                $order_insert['order_no']=$order_no;

                //计算订单的全额
                $order_amount=0.00;

                //遍历购物车数据 计算总金额

                foreach($cart_info as $key=>$value){
                    $order_amount +=$value['buy_number'] * $value['add_price'];
                }

                $order_insert['order_amount']=$order_amount;
                $order_insert['order_status']=1;

                $Order=new Order();
                $order_id=$Order->insertGetId($order_insert);

                //2、写入订单商品表
                $now=time();
                $order_detail=[];
                foreach($cart_info as $k=>$v){
                    $order_detail[$k]['order_id']=$order_id;
                    $order_detail[$k]['user_id']=$user_id;
                    $order_detail[$k]['goods_id']=$v['sku_id'];
                    $order_detail[$k]['goods_price']=$v['sku_price'];
                    $order_detail[$k]['buy_number']=$v['buy_number'];
                    $order_detail[$k]['goods_name']=$v['sku_name'];
                    $order_detail[$k]['goods_img']=$v['goods_img'];
                    $order_detail[$k]['status']=1;
                    $order_detail[$k]['ctime']=$now;
                }

                $OrderDefault=new OrderDefault();
                $number=$OrderDefault->insert($order_detail);

                if($number<1){
                    throw new \Exception('详情表写入失败，请重试',100);
                }
                //3、写入订单的收货地址表
                $order_address=[];
                $address_model=new Address();
                $order_address['user_id']=$user_id;
                $order_address['address_detail']=$txt;
                $order_address['ctime']=time();
                $order_address['status']=1;
                //var_dump($order_address);exit;
                if(!$address_model->insert($order_address)){
                    throw new \Exception('订单收货地址写入失败',100);
                }

        //5、删除购物车的 数据
            $cart_save=[
                'status'=>2,
                'utime'=>$now
            ];
            $cart_where_str=[
                'user_id'=>$value['user_id'],

            ];
            //var_dump($cart_where_str);exit;

            $save=Cart::where($cart_where_str)
                ->whereIn('cart_id',$cart_id_arr)
                ->update($cart_save);

            if(!$save ){
                throw new \Exception('购物车数据删除失败',100);
            }
            //提交事务
            DB::commit();
            //返回成功

            DB::rollBack();
            return $this->success(['order_id'=>$order_id]);


            };


        }




    /**
     * 生成订单编号
     */
    protected function _creatOrderNo(){
        //订单号规则
        //业务线（1）+时间（6 ）+用户id（4）+4位随机数
        $uid=100182;
        if($uid<1000){
            $uid=str_repeat(0,4-strlen($uid)).$uid;
        }else{
            $uid=substr($uid,0,-4);
        }
        return 1 . date('ymd').$uid.rand(1000,9999);
    }










    public function wx_pay1(Request $request){

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

    public function redis(){


    }


//    public function loo(){
//        #判断session中是否有用户信息
//        session_start();
//        if(!empty($_SESSION['wechat_info'])){
//            header('location:http://shop.lbjames23.cn/main/wx_pay');
//        }else{
//            #授权 第一步
//            $app_id='wxbcd626591ca69ae0';
//
//            $redirect_uri='http://shop.lbjames23.cn/main/lo2';
//
//            #普通授权，需要用户允许，可以获取基本信息
//            $type='snsapi_userinfo';
//            #$type='snsapi_base';
//
//            $code_url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.
//                $app_id.'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope='.
//                $type.'&state=STATE#wechat_redirect';
//
//            header('location:'.$code_url);
//
//
//        }
//
//    }
//    public function loo2(){
//        if(!isset($_REQUEST['code'])){
//            exit('code not exists');
//        }
//        session_start();
//
//        if(!empty($_SESSION['wechat_info'])){
//            echo '<pre/>';
//            print_r($_SESSION['wechat_info']);
//            exit;
//        }
//        $app_id='wxbcd626591ca69ae0';
//        $app_key='6732d79e39a36f46be5ed8703eb5350f';
//        $code=$_REQUEST['code'];
//        $access_token_url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$app_id.'&secret='.$app_key.'&code='.$code.'&grant_type=authorization_code';
//        $result=json_decode(file_get_contents( $access_token_url));
//
//        $get_user_info='https://api.weixin.qq.com/sns/userinfo?access_token='.$result->access_token.'&openid='.$result->openid.'&lang=zh_CN';
//        $user_info=json_decode( file_get_contents($get_user_info),true);
//
//        $_SESSION['wechat_info']=$user_info;
//
//        echo '<pre/>';
//
//        header('location:http://shop.lbjames23.cn/main/wx_pay');
//
//
//    }






















}
