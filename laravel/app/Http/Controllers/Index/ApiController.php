<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class ApiController extends CommonController{

    //请求api获取数据
    public function test1(){
        $url='http://www.api.com/a.php?type=2';
        $client=new Client();
        $response=$client->request('GET',$url);
        echo $response->getBody();
    }


}
