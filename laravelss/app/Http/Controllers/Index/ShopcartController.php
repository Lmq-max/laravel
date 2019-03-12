<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;
use App\Models\Cart;
use App\Models\GoodsSku;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class ShopcartController extends CommonController
{
    /**
     * 购物车
     * @param Request $request
     */
    public function cart(Request $request)
    {
        if($request->isMethod('post')){
            $sku_id=$request->post();
            $sku_info=GoodsSku::where('sku_id',$sku_id)->first();

            if(!empty(session('user_info'))) {
                #存入数据库
                    #查询数据库是否有数据
                $cart=Cart::where('sku_id',$sku_info['sku_id'])->first();
                #如果没有数据 新增一条 如果有 修改数据
                if(empty($cart)){
                    $info=[
                        'user_id'=>session('user_info.user_id'),
                        'sku_id'=>$sku_info['sku_id'],
                        'add_price'=>$sku_info['sku_price'],
                        'buy_number'=>1,
                        'status'=>1,
                        'ctime'=>time(),
                        'utime'=>0
                    ];
                    $cartInfo=Cart::insert($info);
                    if($cartInfo){
                        return $this->success();
                    }else{
                        return $this->fail('加入购物车失败!');
                    }
                }else{
                    $data=[
                        'buy_number'=>$cart['buy_number']+1,
                        'utime'=>time()
                    ];
                    $cartInfo=Cart::where('sku_id',$cart['sku_id'])->update($data);
                    if($cartInfo){
                        return $this->success();
                    }else{
                        return $this->fail('加入购物车失败!!');
                    }

                }
            }else{
                return $this->fail('您还没有登录,请先登录');
            }
        }
    }

    public function cart_show(Request $request)
    {

            $where = [
                'shop_cart.status' => 1,
                'user_id' => session('user_info.user_id'),
            ];
            $info = Cart::join('shop_goods_sku', 'shop_goods_sku.sku_id', '=', 'shop_cart.sku_id')
                ->join('shop_goods', 'shop_goods.goods_id', '=', 'shop_goods_sku.goods_id')
                ->where($where)->get()->toArray();


        return view('index.shopcart.shopcart',['info'=>$info])->with(['show_footer'=>1]);
    }

    /**
     * 修改购物车数量
     */
    public function number(Request $request){
        if($request->isMethod('post')){
            $sku_id=$request->post('sku_id');
            $buy_number=$request->post('buy_number');

            $data=[
                'buy_number'=>$buy_number
            ];
            $res=Cart::where('sku_id',$sku_id)->update($data);
            if($res){
                return $this->success();
            }
        }

    }

    #手机支付
    public function alipay(Request $request){

        $order_id=$request->get('order_id');
        $where = [
            'shop_order.order_id' =>$order_id,

        ];
        $order_info=Order::join('shop_order_detail','shop_order.order_id','=','shop_order_detail.order_id')
            ->where($where)
            ->get()->toArray();

        foreach ($order_info as $k=>$v){
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no =$v['order_no'];

            //订单名称，必填
            //$subject = $_POST['WIDsubject'];
            $subject= $v['goods_name'];
            //付款金额，必填
            $total_amount = $v['order_amount'];

        }


        //商品描述，可空
       // $body = $_POST['WIDbody'];
        $body="12";
        //超时时间
        $timeout_express="1m";

        $config=config('alipay');

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new \AlipayTradeService($config);
        $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        return ;


    }

    /**
     * 购物车删除
     */
    public function cart_del(Request $request){
        if ($request->isMethod('post')) {
            $cart_id = $request->post();

            $info = Cart::where('cart_id', $cart_id)->delete();
            if($info){
                return $this->success();
            }
        }

    }

    /*
     * 订单列表 (7,8)
     */
    public function order(Request $request){
        if ($request->isMethod('post')){
            $cart_id = $request->post('cart_id','');
            $value = $request->session()->get('user_info');
            $cart_id_arr=array_filter(array_map('intval' ,explode(',',$cart_id)));

            $cart_info=Cart::join('shop_goods_sku','shop_cart.sku_id','=','shop_goods_sku.sku_id')
                ->where('shop_cart.user_id',$value['user_id'])
                ->whereIn('shop_cart.cart_id',$cart_id_arr)
                ->get()->toArray();
            if($cart_info){
                return $this->success();
            }

        }
        //return view('index.payment.payment',['cart_info'=>$cart_info])->with(['show_footer'=>1]);
    }

    public function payment(Request $request){

            $cart_id = $request->get('cart_id');
            $count = $request->get('count');

            $value = $request->session()->get('user_info');
            $cart_id_arr = array_filter(array_map('intval', explode(',', $cart_id)));

            $cart_info = Cart::join('shop_goods_sku', 'shop_cart.sku_id', '=', 'shop_goods_sku.sku_id')
                 ->join('shop_goods', 'shop_goods_sku.goods_id', '=', 'shop_goods.goods_id')
                ->where('shop_cart.user_id', $value['user_id'])
                ->whereIn('shop_cart.cart_id', $cart_id_arr)
                ->get()->toArray();


         return view('index.payment.payment',['cart_info'=>$cart_info])->with(['show_footer'=>0]);
    }





}
