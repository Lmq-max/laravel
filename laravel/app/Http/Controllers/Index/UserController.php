<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends CommonController{

    #个人中心
    public function userpage(Request $request){

        return view('index.user.userpage',['show_footer'=>1]);
    }

}
