<?php

namespace App\Http\Controllers\Admin;

use App\Libs\ali_sms\SignatureHelper;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommonController extends  BaseController{




    //错误提示
    protected function fail( $data=[],$msg='', $status=1){
        return response()->json(
            [
              'status'=>$status,
              'msg'=>$msg,
              'data'=>$data
            ]
        );
    }
    //正确返回
    protected function success($data=[],$msg='success',$status=1000){
        return response()->json(
            [
                'status'=>$status,
                'msg'=>$msg,
                'data'=>$data
            ]
        );
    }



    //分类递归
        protected function getIndexCateInfo($info,$pid=0){
        $data=[];
        foreach($info as $k=>$v){
            if($v['pid']==$pid){
                $son=$this->getIndexCateInfo($info,$v['cate_id']);
                $v['son']=$son;
                $data[]=$v;
            }
        }
        return $data;
    }

    //分类    无限极分类    获取分类信息
    function getCateInfo($model,$pid=0,$level=1){
        static $info=[];
        foreach($model as $k=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $info[]=$v;
                $this->getCateInfo($model,$v['cate_id'],$v['level']+1);
            }
        }
        return $info;
    }


}
