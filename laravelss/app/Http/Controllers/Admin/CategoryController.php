<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends CommonController
{
    /**
     * 分类添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function cate_add(Request $request)
    {
        if($request->isMethod('post')){
            $data=$request->post();
            $res=Category::insert($data);
            if($res){
                return $this->success();
            }else{
                return $this->fail('添加失败');
            }
        }else{
            #查询下拉菜单
            $cate_info=Category::where('cate_show',1)->get()->toArray();
            $info=$this->getCateInfo($cate_info);

            return view('blog.category.cate_add',['info'=>$info]);
        }
    }

    /**
     * 分类展示
     */
    public function cate_show(){

        $cateInfo=Category::where('cate_show',1)->get()->toArray();
        $info=$this->getCateInfo($cateInfo);
        return view('blog.category.cate_show',['info'=>$info]);
    }

    /**
     * 分类删除
     */
    public function delete(Request $request){
        $id=$request->all('cate_id');
        $res=Category::where('cate_id',$id)->delete();
        if($res){
            return '删除成功';
        }else{
            return '删除失败';
        }
    }

    /**
     * 分类修改
     */
    public function update(Request $request){
        $id=$request->all('cate_id');
        $data=Category::where('cate_id',$id)->first();

        $cate_info=Category::where('cate_show',1)->get()->toArray();
        $info=$this->getCateInfo($cate_info);

        return view('blog.category.cate_update',['info'=>$info,'data'=>$data]);
    }

    /**
     * 执行修改
     */
    public function save(Request $request){
        if($request->isMethod('post')){
            $data=$request->post();
            $where=[
                'cate_id'=>$data['cate_id']
            ];
            $res=Category::where($where)->update($data);
            if($res){
                return $this->success();
            }else{
                return $this->fail('修改失败');
            }


        }else{
            return '传递类型错误';
        }
    }





}
