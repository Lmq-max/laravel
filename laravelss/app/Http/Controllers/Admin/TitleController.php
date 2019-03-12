<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;

use App\Models\Data;
use Illuminate\Http\Request;

class TitleController extends CommonController
{

    public function title(Request $request){
        if($request->isMethod('post')){
            $title=$request->post();

            $info=[
                's_name'=>$title['s_name'],
                's_url'=>$title['s_url'],
                's_num'=>$title['s_num'],
                's_logo'=>$title['logo'],

            ];



            $res=Data::insert($info);





        }else{
            return view('title.title');
        }








    }

    //上传文件 功能实现方法
    public function upload(){
        $file=request()->file('file');
        $url_path = 'uploads/goods';
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
            $res = ["code"=> 1,"font"=> "上传成功",'src'=>$namePath];
            return json_encode($res);
        }
    }


    public function chartshow(){

        $img = Data::where('status' ,0 ) -> get();

        return view('title.show' , ['logo' => $img]);
    }

    public function adminAudit(Request $request){
        if($request -> isMethod('post')){
            $id = $request -> post('id');

            $res = Data::where('s_id' , $id)
                ->update(['status'=> 1 ]);

            if($res){
                return $this->success('成功');
            }else{
                return $this->fail('失败');
            }
        }

    }






}