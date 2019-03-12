<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\GoodsSku;
class AllshowController extends CommonController{
    public function searcha(Request $request){
        $esclient = \Elasticsearch\ClientBuilder::create()
            ->setHosts(["192.168.43.252:9200"])
            ->build();
        if($request->isMethod('post')){
            $username=$request->post('username');
            $search_params = [
                'index' => 'index_use',
                'type' => 'type_use',
                'body' => [
                    'query' => [
                        'match' => [
                            'brand_describe' => $username
                        ]
                    ],
                    //设置高亮
                    "highlight" => [
                        "pre_tags" => [
                            '<span style="color:red">'
                        ],
                        "post_tags" => [
                            '</span>'

                        ],
                        'fields'=> [
                            'brand_describe' => new \stdClass()
                        ]
                    ]
                ]
            ];
            $res = $esclient->search($search_params);
            //var_dump($res);exit;
            if(empty($res['hits']['hits'])){
                return json_encode(['data'=>'你搜索的数据不存在','status'=>100]);
            }else{
                return json_encode(['res'=>$res['hits']['hits']]);
            }

        }else{
            return view('search');
        }

    }

    public function all_add(Request $request){

        $cate_info=Category::where('cate_show',1)->get()->toArray();

        $Info=$this->getIndexCateInfo($cate_info);

        return view('index.allshow.allshow',['cateInfo'=>$Info])->with(['show_footer'=>1]);
    }

    /*public function all_show(Request $request){

        $cate_id=$request->all('cate_id');

        $users = Category::join('shop_goods', 'shop_category.cate_id', '=', 'shop_goods.cate_id')
            ->join('shop_goods_sku', 'shop_goods.goods_id', '=', 'shop_goods_sku.goods_id')
            ->where('shop_category.cate_id',$cate_id)
            ->select('shop_goods_sku.*','shop_goods.goods_img')
            ->get()->toArray()
            ;
        if(empty($users)){
            return '该分类不存在货品';
        }

        return view('index.allshow.allshops',['users'=>$users])->with(['show_footer'=>1]);
    }*/

    public function details(){
        $sku_id=request()->get('sku_id');

        $sku_info=GoodsSku::with('goods')
            ->where('sku_id',$sku_id)
            ->first();


        return view('index.allshow.details',['sku'=>$sku_info]);
    }



    /*分类详情页*/
    public function all_show(Request $request){
        $cate_id=$request->all('cate_id');
        $where=[
            'shop_category.cate_id'=>$cate_id
        ];
        //dump($cate_id);exit;
        return view('index.allshow.allshops')->with(['show_footer'=>1,'cid'=> $cate_id['cate_id'],'title'=>'电商首页1']);
    }

    public function prolist(Request $request){
        $cate_id=$request->get('cid','');
        $order_field=$request->get('order_field',1);
        $order_type=$request->get('order_type',0);
        $order=[];
        $where=[
            ['c.cate_id',$cate_id],
        ];
        switch($order_field){
            case 1:
                $order='sku_sale_number';
                $by= 'desc';
                break;
            case 2:
//                echo $order_field;
//                echo $order_type;die;
                if($order_type==1){
                    $order='sku_sale_number';
                    $by='asc';
                }else{
                    $order='sku_sale_number';
                    $by= 'desc';
                }
                break;
            case 3:
                if($order_type==1){
                    $order='sku_price';
                    $by='asc';
                }else{
                    $order='sku_price';
                    $by= 'desc';
                }
                break;
            case 4:
                $where[]=['g.goods_new',1];
                $order= 'gs.ctime';
                $by= 'desc';
                break;
            default:
                $order='sku_sale_number';
                $by= 'desc';
                break;
        }
        //echo $cate_id;exit;
        $model=new Category();
        $cate_info=$model
            ->from('shop_category as c')
            ->join('shop_goods as g', 'g.cate_id', '=', 'c.cate_id')
            ->join('shop_goods_sku as gs', 'g.goods_id', '=', 'gs.goods_id')
            ->where($where)
            ->orderBy($order,$by)
            ->paginate(8);
//        $cate_info = json_encode($cate_info,true);
//
//        $cate_info = json_decode($cate_info,true);
//        print_r($cate_info);die;
        $view=view('index.allshow.list',['cate_info'=>$cate_info]);
        //dump($view);exit;
        $data['view_content']=response($view)->getContent();
        $data['page_count']=$cate_info->lastPage();
        //dump($data);exit;
        return $data;
    }




}
