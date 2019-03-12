@extends('admin.layout.main')
@section('content')
<form class="layui-form">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="layui-tab">
        <ul class="layui-tab-title">
            <li  class="layui_this">基本信息</li>
            <li>基本属性</li>
            <li>商品销售属性</li>
        </ul>
        <div class="layui-tab-content">
            <!--基本信息-->
            <div class="layui-tab-item layui-show">

                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                    <legend>品牌添加</legend>
                </fieldset>
                <div style="width: 600px;">
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="goods_name" required   placeholder="商品名称" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分类</label>
                        <div class="layui-input-block">
                            <select name="cate_id">
                                <option value="">--请选择--</option>
                                @foreach($cate_info as $v)
                                <option value="{{$v['cate_id']}}">{{str_repeat('-',$v['level']*2)}}{{$v['cate_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">品牌</label>
                        <div class="layui-input-block">
                            <select name="brand_id" >
                                <option value="">--请选择--</option>
                                @foreach($brand_info as $vv)
                                <option value="{{$vv['brand_id']}}">{{str_repeat('-',$v['level']*2)}}{{$vv['brand_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">本店价格</label>
                        <div class="layui-input-block">
                            <input type="text" name="goods_selfprice" required   placeholder="本店价格" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">市场价格</label>
                        <div class="layui-input-block">
                            <input type="text" name="goods_marketprice" required   placeholder="市场价格" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品状态</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="goods_up" value="1" title="是否上架">
                            <input type="checkbox" name="goods_new" value="1" title="新品" >
                            <input type="checkbox" name="goods_best" value="1" title="精品" >
                            <input type="checkbox" name="goods_hot" value="1" title="热销" >
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品数量</label>
                        <div class="layui-input-block">
                            <input type="text" name="goods_stock" required  placeholder="商品数量" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">赠送积分</label>
                        <div class="layui-input-block">
                            <input type="text" name="goods_score" required   placeholder="赠送积分" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">商品图片</label>
                        <div class="layui-input-block">
                            <input type="hidden" name="goods_img" id="goods_img">
                            <button type="button" class="layui-btn" id="myfile">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">文本</label>
                        <div class="layui-input-block" >
                            <textarea id="demo" name="goods_content" style="display: none;"></textarea>
                            <script>
                                var layedit;
                                var index;
                                layui.use('layedit', function(){

                                    layedit = layui.layedit;
                                    layedit.set({
                                        uploadImage: {
                                            url: "{{url('main/goods_uploads')}}" //接口url
                                            ,type: 'post' //默认post
                                        }
                                    });
                                    index=layedit.build('demo',{
                                        height: 180 //设置编辑器高度，
                                    });
                                });
                            </script>
                        </div>
                    </div>

                </div>


            </div>
            <!--基本信息END-->
            <!--基本属性-->
            <div class="layui-tab-item" id="basic">
                <span style="color:red">请先选择分类</span>
            </div>
            <!--基本属性END-->

            <!--商品销售属性-->
            <div class="layui-tab-item" id="sale">
                <span style="color:red">请先选择分类</span>
            </div>
            <!--商品销售属性END-->
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
<link rel="stylesheet" href="{{env('LAYUI_URL')}}/css/layui.css">
<script src="{{env('LAYUI_URL')}}/layui.js"></script>
<script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        layui.use(['form', 'layer','upload'], function () {
            var layer = layui.layer;
            var form = layui.form;
            var upload = layui.upload;
            //单张图片上传
            upload.render({
                elem:'#myfile'
                ,url:"{{url('main/goods_upload')}}"
                ,filed:'file'
                ,done:function(res,index,upload){
                    layer.msg(res.font,{icon:res.code});
                    if(res.code==1){
                        $('#goods_img').val(res.src);
                    }
                }
            });
            /*监听提交*/
            form.on('submit(*)', function(data){
                data.field.goods_content=layedit.getContent(index);
                $.post(
                    "{{url('main/goods_add')}}",
                    data.field,
                    function(json_info) {
                       // console.log(json_info);
                        //
                        if (json_info.status == 1000) {
                            alert('添加成功')
                        }else{
                            alert(json_info.msg);
                        }
                    },'json'
                );
                //console.log(data.field)
                return false;
            });

            form.on('select(category)', function(data){
                //console.log(data.elem); //得到select原始DOM对象
                var category_id=data.value; //得到被选中的值
                //console.log(data.othis); //得到美化后的DOM对象
                $.ajax({
                    url:'{:url("Attr/basicAttrShow")}',
                    data:'category_id='+category_id,
                    type:'post',
                    success:function(html_info) {
                        $('#basic').html(html_info);
                        form.render();
                    }
                })

                $.ajax({
                    url:'{:url("Attr/saleAttrShow")}',
                    data:'category_id='+category_id,
                    type:'post',
                    success:function(html_info) {
                        $('#sale').html(html_info);
                        form.render();
                    }
                })
            });


        })
    })
</script>


