<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;

use App\Models\Auction;
use App\Models\Data;
use Illuminate\Http\Request;

class AuctionsController extends CommonController
{

    /**
     * 竞拍展示
     */
    public function auction_show(){

        $res=Auction::where('g_id',2)->first();



        return view('index.auction.auctionshow',['res'=>$res]);
    }







}