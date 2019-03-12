<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends CommonController{

    #商品列表接口
    public function product_list(Request $request){

            #接受页码
            $page=$request->post('page',1);

            #接受每页条款
            $page_size=$request->post('page_size',10);
            $product_where=[];
            #判断是否存在状态筛选
            $status=$request->post('status');
            #初始化排序
            $order=[];
            #状态筛选  1.s 2.最新 3.精品
            if(!empty($status)){
                switch($status){
                    case 1:
                        $product_where['goods_hot']=1;
                        break;
                    case 2:
                        $order['gs.ctime']='desc';
                        break;
                    case 3:
                        $product_where['goods_best']=1;
                        break;
                    default:
                        break;
                }
            }
            #接收排序的字段
            #order  1.价格排序 2.销量排序 3.新品 4.好评
            #order_type 1.正序 2.倒序
            $order=[];
            $order_fields=$request->post('order');
            if(!empty($order_fields)){
                $order_type=$request->post('order_type');
                if($order_type==1){
                    $order_type='asc';
                }else if($order_type==2){
                    $order_type='desc';
                }else{
                    $order_type='asc';
                }
                switch($order_fields){
                    case 1:
                        $order['sku_price']=$order_type;
                        break;
                    case 2:
                        $order['sku_sale_number']=$order_type;
                        break;
                    case 3:
                        $order['id']='desc';
                        break;
                    default:
                        break;
                }
            }

            #判断last_id是否传递
            $last_id=$request->post('last_id');
            if(!empty($last_id)){
                if($order_type==1){
                    $product_where['gs.sku_id']=1;
                }

            }



            #商品名字的筛选
            $keyword=$request->post('keyword');
            if(!empty($keyword)){
                $product_where[]=['gs.sku_name','like','%'.$keyword.'%'];

            }
            #品牌的筛选
            $brand_id=$request->post('brand_id');
            if(!empty($brand_id)){
                $product_where['b.brand_id']=$brand_id;
            }
            #分类的筛选
            $cate_id=$request->post('category_id');
            if(!empty($cate_id)){
                $product_where['c.cate_id']=$cate_id;
            }
            $product_where=[];
            #查询所有上架的商品
            $product_where['gs.status']=4;
            #查询数据
            $goods_sku_obj=DB::table('shop_goods_sku as gs')
                ->join('shop_goods as g','g.goods_id','=','gs.goods_id')
                ->join('shop_brand as b','b.brand_id','=','g.brand_id')
                ->join('shop_category as c','c.cate_id','=','g.cate_id')
                ->orderMore($order)
                ->where($product_where)
                ->paginate($page_size);
            if($goods_sku_obj){
                $goods_sku=collect($goods_sku_obj)->toArray();
            }
            $page_data=[];
            $page_data['has_more']=$goods_sku['last_page']>$goods_sku_obj['current_page'] ? 1:0 ;
            $page_data['last_id']=$goods_sku['to'];
            $page_data['total_page']=$goods_sku['last_page'];
            $page_data['this_page']=$goods_sku['current_page'];
            $page_data['page_date']=$goods_sku['data'];
            $arr=[
                'status'=>1000,
                'msg'=>'success',
                'data'=>$page_data
            ];
            return $arr;




    }
}
