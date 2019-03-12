<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Goods;
use Illuminate\Http\Request;

class GoodsController extends CommonController
{
    /**
     * 商品添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goods_add(Request $request)
    {
        if($request->isMethod('post')){
            $data=$request->post();

            $info=[
                'goods_name'=>$data['goods_name'],
                'cate_id'=>$data['cate_id'],
                'brand_id'=>$data['brand_id'],
                'goods_up'=>$data['goods_up'],
                'goods_new'=>$data['goods_new'],
                'goods_best'=>$data['goods_best'],
                'goods_hot'=>$data['goods_hot'],
                'goods_stock'=>$data['goods_stock'],
                'goods_score'=>$data['goods_score'],
                'goods_img'=>$data['goods_img'],
                'goods_content'=>$data['goods_content'],
                'goods_selfprice'=>$data['goods_selfprice'],
                'goods_marketprice'=>$data['goods_marketprice'],
                'status'=>4
            ];

            $res=Goods::insert($info);
            if($res){
                return $this->success();
            }else{
                return $this->fail('添加失败');
            }

        }else{
            #品牌分类 查询
            $brand_info=Brand::where('brand_show',1)->get()->toArray();
            #分类查询
            $info=Category::where('cate_show',1)->get()->toArray();
            $cate_info=$this->getCateInfo($info);


            return view('blog.goods.goods_add',['brand_info'=>$brand_info,'cate_info'=>$cate_info]);
        }

    }


    /**
     * 商品展示
     */
    public function goods_show(){

        $goods_info=Goods::where('status',4)->get();

        return view('blog.goods.goods_show',['info'=>$goods_info]);
    }


    /**
     * 图片上传
     */
    public function goods_upload(){
        $file=request()->file('file');
        $url_path = 'uploads/goods/images';
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
     * 富文本编辑器
     */
    public function goods_uploads(Request $request){
        $file=$request->file('file');
        $url_path = 'uploads/goods/text';
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
                "code"=> 0,
                "font"=> "上传成功",
                "data"=>[
                    "src"=>env('IMG_PATH').$namePath,
                    "title"=>$newName
                ]


            ];
            return json_encode($res);
        }

    }


}
