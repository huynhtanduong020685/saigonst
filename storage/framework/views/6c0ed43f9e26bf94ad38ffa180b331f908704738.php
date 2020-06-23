<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('title', __('Page could not be found')); ?>

<?php $__env->startSection('message'); ?>
    <h4><?php echo e(__('This may have occurred because of several reasons')); ?></h4>
    <ul>
        <li><?php echo e(__('The page you requested does not exist.')); ?></li>
        <li><?php echo e(__('The link you clicked is no longer.')); ?></li>
        <li><?php echo e(__('The page may have moved to a new location.')); ?></li>
        <li><?php echo e(__('An error may have occurred.')); ?></li>
        <li><?php echo e(__('You are not authorized to view the requested resource.')); ?></li>
    </ul>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('theme.flex-home::views.error-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/views/404.blade.php ENDPATH**/ ?>