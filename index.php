
   <!-- <input type="text" value="" id="root">
    <input type="submit" value="抢购" class="root" >

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(function(){
        $('.root').click(function(){
           var a= $('#root').val();
            $.ajax({
                url:'./a.php',
                data:'a='+a,
                dataType:'json',
                type:'post',
                success:function(json_info){
                   if(json_info.status==1){
                     alert('抢购成功');
                   }else{
                       alert('抢购失败');
                   }
                }
            })
        })
    })
</script>
-->
   <?php
   echo 2;
   ?>



