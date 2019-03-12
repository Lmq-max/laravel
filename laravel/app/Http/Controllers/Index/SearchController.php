<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\CommonController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SearchController extends CommonController{
    public function search(Request $request){
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
    public function find(){
        $data=json_decode(json_encode(DB::table('shop_brand')->get()->toArray()),true);
        require_once(  '../vendor/autoload.php');
        $esclient = \Elasticsearch\ClientBuilder::create()
            ->setHosts(["192.168.43.252:9200"])
            ->build();
        /*$params = [
            'index' => 'index_use',
            'type' => 'type_use',
            ];
        foreach ($data as $v){
            $params['body'][]=['index' => [ '_id' => $v['brand_id']]];
            unset($v['brand_id']);
            $params['body'][]=$v;
        }*/
        ###########创建索引###########
       /* $params = [
            'index' => 'index_use',
        ];
        $re =  $esclient->indices()->create($params);*/
        #############创建索引结束##############
        ###########创建映射###########
        /*$params = [
            'index' => 'index_use',
            'type' => 'type_use',
            'body' => [
                'type_use' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [

                        'userinfo' => [
                            'type' => 'text', // 字符串型
                            'analyzer'=>'ik_max_word', //ik_max_word 最细粒度拆分 ik_smart最粗粒度拆分
                            'search_analyzer'=> 'ik_max_word'
                        ]

                    ]
                ]
            ]
        ];

        $res = $esclient->indices()->putMapping($params);*/
        ###########创建映射结束###########
          //$a=$esclient->bulk($params);

        $search_params = [
            'index' => 'index_use',
            'type' => 'type_use',
            'body' => [
                'query' => [
                    'match' => [
                        'brand_describe' => '便宜'
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
        echo '</pre>';
        var_dump($res['hits']['hits']);exit;
    }
}