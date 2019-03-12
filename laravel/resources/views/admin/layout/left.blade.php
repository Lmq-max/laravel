
<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item">
                <a class="" href="javascript:;">轮播图设置</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{url('main/title')}}">轮播图添加</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">竞拍设置</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{url('main/auction_add')}}">竞拍添加</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">分类管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{url('main/cate_add')}}">分类添加</a></dd>
                    <dd><a href="{{url('main/cate_show')}}">分类展示</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">权限节点</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{url('main/power')}}">节点添加</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">品牌管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{url('main/brandadd')}}">品牌添加</a></dd>
                    <dd><a href="{{url('main/brand_show')}}">品牌展示</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">商品管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{url('main/goods_add')}}">商品添加</a></dd>
                    <dd><a href="{{url('main/goods_show')}}">商品展示</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">公众号管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{url('main/app_add')}}">关注回复</a></dd>
                    <dd><a href="{{url('main/keyword')}}">关键字回复</a></dd>
                    <dd><a href="{{url('main/menu')}}">自定义菜单</a></dd>
                    <dd><a href="{{url('main/send')}}">群发消息</a></dd>
                    <dd><a href="{{url('main/tag')}}">添加标签</a></dd>
                </dl>
            </li>
        </ul>
    </div>
</div>