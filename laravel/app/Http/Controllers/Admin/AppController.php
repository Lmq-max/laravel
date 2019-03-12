<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;

use App\Models\Keyword;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class AppController extends CommonController
{
    public function app_add(Request $request)
    {
        if($request->isMethod('post')){
            $attention=$request->post('attention');

            $info=[
                'attention'=>$attention
            ];

            $data=DB::table('shop_attention')->insert($info);
            if($data){
                return $this->success();
            }else{
                return $this->fail('添加失败');
            }
        }else {

            return view('blog.app.app_add');
        }
    }

    #关键字回复
    public function keyword(Request $request){
        if($request->isMethod('post')){
            $keyword=$request->post();
             //var_dump($keyword);exit;
            if($keyword['type'] == 1){
                $data=[
                    'keyword'=>$keyword['test'],
                    'type'=>$keyword['type'],
                    'content_msg'=>$keyword['txt']
                ];
                $res=Keyword::insert($data);
                if($res){
                    return $this->success();
                }else{
                    return $this->fail('添加失败');
                }
            }else if($keyword['type'] == 2){

                include '/data/wwwroot/default/wechart/media.php';

                $data=[
                    'keyword'=>$keyword['test'],
                    'type'=>$keyword['type'],
                    'content_msg'=>$result['media_id']
                ];
                $res=Keyword::insert($data);
                if($res){
                    return $this->success();
                }else{
                    return $this->fail('添加失败');
                }

            }else{

               include '/data/wwwroot/default/wechart/video.php';    
                $data=[
                    'keyword'=>$keyword['test'],
                    'type'=>$keyword['type'],
                    'content_msg'=>$result['media_id']
                ];
                $res=Keyword::insert($data);
                if($res){
                    return $this->success();
                }else{
                    return $this->fail('添加失败');
                }
            }

        }else{
            return view('blog.app.keyword');
        }


    }



    /**
     * 图片上传
     */
    public function key_upload(){
        $file=request()->file('file');
        $url_path = 'uploads/keyword';
        $rule = ['jpg', 'png', 'gif'];
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $tmpName = $file->getFileName();
            $realPath = $file->getRealPath();
            $entension = $file->getClientOriginalExtension();
            if (!in_array($entension, $rule)) {
                return '图片格式为jpg,png,gif';
            }
            $newName = md5(date("Y-m-d H:i:s") . $clientName) . "." . $entension;
            $path = $file->move($url_path, $newName);
            $namePath = $url_path . '/' . $newName;
            $res = [
                "code"=> 1,
                "font"=> "上传成功",
                'src'=>$namePath
            ];
            return json_encode($res);
        }
    }


    /**
     * 视频上传
     */
    public function key_video()
    {
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES["file"]["tmp_name"];
        $file_error = $_FILES["file"]["error"];
        //$file_size = $_FILES["file"]["size"];
        if ($file_error > 0) {
            return $this->fail($file_error);
        }else {
            $date = date('Ymd');
            $file_name_arr = explode('.', $file_name);
            $new_file_name = date('YmdHis') . '.' . $file_name_arr[1];
            $path = "uploads/keyvideo" . $date . "/";
            $file_path = $path . $new_file_name;
            if (file_exists($file_path)) {
                return $this->fail('此目录已存在');      
            } else {
                is_dir($path) or mkdir($path, 0777, true);//检测目是否存在
                $result = move_uploaded_file($file_tmp, $file_path);
                if ($result) {
                    $info = [                               
                        'font' => '上传成功',
                        'code' => 1000,
                        'src' => $file_path,
                    ];
                    echo json_encode($info);
                } else {
                    return $this->fail('上传失败');
                }
            }
        }
    }


    /**
     * 自定义菜单
     */
        public function menu(Request $request){
            if($request->isMethod('post')){
                $post=$request->post();

                $menu=new Menu();
                $menu->menu_name=$post['menu_name'];
                if(empty($post['parent'])){
                    if($this->_checkMenuCount( ) > 2){
                        return $this->fail('最多只能存3个一级菜单');
                    }
                    $menu->level=1;
                }else{
                    if($this->_checkMenuCount($post['parent']) > 4){
                        return $this->fail('最多只能存5个二级菜单');
                    }
                    $menu->level=2;
                    $menu->parent_id=$post['parent'];
                }
                $menu->menu_type=$post['interest'];
                $menu->menu_operate=$post['content'];
                $menu->status=1;
                $menu->ctime=time();

                $menu->save();
                if($menu->menu_id < 1){
                    return $this->fail('插入失败');
                }else{
                    return $this->success();
                }


            }else{
                $where=[
                    'status'=>1,
                    'level'=>1
                ];
                $menu_info=Menu::where($where)->get();
                //var_dump($menu_info);exit;
                return view('blog.menu.menu',['menu_info'=>$menu_info]);
            }


        }



    private function _checkMenuCount($parent_id = 0){
            $where = [
                ['parent_id' , $parent_id],
                ['status' , 1]
            ];
            $count = Menu::where($where) -> count();
            return $count;
        }

    /**
     * 查询
     */
        public function menu_list(){

            $where=[
                'status'=>1
            ];
            $menu_list=Menu::where($where)->get();

            $new=[];
            foreach ($menu_list as $k=>$v){

                if($v['parent_id']==0){
                    $new['button'][$v['menu_id']]['name']=$v['menu_name'];
                    if($v['menu_type']==1){
                        $new['button'][$v['menu_id']]['type']='view';
                        $new['button'][$v['menu_id']]['url']=$v['menu_operate'];
                    }else if($v['menu_type']==2){
                        $new['button'][$v['menu_id']]['type']='click';
                        $new['button'][$v['menu_id']]['key']=$v['menu_operate'];
                    }else{
                        $new['button'][$v['menu_id']]['type']='scancode_push';
                        $new['button'][$v['menu_id']]['key']=$v['menu_operate'];
                    }
                }else{
                    $new['button'][$v['parent_id']]['sub_button'][$k]['name'] = $v['menu_name'];
                    if( $v['menu_type'] == 1){
                        $new['button'][$v['parent_id']]['sub_button'][$k]['type'] = 'view';
                        $new['button'][$v['parent_id']]['sub_button'][$k]['url'] = $v['menu_operate'];
                    }else if($v['menu_type'] == 2){
                        $new['button'][$v['parent_id']]['sub_button'][$k]['type'] = 'click';
                        $new['button'][$v['parent_id']]['sub_button'][$k]['key'] = $v['menu_operate'];
                    }else{
                        $new['button'][$v['parent_id']]['sub_button'][$k]['type'] = 'scancode_push';
                        $new['button'][$v['parent_id']]['sub_button'][$k]['key'] = $v['menu_operate'];
                    }

                }

            }
            $new['button'] = array_values($new['button']);
            foreach($new['button'] as $k => $v){
                if(!empty($v['sub_button'])){
                    $new['button'][$k]['sub_button'] = array_values($v['sub_button']);
                }
            }
            $json_str = json_encode($new);
            echo $json_str;exit;


        }

        public function send(Request $request){
            if($request->isMethod('post')){
                $send=$request->post();

                if($send['type']==1){
                    include '/data/wwwroot/default/wechart/send.php';
                }else{
                    include '/data/wwwroot/default/wechart/openidsend.php';
                }
                if($result["errmsg"]=="send job submission success"){
                    return $this->success();
                }else{
                    return $this->fail('发送失败');
                }




            }else{
                return view('blog.app.send.send');
            }



        }



}

