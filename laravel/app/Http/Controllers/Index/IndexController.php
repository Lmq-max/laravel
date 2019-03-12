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
    public function elastic(){
        require_once(  '../vendor/autoload.php');
        $esclient = \Elasticsearch\ClientBuilder::create()
            ->setHosts(["192.168.43.252:9200"])
            ->build();
        /*$params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => '10',
            'body' => [
                'testField' => 'abc',
                'title'	=> '你好,从纵向即文档这个维度来看，每列代表文档包含了哪些单词，。'
            ]
        ];
        $esclient->index($params);*/
        /*$params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => '10',
        ];
     $a=$esclient->get($params);
        var_dump($a);
        //$esclient->delete($params);*/
               /* $params = [
            'index' => 'my_indexa',
            'type' => 'my_typea',
            'body' => [
                ['index' => [ '_id' => 1]],
                [
                    'testField' => 'abc',
                    'title' => '你好,从纵向即文档这个维度来看，每列代表文档包含了哪些单词，。',
                    'content' => '中国非常强大的哈哈哈,不错,及时这个时代的步伐,研究红色呢过名生命科学'
                ],
                ['index' => [ '_id' => 2]],
                [
                    'testField' => '青山绿水',
                    'title' => '无名英雄',
                    'content' => '力量是非常强大'
                ],
                ['index' => [ '_id' => 3]],
                [
                    'testField' => 'abc',
                    'title' => '代码的力量',
                    'content' => '天天上学'
                ]
            ]
        ];

        $a=$esclient->bulk($params);
        var_dump($a);*/
       /* $search_params = [
            'index' => 'my_indexa',
            'type' => 'my_typea',
            'body'=> [
                'query'	=> [
                    'match'	=> [
                        'testField'	=> 'abc'

                    ]
                ]
            ]
        ];
       $a=$esclient->search($search_params);
        var_dump($a);*/
        /*$search_params = [
            'index' => 'my_indexa',
            'type' => 'my_typea',
            'body'=> [
                'query'	=> [
                    'bool'	=> [
                        'should'	=> [
                            ['match'	=> ['testField'	=> 'abc']],
                            ['match'	=> ['title'	=> '中']]
                        ]
                    ]

                ]

            ]

        ];
     $a=$esclient->search($search_params);
     var_dump($a);*/
        $params = [
            'body' => [
                'text' => '天天敲代码非常高兴',
                'analyzer'=>'ik_max_word' //ik_max_word 精细  ik_smart 粗略
            ]
        ];
        $params['body']['text']='王狗蛋';
        $res =  $esclient->indices()->analyze($params);
        print_r($res);
        /*$params = [
            'index' => 'my_index_user1',
        ];
        $res =  $esclient->indices()->create($params);
        var_dump($res);*/
        /*$params = [
            'index' => 'my_index_user1',
            'type' => 'my_type_user1',
            'body' => [
                'my_type_user1' => [
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

        $res = $esclient->indices()->putMapping($params);
        var_dump($res);*/
        /*$search_params = [
            'index' => 'my_index_user1',
            'type' => 'my_type_user1',
            'body' => [
                'query' => [
                    'match' => [
                        'userinfo' => '访问目录'
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
                        'userinfo' => new \stdClass()
                    ]
                ]
            ]
        ];
        $res = $esclient->search($search_params);
        print_r($res);*/

    }
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
