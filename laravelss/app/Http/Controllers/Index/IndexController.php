<?php

namespace App\Http\Controllers\Index;


use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\GoodsSku;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IndexController extends CommonController {
    public function index(){

        return view('index.index')->with(['title'=>'电商首页1','show_footer'=>1]);
    }
    public function productList(){
        $product_obj=GoodsSku::with('goods')->where('status',4)->paginate(18);

        $view = view('index.list') -> with('product_list' , $product_obj);

        $data['view_content'] = response($view) -> getContent();
        $data['page_count'] = $product_obj -> lastPage();
//dump($data);exit;
        return $data;

    }



    #详情页
    public function shopcontent(){
        $sku_id=request()->get('id');

        $sku_info=GoodsSku::with('goods')
            ->where('sku_id',$sku_id)
            ->first();


        return view('index.shopcontent',['sku'=>$sku_info]);
    }



    public function content(){
        $res=Data::where('status',1)
            ->get();

        return view('title.upload',['res'=>$res]);

    }







}
