<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class FindpwdController extends CommonController{

    #发送手机验证码
    public function find_pwd(Request $request){
        if($request->isMethod('post')){
            $tel=$request->post('tel');
            $sendcode=$this->createCode();
            $sendSms=$this->sendSms($tel,$sendcode);
            if($sendSms){
                $cateInfo=[
                    'sendTel'=>$tel,
                    'sendCode'=>$sendcode,
                    'sendTime'=>time()
                ];
                $request->session()->put('codeInfo',$cateInfo);
                return  $this->success() ;
            }else{
                return $this->fail('发送失败');
            }
        }else{
            return view('login.findpwd');
        }

    }

    #判断验证码是否正确
    public function sendCode(Request $request){
        $sendCode=$request->post('sendCode');
        $codeInfo= $request->session()->get('codeInfo');
        if($sendCode == $codeInfo['sendCode']){
            return $this->success();
        }else{
            return $this->fail('输入的验证码错误');
        }


    }



    #修改密码
    public function savepwd(Request $request){
        if($request->isMethod('post')){
            $savepwd=$request->post();

            if($savepwd['pwd'] != $savepwd['pwd2']){
                return $this->fail('两次输入密码不一致');
            }
            $codeInfo= $request->session()->get('codeInfo');
            $pwd=[
                'user_pwd'=>md5($savepwd['pwd'])
            ];

            $res=User::where('user_tel',$codeInfo['sendTel'])
                ->update($pwd);
            if($res){
                return $this->success();
            }else{
                return $this->fail('修改失败');
            }





        }else{
            $codeInfo= $request->session()->get('codeInfo');
            return view('login.savepwd',['cateInfo'=>$codeInfo['sendTel']]);
        }


    }






































}
