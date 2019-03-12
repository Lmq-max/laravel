<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\W_login;
use Illuminate\Http\Request;

class WechatController extends Controller{

    public function callback(Request $request){

        $app_id='wxbcd626591ca69ae0';
        $app_key='6732d79e39a36f46be5ed8703eb5350f';
        $code=$_REQUEST['code'];
        $access_token_url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$app_id.'&secret='.$app_key.'&code='.$code.'&grant_type=authorization_code';

        $result=json_decode(file_get_contents( $access_token_url));

        $get_user_info='https://api.weixin.qq.com/sns/userinfo?access_token='.$result->access_token.'&openid='.$result->openid.'&lang=zh_CN';

        $user_info=json_decode( file_get_contents($get_user_info),true);

        $request->session()->put('wechat_info',$user_info);
        return redirect('/login');

    }


    public function wechat_open(Request $request){
        $u_id=$request->get('uid');
        $where=[
            'uniq_id'=>$u_id
        ];

        $w_first=W_login::where($where)->first()->toArray();
        if(empty($w_first)){
            exit('未查询到数据');
        }

        #授权 第一步
        $app_id='wxbcd626591ca69ae0';

        $redirect_uri='http://shop.lbjames23.cn/w_login2?uid='.$u_id;

        #普通授权，需要用户允许，可以获取基本信息
        $type='snsapi_userinfo';


        $code_url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.
            $app_id.'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope='.
            $type.'&state=STATE#wechat_redirect';



        #print_r($code_url);
        header('location:'.$code_url);


    }

    public function w_login2(Request $request){

        $uid=$request->get('uid');
        $app_id='wxbcd626591ca69ae0';

        $app_key='6732d79e39a36f46be5ed8703eb5350f';

        $code=$_REQUEST['code'];

        $access_token_url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$app_id.'&secret='.$app_key.'&code='.$code.'&grant_type=authorization_code';

        $result=json_decode(file_get_contents( $access_token_url),true);

        $get_user_info='https://api.weixin.qq.com/sns/userinfo?access_token='.$result['access_token'].'&openid='.$result['openid'].'&lang=zh_CN';
        $user_info=json_decode( file_get_contents($get_user_info),true);
        //echo 123;

        $request->session()->put('w_login',$user_info);

        return view('index.wechat.w_login')->with(['uid'=>$uid]);

    }

    public function w_login3(Request $request){
        if($request->isMethod('post')){
            $post=$request->post();

            $where=[
                'uniq_id'=>$post['uid']
            ];
            $data=[
                'openid'=>$post['openid'],
                'status'=>3
            ];

           W_login::where($where)->update($data);

        }
    }




}
