<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<?php $__currentLoopData = config('core.media.media.libraries.stylesheets', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $css): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <link href="<?php echo e(url($css)); ?>" rel="stylesheet" type="text/css"/>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php echo $__env->make('core/media::config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/core/media/resources/views//header.blade.php ENDPATH**/ ?>