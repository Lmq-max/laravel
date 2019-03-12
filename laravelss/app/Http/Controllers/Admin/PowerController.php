<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;

use App\Models\Power;
use Illuminate\Http\Request;

class PowerController extends CommonController
{
    public function power(Request $request)
    {
        if($request->isMethod('post')){

            $data=$request->post();
            $data['ctime']=time();
            if($data['pid']==0){
                $data['level']=1;
            }else{
                $data['level']=2;
            }

            $res=Power::insert($data);
            if($res){
                return $this->success();
            }else{
                return $this->fail('添加失败');
            }

        }else{
            $where=[
                'level'=>1,
                'pid'=>0
            ];

            $list=Power::where($where)->get();

            return view('blog.power.power',['list'=>$list]);
        }


    }

}
