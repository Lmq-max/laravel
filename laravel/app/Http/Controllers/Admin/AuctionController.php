<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;

use App\Models\Auction;
use App\Models\Data;
use Illuminate\Http\Request;

class AuctionController extends CommonController
{

    /**
     * 竞拍添加
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function auction_add(Request $request){
        if($request->isMethod('post')){
            $data=$request->post();
            $g_info=[
                'g_name'=>$data['g_name'],
                'g_price'=>$data['g_price'],
                'g_prices'=>$data['g_prices'],
                'g_time'=>$data['g_time'],
                'g_times'=>$data['g_times'],
                'ctime'=>time()
            ];

            $res=Auction::insert($g_info);

            if($res){
                return $this->success();
            }else{
                return $this->fail('添加失败');
            }
        }else{
            return view('blog.auction.auction');
        }
    }








}