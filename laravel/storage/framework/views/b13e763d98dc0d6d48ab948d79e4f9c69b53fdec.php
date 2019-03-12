<?php $__env->startComponent('layouts.header'); ?>
    <?php $__env->slot('title'); ?>
        <?php echo $__env->yieldContent('title'); ?>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->yieldSection(); ?>
<?php if($show_footer==1): ?>
<?php $__env->startComponent('layouts.footer'); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>