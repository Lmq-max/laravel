var layer;
layui.use(['layer'],function(){
    layer=layui.layer;
});
function alert(msg){
    layui.layer.msg(msg);
    return false;
}