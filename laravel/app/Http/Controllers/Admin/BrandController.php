<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;
use App\Models\Brand;
use Illuminate\Http\Request;

/**
 * Class BrandController
 * @package App\Http\Controllers\User
 */
class BrandController extends CommonController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * 品牌添加
     */
    public function brandadd(Request $request)
    {
        if($request->isMethod('post')){

            $data=$request->post();

            $data=[
                'brand_name'=>$data['brand_name'],
                'brand_url'=>$data['brand_url'],
                'brand_describe'=>$data['brand_describe'],
                'brand_sort'=>$data['brand_sort'],
                'brand_logo'=>$data['brand_logo'],
                'brand_show'=>$data['brand_show'],
                'brand_time'=>time()
            ];

            $res=Brand::insert($data);

            if($res){
                return $this->success();
            }else{
                return $this->fail('添加失败');
            }

        }else{
            return view('blog.brand.brandadd');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 品牌展示
     */
    public function brand_show(){

        $page=Brand::paginate(5);

        return view('blog.brand.brandshow',['page'=>$page]);
    }

    /**
     * @param Request $request
     * @return string
     * 删除
     */
    public function brand_del(Request $request){
        $brand_id=$request->all('brand_id');

        $res=Brand::where('brand_id',$brand_id)->delete();

        if($res){
            return '删除成功，请返回刷新查看';
        }else{
            return '删除失败';
        }

    }

    /**
     * 品牌修改
     */
    public function brand_update(Request $request){
        $brand_id=$request->all('brand_id');

        $brand_info=Brand::where('brand_id',$brand_id)->first();

        return view('blog.brand.brand_update',['brand_info'=>$brand_info]);
    }

    /**
     * 执行修改
     */
    public function brand_save(Request $request){
        $data=$request->post();

        $info=[
            'brand_name'=>$data['brand_name'],
            'brand_url'=>$data['brand_url'],
            'brand_logo'=>$data['brand_logo'],
            'brand_show'=>$data['brand_show'],
            'brand_sort'=>$data['brand_sort'],
            'brand_describe'=>$data['brand_describe'],
        ];

        $res=Brand::where('brand_id',$data['brand_id'])->update($info);

        if($res){
            return $this->success();
        }else{
            return $this->fail('修改失败');
        }

    }

    /**
     * @param Request $request
     * @return string
     * 文件上传
     */
    public function uploads(Request $request){
        $file=request()->file('file');
        $url_path = 'uploads/brand';
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




}
