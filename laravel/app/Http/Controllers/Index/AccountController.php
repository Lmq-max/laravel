<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccountController extends CommonController
{
    public function a($total, $num, $min = 0.01)
    {
        for ($i = 1; $i < $num; $i++) {
            //随机安全上限
            $safe_total = ($total - ($num - $i) * $min) / ($num - $i);
            //红包金额
            $money = mt_rand($min * 100, $safe_total * 100) / 100;
            //余额
            $total = bcsub($total, $money, 2);

            echo '第' . $i . '个红包：' . $money . ' 元，余额：' . $total . '元<br/>';
        }
        echo '第' . $num . '个红包：' . $total . ' 元，余额：0 元';
    }
    public function b(){
        $res=$this->a(10,7,$min=0.01);
        echo $res;exit;
    }

    public function getUserTableName(){
       $id=rand(0,9999999);
       $a=$id/100000;
       $b=ceil($a);
       echo 'user'.$b;
    }


    public function edituser(Request $request){
        return view('index.user.edituser');
    }

    /*退出登录*/
    public function quit(Request $request){
        $request->session()->forget('user_info');
        return redirect('userpage');
    }

    /*登录*/
    public function login(Request $request){
        $redis=new \redis();
        $redis->connect('192.168.43.239',6379);

        //判断请求方式
        if($request->isMethod('post')){


            $user_name=$request->post('user_name','');
            if(empty($user_name)){
                return $this->fail('用户名不能为空');
            }

            $user_pwd=$request->post('user_pwd','');
            if(empty($user_pwd)){
                return $this->fail('密码不能为空');
            }

            /*$rules = ['vcode' => 'required|captcha'];

            $validator = \Illuminate\Support\Facades\Validator::make(\Illuminate\Support\Facades\Input::all(), $rules);
            if ($validator->fails())
            {
              return  $this->fail('验证码错误');
            }*/
            if($redis->hGet($user_name,'user_pwd')==md5($user_pwd)){
                $user_info=[];
                $user_info['user_email']=$redis->hGet($user_name,'user_email');
                $user_info['user_id']=$redis->hGet($user_name,'user_id');
                $request->session()->put('user_info',$user_info);
                return $this->success('登陆成功');
            }
            //查询账号密码是否正确
            $user_obj=User::where('user_email',$user_name)
                ->orWhere('user_tel',$user_name)
                ->first();

            if($user_obj){
               $user_info= $user_obj->toArray();
            }


            if(empty($user_info)){
                return $this->fail('账号密码不匹配');
            }
            //判断用户密码是否正确
            $time=time();
            if(($time-$user_info['last_error_time'])<3600&&$user_info['error_num']>=5){
                return $this->fail('错误次数达到五次 一小时后再登1');
            }
            if(md5($user_pwd)!=$user_info['user_pwd']){
               if(($time-$user_info['last_error_time'])<3600&&$user_info['error_num']<5){
                    User::where('user_id',$user_info['user_id'])
                        ->update(
                            [
                                'error_num'=>$user_info['error_num']+1,
                                'last_error_time'=>$time
                            ]
                        );
                  return $this->fail('密码错误1');
               }
               if(($time-$user_info['last_error_time'])>3600&&$user_info['error_num']>=5){
                   User::where('user_id',$user_info['user_id'])
                       ->update(
                           [
                               'error_num'=>$user_info['error_num']=1,
                               'last_error_time'=>$time
                            ]
                       );
                 return  $this->fail('密码错误2');
                }
                if(($time-$user_info['last_error_time'])>3600&&$user_info['error_num']<5){
                    User::where('user_id',$user_info['user_id'])
                        ->update(
                            [
                                'error_num'=>$user_info['error_num']+1,
                                'last_error_time'=>$time
                            ]
                        );
                  return   $this->fail('密码错误3');
                }
            }else{
                $session=$request->session()->get('wechat_info');
                if(!empty(isset($session))){
                    $where=[
                        'user_id'=>$user_info['user_id']
                    ];
                    $save=[
                        'wechat_openid'=>session('wechat_info.openid')
                    ];
                    $user_info=User::where($where)->update($save);
                    if($user_info){
                        $request->session()->put('user_info',$user_info);
                    }

                }
                User::where('user_id',$user_info['user_id'])
                    ->update(
                        [
                            'error_num'=>0,
                            'last_error_time'=>0
                        ]
                    );
                $request->session()->put('user_info',$user_info);
                $redis->hSet($user_name,'user_email',$user_name);
                $redis->hSet($user_name,'user_id',$user_name);
                $redis->hSet($user_name,'user_pwd',md5($user_pwd));
                return $this->success();
            }
        }else{
//echo 666;
//            $val=$request->session()->get('user_info');
//            var_dump($val);exit;


            //判断是否登录，登录直接跳转首页
            if(!empty($request->session()->get('user_info'))){
                return redirect('index');
            }

            return view('login.login');
        }

    }
    /*注册*/
    public function register(Request $request){
        if($request->isMethod('post')){
            $tel=$request->post('tel');
            $pwd=$request->post('pwd');

           /* $rules = ['vcode' => 'required|captcha'];

            $validator = \Illuminate\Support\Facades\Validator::make(\Illuminate\Support\Facades\Input::all(), $rules);
            if ($validator->fails())
            {
                return  $this->fail('验证码错误');
            }*/

            $res=User::where('user_tel',$tel)->first();
            if($res){
               $this->fail('该手机号已注册');
            }else{
               $info=[
                   'user_tel'=>$tel,
                   'user_pwd'=>$pwd,
                   'user_time'=>time()
               ];
               $request->session()->put('user_info',$info);
               return $this->success();
            }
        }else{
            return view('login.register');
        }

    }
    /*传手机号*/
    public function regauth(Request $request){
            $user_info= $request->session()->get('user_info');
            return view('login.regauth',['user_info'=>$user_info['user_tel']]);

    }
    /*发送验证码*/
        public function sendCode(Request $request){
        if($request->isMethod('post')){
            $tel=$request->post('tel');
           $createcode= $this->createCode();
           $sendsms=$this->sendSms($tel,$createcode);
           if($sendsms){
               $cateInfo=[
                   'sendCode'=>$createcode,
                   'sendTime'=>time()
               ];
              $request->session()->put('sendInfo',$cateInfo );
             return  $this->success() ;
           }else{
               return $this->fail('发送失败');
           }
        }
    }

    public function regauths(Request $request){
        $userMobile=$request->post('userMobile');
        $sendInfo= $request->session()->get('sendInfo');

        $user_info= $request->session()->get('user_info');


        if($userMobile!=$sendInfo['sendCode']){
            return $this->fail('验证码有误');
        }else{
            $user_pwd= md5($user_info['user_pwd']);
            $info=[
                'user_tel'=>$user_info['user_tel'],
                'user_pwd'=>$user_pwd,
                'user_code'=>$sendInfo['sendCode'],
                'user_time'=>$sendInfo['sendTime'],
            ];
           $res= User::insert($info);
           if($res){
               return $this->success();
           }else{
               return $this->fail('注册失败');
           }

        }
    }
}
