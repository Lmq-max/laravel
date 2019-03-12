<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CommonController;

use Illuminate\Http\Request;

class AdminController extends CommonController
{
    public function main(Request $request)
    {
    return view('blog.layout.main');
    }



    //上传文件 功能实现方法
    public function api_upload(Request $request){

    }

}
