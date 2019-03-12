<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;

use App\Models\Tag;
use App\Models\W_login;
use Illuminate\Http\Request;

class WechatMainController extends CommonController
{
    /**
     * index
     */
    public function index()
    {

        $xml = file_get_contents('php://input');
        $xml_obj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xml_arr = json_decode(json_encode($xml_obj), true);
        file_put_contents('/data/wwwroot/default/wechart/wechat.log', 'xml_arr' . print_r($xml_arr, 1) . "\r\n", FILE_APPEND);

        if ($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'subscribe') {

            $attr = $this->app();

            echo '<xml>
             <ToUserName>' . $xml_arr['FromUserName'] . '</ToUserName>  
             <FromUserName>' . $xml_arr['ToUserName'] . '</FromUserName> 
                <CreateTime>' . time() . '</CreateTime>
                <MsgType>text</MsgType>
                <Content>' . $attr . '</Content>
                </xml>';


        } else if ($xml_arr['MsgType'] == 'text') {
            #如果是文本消息 判断是不是要查询天气
            $content = $xml_arr['Content'];
            if (strstr($content, '天气')) {
                $city = str_replace('天气', '', $content);
                $xml = $this->weather($city);
                echo '<xml>
                    <ToUserName>' . $xml_arr['FromUserName'] . '</ToUserName>  
                     <FromUserName>' . $xml_arr['ToUserName'] . '</FromUserName> 
                     <CreateTime>' . time() . '</CreateTime>
                    <MsgType>text</MsgType>
                     <Content><![CDATA[' . ($xml) . ']]></Content>
                    </xml>';
            } else {

                if (strstr($content, '图片')) {
                    $media = [
                        'lQtg8d58IvupJb75fiNFR52skYHaQrp2JwLAjQ',
                        'wlb5slQtg8d58IvupJb75XMoVnr5acCZVePQBn5Fuhc',
                        'wlb5slQtg8d58IvupJb75Y6x-Sl7bhSwtIaWo6uuHS4'
                    ];


                    $xml = '<xml>
                    <ToUserName>' . $xml_arr['FromUserName'] . '</ToUserName>  
                    <FromUserName>' . $xml_arr['ToUserName'] . '</FromUserName> 
                     <CreateTime>' . time() . '</CreateTime>
                    <MsgType>image</MsgType>
                     <Image><MediaId>' . $media[rand(0, 2)] . '</MediaId></Image>
                    </xml>';


                    echo $xml;
                } else if (strstr($content, '视频')) {

                    $video = [
                        'wlb5slQtg8d58IvupJb75UBboHQnF3osh0OrJiGvwcw',
                        'wlb5slQtg8d58IvupJb75eLcv27lureEdCpNUjxV0Hs'
                    ];


                    $xml = '<xml>
                    <ToUserName>' . $xml_arr['FromUserName'] . '</ToUserName>  
                     <FromUserName>' . $xml_arr['ToUserName'] . '</FromUserName> 
                     <CreateTime>' . time() . '</CreateTime>
                    <MsgType>video</MsgType>
                     
                     <Video><MediaId>' . $video[rand(0, 1)] . '</MediaId></Video>
                    </xml>';

                    echo $xml;

                } else if ($content == '图文') {


                    echo '<xml>
             <ToUserName>' . $xml_arr['FromUserName'] . '</ToUserName>
              <FromUserName>' . $xml_arr['ToUserName'] . '</FromUserName>
               <CreateTime>' . time() . '</CreateTime>
                <MsgType>news</MsgType>
                 <ArticleCount>1</ArticleCount>
                  <Articles>
                      <item>
                               <Title>衣服</Title>
                                        <Description>短袖-白色-l</Description>
                                                 <PicUrl>http://139.199.124.23:81/uploads/goods/goods_thumb/20181013/11c7397df7473ccc387b2f2c3b0b668f.jpeg</PicUrl>
                                                          <Url>http://139.199.124.23:83/shopcontent?sku_id=1</Url>
                                                              </item>
                                                               </Articles>
                                                                </xml>';
                } else {
                    $data = $this->test($content);


                    if ($data[0]['type'] == 1) {


                        $xml = '<xml>
                    <ToUserName>' . $xml_arr['FromUserName'] . '</ToUserName>  
                     <FromUserName>' . $xml_arr['ToUserName'] . '</FromUserName> 
                     <CreateTime>' . time() . '</CreateTime>
                    <MsgType>text</MsgType>
                     
                     <Content>' . $data[0]['content_msg'] . '</Content>
                    </xml>';

                        echo $xml;


                    } else if ($data[0]['type'] == 2) {
                        $xml = '<xml>
                    <ToUserName>' . $xml_arr['FromUserName'] . '</ToUserName>  
                     <FromUserName>' . $xml_arr['ToUserName'] . '</FromUserName> 
                     <CreateTime>' . time() . '</CreateTime>
                    <MsgType>image</MsgType>
                     <Image><MediaId>' . $data[0]['content_msg'] . '</MediaId></Image>
                    </xml>';
                        echo $xml;
                    } else if ($data[0]['type'] == 3) {
                        $xml = '<xml>
                    <ToUserName>' . $xml_arr['FromUserName'] . '</ToUserName>  
                     <FromUserName>' . $xml_arr['ToUserName'] . '</FromUserName> 
                     <CreateTime>' . time() . '</CreateTime>
                    <MsgType>video</MsgType>
                     <Video><MediaId>' . $data[0]['content_msg'] . '</MediaId></Video>
                    </xml>';
                        echo $xml;
                    }


                }

            }
        } else if ($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'SCAN') {

            $where = [
                'uniq_id' => $xml_arr['EventKey']
            ];
            $info = [
                'status' => 3,
                'openid' => $xml_arr['FromUserName'],
                'uniq_id' => $xml_arr['EventKey']
            ];

            $res = W_login::where($where)->update($info);
            if ($res) {
                echo '<xml>     
                     <ToUserName>' . $xml_arr['FromUserName'] . '</ToUserName>  
                     <FromUserName>' . $xml_arr['ToUserName'] . '</FromUserName> 
                     <CreateTime>' . time() . '</CreateTime>
                     <MsgType>text</MsgType>
                     <Content>222</Content>
                     </xml>';
            }

        }

    }


    public function test($content)
    {

        header("content-type:text/html;charset=utf8");

#$content="php";
        $link = mysqli_connect('127.0.0.1', 'Root', 'oneinstack', 'shop');
        $sql = "select * from shop_keyword where keyword='$content'";
        $res = mysqli_query($link, $sql);


        $num = mysqli_num_rows($res);
        while ($arr = mysqli_fetch_assoc($res)) {
            $data[] = $arr;
        }

        return $data;


    }

    /**
     * token
     */
    public function token()
    {

        $app_id = 'wxbcd626591ca69ae0';

        $app_secret = '6732d79e39a36f46be5ed8703eb5350f';

        $access_token_path = '/data/wwwroot/default/wechart/access_token.txt';

        if (!file_exists($access_token_path) || time() - filemtime($access_token_path) > 7100) {
            echo 111;
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $app_id . '&secret=' . $app_secret;

            $token_arr = json_decode(file_get_contents($url), true);

            $token = $token_arr['access_token'];

            file_put_contents($access_token_path, $token);


        } else {


            $token = file_get_contents($access_token_path);
            request()->session()->put('token', $token);

        }

        function CurlPost($url, $param = [], $is_Post = 1, $timeout = 60)
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
                    @curl_setopt($curl, CURLOPT_POSTFIELDS, ($param));
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


    }


    public function weather($city)
    {
        $app_id = "82891";

        $app_key = "78f3e82275b743f2ad77b260064ef9c1";

        $app_url = "http://route.showapi.com/9-2";

        $app_param = [
            'showapi_appid' => $app_id,
            'showapi_timestamp' => date('YmdHis'),
            'area' => $city
        ];

        ksort($app_param);

        $sign_str = '';

        foreach ($app_param as $k => $v) {
            $sign_str .= $k . $v;

        }

        $sign_str .= $app_key;

        $sign = md5($sign_str);

        $app_param['showapi_sign'] = $sign;

        $request_str = http_build_query($app_param);


        $json_str = file_get_contents($app_url . '?' . $request_str);


        $api_arr = json_decode($json_str, true);

        $res = $api_arr['showapi_res_body'];

        if ($res['ret_code'] != 0) {
            $xml = $res['remark'];
        } else {
            $xml = '';
            $xml .= '城市:' . $city . "\r\n";
            $xml .= '天气:' . $res['now']['weather'] . "\r\n";
            $xml .= '空气指数:' . $res['now']['aqi'] . "\r\n";
            $xml .= '气温:' . $res['now']['temperature'] . "\r\n";
            $xml .= '温度:' . $res['now']['sd'] . "\r\n";
            $xml .= '---------------------------' . "\r\n" . '明日天气' . "\r\n";
            $xml .= '天气:' . $res['f2']['day_weather'] . "\r\n";
            $xml .= '紫外线指数:' . $res['f2']['ziwaixian'] . "\r\n";
            $xml .= '温度:' . $res['f2']['night_air_temperature'] . '-' . $res['f2']['day_air_temperature'] . "\r\n";
            $xml .= '--------------------------' . "\r\n" . '后天天气' . "\r\n";
            $xml .= '天气:' . $res['f3']['day_weather'] . "\r\n";
            $xml .= '紫外线指数:' . $res['f3']['ziwaixian'] . "\r\n";
            $xml .= '温度:' . $res['f3']['night_air_temperature'] . '-' . $res['f3']['day_air_temperature'] . "\r\n";
        }
        return $xml;
    }


    public function app()
    {
        header("content-type:text/html;charset=utf8");
        $link = mysqli_connect('127.0.0.1', 'Root', 'oneinstack', 'shop');
        $sql = "select * from shop_attention";
        $res = mysqli_query($link, $sql);
        $num = mysqli_num_rows($res);
        while ($arr = mysqli_fetch_assoc($res)) {
            $data[] = $arr;
        }
        $attr = $data[rand(0, $num - 1)]['attention'];

        return $attr;

    }


    public function api_add()
    {
        $this->token();
        $token = request()->session()->get('token');

        $url = 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=' . $token;
        $param = [
            'industry_id1' => '1',
            'industry_id2' => '2',
        ];

        $result = CurlPost($url, json_encode($param));
        print_r($result);

    }

    public function get_all()
    {
        $token = request()->session()->get('token');
        $url = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=' . $token;
        $result = file_get_contents($url);
    }

    public function send()
    {
        $this->token();
        $token = request()->session()->get('token');
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $token;

        $param = [
            'touser' => 'o3wNQ1VwWyXNSoAbXGnxRWv-ejmk',
            'template_id' => 'WhfKh0zRBEXE5lnQZ2VIuUvhH28gOspVwtfWdY_dfmw',
            'url' => 'http://www.baidu.com',
            'data' => [
                "order_amount" => [
                    'value' => '1200',
                    'color' => '#173177'
                ],
                'order_no' => [
                    'value' => '1234567895',
                    'color' => '#173177'
                ],
                'product_name' => [
                    'value' => '小米8',
                    'color' => '#173177'
                ],
            ]
        ];
        $result = CurlPost($url, json_encode($param));
        var_dump($result);

    }


    #带参数二维码
    public function scene()
    {
        $this->token();
        $token = request()->session()->get('token');
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $token;
        $uid = uniqid();
        $param = [
            'expire_seconds' => 1200,
            'action_name' => 'QR_STR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_str' => $uid
                ]
            ]
        ];

        $result = CurlPost($url, json_encode($param));
        $inf = [
            'uniq_id'=> $uid,
            'expire_time'=>time()+60,
            'status'=>1
        ];
        W_login::insert($inf);

        return view('blog.wechat', ['result' => $result, 'uid' => $uid]);
    }

    public function more(Request $request){

        if(request()->isMethod('post')){

            $data=$request->post();
            $where=[
                'uniq_id'=>$data['unid']
            ];

            $info=W_login::where($where)->first()->toArray();



            if(empty($info)){
                $arr=[
                    'status'=>1,
                    'msg'=>'二维码已超时或未找到'
                ];
                echo json_encode($arr);
                exit;
            }
            if($info['expire_time']-time()<0){
                $arr=[
                    'status'=>2,
                    'msg'=>'二维码已过期'
                ];
                echo json_encode($arr);
                exit;
            }

            if($info['status']==1){
                $arr=[
                    'status'=>3,
                    'msg'=>'未扫描二维码'
                ];
                echo json_encode($arr);
                exit;
            }else if($info['status']==2){
                $arr=[
                    'status'=>4,
                    'msg'=>'扫描二维码，请尽快确认'
                ];
                echo json_encode($arr);
                exit;
            }else if($info['status']==3){
                 $arr=[
                    'status'=>1000,
                    'msg'=>'登录成功'
                ];
                echo json_encode($arr);
                exit;
            }
        }else{

            echo 1111;
        }
    }

    public function tag(Request $request){
        if($request->isMethod('post')){
            $post=$request->post();
            if(!Tag::where('tag_name',$post)->first()){
                $this->token();
                $token = request()->session()->get('token');
                $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token=' . $token;
                $param = [
                    'tag' => [
                        'name' =>$post['tag']
                    ]
                ];
                $result = CurlPost($url, json_encode($param, JSON_UNESCAPED_UNICODE));
                $info=[
                    'tag_id'=>$result['tag']['id'],
                    'tag_name'=>$result['tag']['name'],
                    'status'=>1,
                    'ctime'=>time()
                ];
                $res=Tag::insert($info);
                if($res){
                    return $this->success();
                }
            }else{
                return $this->fail('数据库已有此标签');
            }


        }else{
            return view('blog.app.tag');
        }


    }

    public function cgi_bin(){
        $this->token();
        $token = request()->session()->get('token');
        $url='https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$token;
        $result=file_get_contents($url);
        var_dump($result);exit;
    }

    public function cgi(){
        $this->token();
        $token = request()->session()->get('token');
        $url='https://api.weixin.qq.com/cgi-bin/tags/update?access_token='.$token;
        $param=[
            'tag'=>[
                'id'=>100,
                'name'=>'广东人'
            ]
        ];
        $result=CurlPost($url,json_encode($param,JSON_UNESCAPED_UNICODE));
        var_dump($result);exit;
    }


    public function cgi_del(){
        $this->token();
        $token = request()->session()->get('token');
        $url='https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$token;
        $param=[
            'tag'=>[
                'id'=>102
            ]
        ];
        $result=CurlPost($url,json_encode($param,JSON_UNESCAPED_UNICODE));
        var_dump($result);exit;
    }


    public function cgi_openid(){
        $this->token();
        $token = request()->session()->get('token');

        $url='https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$token;
        $param=[
            'tag'=>[
                'tagid'=>134,
                'next_openid'=>''
            ]
        ];
        $result=CurlPost($url,json_encode($param));
        var_dump($result);exit;
    }


    public function cgi_number(){
        $this->token();
        $token = request()->session()->get('token');

        $url='https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$token;
        $param=[
            'openid_list'=>[
                'o3wNQ1bMVfbr3QEDcvfTFbq3YaME',
                'o3wNQ1R-Dk8iNZrQvZqanMA4X3Ew',
                'o3wNQ1VwWyXNSoAbXGnxRWv-ejmk'
            ],
            'tagid'=>'101'
        ];
        $result=CurlPost($url,json_encode($param));
        var_dump($result);exit;
    }

    public function cgi_num_del(){
        $this->token();
        $token = request()->session()->get('token');

        $url='https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token='.$token;
        $param=[
            'openid_list'=>[
                'o3wNQ1bMVfbr3QEDcvfTFbq3YaME',
                'o3wNQ1R-Dk8iNZrQvZqanMA4X3Ew',
                'o3wNQ1VwWyXNSoAbXGnxRWv-ejmk'
            ],
            'tagid'=>'101'
        ];
        $result=CurlPost($url,json_encode($param));
        var_dump($result);exit;
    }

    public function cgi_num_list(){
        $this->token();
        $token = request()->session()->get('token');

        $url='https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token='.$token;
        $param=[
            'openid'=>'o3wNQ1VwWyXNSoAbXGnxRWv-ejmk'
        ];
        $result=CurlPost($url,json_encode($param));
        var_dump($result);exit;
    }

    public function cgi_num_msg(){
        $this->token();
        $token = request()->session()->get('token');

        $url='https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$token;
        $param=[
            'filter'=>[
                'tag_id'=>'101'
            ],
            'text'=>[
                'content'=>'蜡笔小新'
            ],
            'msgtype'=>'text'
        ];

        $result=CurlPost($url,json_encode($param,JSON_UNESCAPED_UNICODE));
        var_dump($result);exit;
    }


//    #用户列表展示
    public function root_list(Request $request){
        $this->token();
        $token=$request->session()->get('token');
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$token;
        $uid=uniqid();
        $param=[
            'expire_seconds'=>1200,
            'action_name'=>'QR_STR_SCENE',
            'action_info'=>[
                'scene'=>[
                    'scene_id'=>$uid
                ]
            ]
        ];
        $result=CurlPost($url,json_encode($param));



        return view('blog.img',['result'=>$result,'uid'=>$uid]);








    }

        public function root_add(Request $request){
            $w=W_login::where('status',3)->get();
          return view('blog.list',['w'=>$w]);
        }

        public function list_b(){
            $tag=Tag::get();

            return view('blog.tag',['tag'=>$tag]);
        }

        public function deltag(Request $request){
          $id=$request->get('id');

          $data=Tag::where('id',$id)->first();
            Tag::where('id',$id)->delete();
            $this->token();
            $token = request()->session()->get('token');
            $url='https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$token;



            $param=[
                'tag'=>[
                    'id'=>$data['tag_id']
                ]
            ];
            $result=CurlPost($url,json_encode($param));
            return '删除成功';
        }

        public function qian(Request $request){
            $id=$request->get('uid');

            $data=W_login::where('id',$id)->first();

            $this->token();
            $token = request()->session()->get('token');
            $url='https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$token;



            $param=[
                'openid_list'=>$data['openid'],
                'tagid'=>107

            ];

            $result=CurlPost($url,json_encode($param));

            return '用户添加标签成功';
        }

    public function msgs(Request $request){
        $id=$request->get('uid');

        $data=Tag::where('id',$id)->first();


        $this->token();
        $token = request()->session()->get('token');
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$token;
        $param=[
            'filter'=>[
                'tag_id'=>$data['tag_id']
            ],
            'text'=>[
                'content'=>'柯南22222'
            ],
            'msgtype'=>'text'
        ];
        $result=CurlPost($url,json_encode($param,JSON_UNESCAPED_UNICODE));

        return '消息发送成功';
    }

    public function openid(Request $request){
        $id=$request->get('uid');

        $this->token();
        $token = request()->session()->get('token');

        $url='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token;
        $result=file_get_contents($url);
        $a=json_decode($result,true);
        echo 222;
var_dump($a);exit;


        $aurl='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$token;
        $param=[
            'filter'=>[
                'tag_id'=>$data['tag_id']
            ],
            'text'=>[
                'content'=>'柯南22222'
            ],
            'msgtype'=>'text'
        ];
        $result=CurlPost($url,json_encode($param,JSON_UNESCAPED_UNICODE));

        return '消息发送成功';
    }




    #js












}
