<?php if($showError && isset($errors)): ?>
    <?php $__currentLoopData = $errors->get($nameKey); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div <?php echo e($options['errorAttrs']); ?>><?php echo e($err); ?></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php /**PATH D:\WWW\saigonstar2020\platform/core/base/resources/views//forms/partials/errors.blade.php ENDPATH**/ ?>