
        <?php $__currentLoopData = $cate_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li id="23468">
                                    <span class="gList_l fl">
                                        <img class="lazy" src="<?php echo e(env('PUBLIC_URL')); ?><?php echo e($v['goods_img']); ?>" style="height:120px">
                                    </span>
                <div class="gList_r">
                    <h3 class="gray6"><a href="<?php echo e(url('details')); ?>?sku_id=<?php echo e($v['sku_id']); ?>"><?php echo e($v['sku_name']); ?></a></h3>
                    <em class="gray9">价值：￥<?php echo e($v['sku_price']); ?></em>
                    <em class="gray9">销量:<?php echo e($v['sku_sale_number']); ?></em>
                    <div class="gRate">
                        <div class="Progress-bar">
                            <p class="u-progress">
                                                    <span style="width: 91.91286930395593%;" class="pgbar">
                                                        <span class="pging"></span>
                                                    </span>
                            </p>
                            <ul class="Pro-bar-li">
                                <li class="P-bar01"><em>7342</em>已参与</li>
                                <li class="P-bar02"><em>7988</em>总需人次</li>
                                <li class="P-bar03"><em>646</em>剩余</li>
                            </ul>
                        </div>
                        <a codeid="12785750" class="" canbuy="646"><s></s></a>
                    </div>
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>