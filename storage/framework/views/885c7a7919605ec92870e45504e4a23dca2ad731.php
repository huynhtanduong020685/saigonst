<div class="onoffswitch">
    <input type="hidden" name="<?php echo e($name); ?>" value="0">
    <input type="checkbox" name="<?php echo e($name); ?>" class="onoffswitch-checkbox" id="<?php echo e($name); ?>" value="1" <?php if($value): ?> checked <?php endif; ?> <?php echo html_attributes_builder($attributes); ?>>
    <label class="onoffswitch-label" for="<?php echo e($name); ?>">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div><?php /**PATH D:\WWW\saigonstar2020\platform/core/base/resources/views//elements/forms/on-off.blade.php ENDPATH**/ ?>