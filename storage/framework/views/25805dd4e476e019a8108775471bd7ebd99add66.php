<?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <label class="checkbox-inline">
        <input name="features[]" type="checkbox" value="<?php echo e($feature->id); ?>" <?php if(in_array($feature->id, $selectedFeatures)): ?> checked <?php endif; ?>><?php echo e($feature->name); ?>

    </label>&nbsp;
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/plugins/real-estate/resources/views//partials/form-features.blade.php ENDPATH**/ ?>