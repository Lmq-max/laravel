@extends('admin.layout.main')
@section('content')
    <form class="layui-form" action="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

            <div class="layui-form-item">
                <label class="layui-form-label">群发内容</label>
                <div class="layui-input-block">
                    <input type="text" id="attention" name="sendname" class="layui-input">
                </div>
            </div>

            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="*">群发</button>
                <button class="layui-btn" lay-submit lay-filter="open">openid群发</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
            @endsection
    </form>
            <script src="{{env('STATIC_URL')}}/jquery-3.2.1.min.js"></script>
            <link rel="stylesheet" href="{{env('STATIC_URL')}}/layui/css/layui.css">
            <script src="{{env('STATIC_URL')}}/layui/layui.js"></script>
            <script type="text/javascript">
                $(function(){
                    $.ajaxSetup({ headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    layui.use(['form','layer'],function() {
                        var layer = layui.layer;
                        var form = layui.form;

                        //*监听提交*/
                        form.on('submit(*)', function(data){
                            var sendname = $('#attention').val();
                            var type=1;
                            $.ajax({
                                url: "{{url('main/send')}}",
                                data:'sendname='+sendname+'&type='+type,
                                type:'post',
                                dataType:'json',
                                success:function (json_info) {
                                    //console.log(json_info);
                                    if (json_info.status == 1000) {
                                        alert('发送成功');
                                    } else {
                                        alert(json_info.data)
                                    }
                                }
                            });
                            return false;
                        });

                        //*监听提交*/
                        form.on('submit(open)', function(data){
                            var sendname = $('#attention').val();
                            var type=2;
                            $.ajax({
                                url: "{{url('main/send')}}",
                                data:'sendname='+sendname+'&type='+type,
                                type:'post',
                                dataType:'json',
                                success:function (json_info) {
                                    //console.log(json_info);
                                    if (json_info.status == 1000) {
                                        alert('发送成功');
                                    } else {
                                        alert(json_info.data)
                                    }
                                }
                            });
                            return false;
                        });
                    })
                })
            </script>
