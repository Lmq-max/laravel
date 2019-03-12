<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





//前台路由组  控制器在 "App\Http\Controllers\Home" 命名空间下
Route::group(['namespace' => 'Index'], function(){
    // 默认访问index控制器下的index方法
    Route::any('/', [
        'as' => 'index', 'uses' => 'IndexController@index'
    ]);
    Route::any('test1','ApiController@test1');
    Route::any('getUserTableName','AccountController@getUserTableName');
    Route::any('a','AccountController@a');
    Route::any('redis','ShopcartController@redis');
    Route::any('b','AccountController@b');
    Route::any('quit','AccountController@quit');
    Route::any('elastic','IndexController@elastic');
    Route::any('search','SearchController@search');
    Route::any('find','SearchController@find');
    Route::any('edituser','AccountController@edituser');
    #商品接口
    Route::any('product_list','ProductController@product_list');
    #微信
    Route::any('callback','WechatController@callback');
    Route::any('wechat_open','WechatController@wechat_open');
    Route::any('w_login2','WechatController@w_login2');
    Route::any('w_login3','WechatController@w_login3');
    Route::any('wx_pay1','PaymentController@wx_pay1');
    Route::any('loo','PaymentController@loo');
    Route::any('loo2','PaymentController@loo2');

    #首页
    Route::any('index','IndexController@index');
    #登录
    Route::any('login','AccountController@login');
    #注册
    Route::any('register','AccountController@register');
    Route::any('regauth','AccountController@regauth');
    Route::any('sendCode','AccountController@sendCode');
    Route::any('regauths','AccountController@regauths');
    #流加载
    Route::any('productList','IndexController@productList');
    #详情页
    Route::any('shopcontent','IndexController@shopcontent');
    Route::any('content','IndexController@content');
    #验证码
    Route::any('captcha-test', function()
    {
        if (Request::getMethod() == 'POST')
        {
            $rules = ['captcha' => 'required|captcha'];

            $validator = \Illuminate\Support\Facades\Validator::make(\Illuminate\Support\Facades\Input::all(), $rules);
            if ($validator->fails())
            {
                echo '<p style="color: #ff0000;">Incorrect!</p>';
            }
            else
            {
                echo '<p style="color: #00ff30;">Matched :)</p>';
            }
        }

        $form = '<form method="post" action="captcha-test">';
        $form .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $form .= '<p>' . captcha_img() . '</p>';
        $form .= '<p><input type="text" name="captcha"></p>';
        $form .= '<p><button type="submit" name="check">Check</button></p>';
        $form .= '</form>';
        return $form;

    });

    #竞拍
    Route::any('auction_show','AuctionsController@auction_show');
    #商品列表
    Route::any('all_add','AllshowController@all_add');
    Route::any('searcha','AllshowController@searcha');
    Route::any('all_show','AllshowController@all_show');
    Route::any('details','AllshowController@details');
    #购物车
    Route::any('cart','ShopcartController@cart');
    Route::any('cart_show','ShopcartController@cart_show');
    Route::any('number','ShopcartController@number');
    #找回密码
    Route::any('find_pwd','FindpwdController@find_pwd');
    Route::any('savepwd','FindpwdController@savepwd');
    Route::any('sendCode','FindpwdController@sendCode');
    Route::any('save','FindpwdController@save');

    #个人中心
    Route::any('userpage','UserController@userpage');
    Route::any('prolist','AllshowController@prolist');
#手机支付
    Route::any('alipay','ShopcartController@alipay');
    Route::any('num_price','ShopcartController@num_price');
    Route::any('cart_del','ShopcartController@cart_del');
    Route::any('order','ShopcartController@order');
    Route::any('payment','ShopcartController@payment');
    Route::any('city','ShopcartController@city');
    #订单
    Route::any('order_add','PaymentController@order_add');
});


//后台路由组 控制器在 "App\Http\Controllers\User" 命名空间下
Route::group(['namespace' => 'User' ,'prefix'=>'main' ], function(){
    // 后台的首页
    Route::get('/', [
        'as' => 'main', 'uses' => 'AdminController@main'
    ]);
    Route::any('/api_upload', [
        'as' => 'api_upload', 'uses' => 'AdminController@api_upload'
    ]);
    #轮播图管理
    Route::any('/chartshow', [
        'as' => 'chartshow', 'uses' => 'TitleController@chartshow'
    ]);
    Route::any('/adminAudit', [
        'as' => 'adminAudit', 'uses' => 'TitleController@adminAudit'
    ]);
    Route::any('/title', [
        'as' => 'title', 'uses' => 'TitleController@title'
    ]);
    Route::any('/upload', [
        'as' => 'upload', 'uses' => 'TitleController@upload'
    ]);

    #竞拍管理
    Route::any('/auction_add', [
        'as' => 'auction_add', 'uses' => 'AuctionController@auction_add'
    ]);

    #分类管理
    Route::any('/cate_add', [
        'as' => 'cate_add', 'uses' => 'CategoryController@cate_add'
    ]);
    Route::any('/cate_show', [
        'as' => 'cate_show', 'uses' => 'CategoryController@cate_show'
    ]);
    Route::any('/delete', [
        'as' => 'delete', 'uses' => 'CategoryController@delete'
    ]);

    Route::any('/update', [
        'as' => 'update', 'uses' => 'CategoryController@update'
    ]);
    Route::any('/save', [
        'as' => 'save', 'uses' => 'CategoryController@save'
    ]);

    #权限节点
    Route::any('/power', [
        'as' => 'power', 'uses' => 'PowerController@power'
    ]);

    #品牌管理
    Route::any('/brandadd', [
        'as' => 'brandadd', 'uses' => 'BrandController@brandadd'
    ]);
    Route::any('/uploads', [
        'as' => 'uploads', 'uses' => 'BrandController@uploads'
    ]);
    Route::any('/brand_show', [
        'as' => 'brand_show', 'uses' => 'BrandController@brand_show'
    ]);
    Route::any('/brand_info', [
        'as' => 'brand_info', 'uses' => 'BrandController@brand_info'
    ]);
    Route::any('/brand_del', [
        'as' => 'brand_del', 'uses' => 'BrandController@brand_del'
    ]);
    Route::any('/brand_update', [
        'as' => 'brand_update', 'uses' => 'BrandController@brand_update'
    ]);
    Route::any('/brand_save', [
        'as' => 'brand_save', 'uses' => 'BrandController@brand_save'
    ]);

    #商品管理
    Route::any('/goods_add', [
        'as' => 'goods_add', 'uses' => 'GoodsController@goods_add'
    ]);
    Route::any('/goods_show', [
        'as' => 'goods_show', 'uses' => 'GoodsController@goods_show'
    ]);
    Route::any('/goods_uploads', [
        'as' => 'goods_uploads', 'uses' => 'GoodsController@goods_uploads'
    ]);
    Route::any('/goods_upload', [
        'as' => 'goods_upload', 'uses' => 'GoodsController@goods_upload'
    ]);
    #公众号  关注回复
    Route::any('/app_add', [
        'as' => 'app_add', 'uses' => 'AppController@app_add'
    ]);
    #关键字回复
    Route::any('/keyword', [
        'as' => 'keyword', 'uses' => 'AppController@keyword'
    ]);
    #图片上传
    Route::any('/key_upload', [
        'as' => 'key_upload', 'uses' => 'AppController@key_upload'
    ]);
    #视频上传
    Route::any('/key_video', [
        'as' => 'key_video', 'uses' => 'AppController@key_video'
    ]);
    Route::any('/menu', [
        'as' => 'menu', 'uses' => 'AppController@menu'
    ]);
    Route::any('/menu_list', [
        'as' => 'menu_list', 'uses' => 'AppController@menu_list'
    ]);
    Route::any('/send', [
        'as' => 'send', 'uses' => 'AppController@send'
    ]);

    #微信
    Route::any('/index', [
        'as' => 'index', 'uses' => 'WechatMainController@index'
    ]);
    Route::any('/token', [
        'as' => 'token', 'uses' => 'WechatMainController@token'
    ]);
    Route::any('/media', [
        'as' => 'media', 'uses' => 'WechatMainController@media'
    ]);
    Route::any('/app', [
        'as' => 'app', 'uses' => 'WechatMainController@app'
    ]);
    Route::any('/api_add', [
        'as' => 'api_add', 'uses' => 'WechatMainController@api_add'
    ]);
    Route::any('/get_all', [
        'as' => 'get_all', 'uses' => 'WechatMainController@get_all'
    ]);
    Route::any('/send', [
        'as' => 'send', 'uses' => 'WechatMainController@send'
    ]);
    Route::any('/scene', [
        'as' => 'scene', 'uses' => 'WechatMainController@scene'
    ]);
    Route::any('/more', [
        'as' => 'more', 'uses' => 'WechatMainController@more'
    ]);
    Route::any('/tag', [
        'as' => 'tag', 'uses' => 'WechatMainController@tag'
    ]);
    Route::any('/cgi_bin', [
        'as' => 'cgi_bin', 'uses' => 'WechatMainController@cgi_bin'
    ]);
    Route::any('/cgi', [
        'as' => 'cgi', 'uses' => 'WechatMainController@cgi'
    ]);
    Route::any('/cgi_del', [
        'as' => 'cgi_del', 'uses' => 'WechatMainController@cgi_del'
    ]);
    Route::any('/cgi_openid', [
        'as' => 'cgi_openid', 'uses' => 'WechatMainController@cgi_openid'
    ]);
    Route::any('/cgi_number', [
        'as' => 'cgi_number', 'uses' => 'WechatMainController@cgi_number'
    ]);
    Route::any('/cgi_num_del', [
        'as' => 'cgi_num_del', 'uses' => 'WechatMainController@cgi_num_del'
    ]);
    Route::any('/cgi_num_list', [
        'as' => 'cgi_num_list', 'uses' => 'WechatMainController@cgi_num_list'
    ]);
    Route::any('/cgi_num_msg', [
        'as' => 'cgi_num_msg', 'uses' => 'WechatMainController@cgi_num_msg'
    ]);
    Route::any('/conts', [
        'as' => 'conts', 'uses' => 'WechatMainController@conts'
    ]);
    Route::any('/root_list', [
        'as' => 'root_list', 'uses' => 'WechatMainController@root_list'
    ]);

    Route::any('/root_add', [
        'as' => 'root_add', 'uses' => 'WechatMainController@root_add'
    ]);Route::any('/list_b', [
        'as' => 'list_b', 'uses' => 'WechatMainController@list_b'
    ]);Route::any('/deltag', [
        'as' => 'deltag', 'uses' => 'WechatMainController@deltag'
    ]);Route::any('/qian', [
        'as' => 'qian', 'uses' => 'WechatMainController@qian'
    ]);Route::any('/msgs', [
        'as' => 'msgs', 'uses' => 'WechatMainController@msgs'
    ]);Route::any('/openid', [
        'as' => 'openid', 'uses' => 'WechatMainController@openid'
     ]);Route::any('/w_pay', [
        'as' => 'w_pay', 'uses' => 'WepayController@w_pay'
    ]);Route::any('/qrcode2', [
        'as' => 'qrcode2', 'uses' => 'WepayController@qrcode2'
    ]);Route::any('/qrcode3', [
        'as' => 'qrcode3', 'uses' => 'WepayController@qrcode3'
    ]);Route::any('/wechat_code', [
        'as' => 'wechat_code', 'uses' => 'WepayController@wechat_code'
    ]);Route::any('/alipay2', [
        'as' => 'alipay2', 'uses' => 'WepayController@alipay2'
    ]);Route::any('/wx_pay', [
        'as' => 'wx_pay', 'uses' => 'WepayController@wx_pay'
    ]);Route::any('/code_img', [
        'as' => 'code_img', 'uses' => 'WepayController@code_img'
    ]);Route::any('/lo', [
        'as' => 'lo', 'uses' => 'WepayController@lo'
    ]);Route::any('/lo2', [
        'as' => 'lo2', 'uses' => 'WepayController@lo2'
    ]);

    #接口
    Route::any('/api', [
        'as' => 'api', 'uses' => 'ApiController@api'
    ]);

});

Route::resource('posts','PostController');


















