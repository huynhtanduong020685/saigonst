<?php if(Arr::get($meta_box, 'before_wrapper')): ?>
    <?php echo Arr::get($meta_box, 'before_wrapper'); ?>

<?php endif; ?>

<?php if(Arr::get($meta_box, 'wrap', true)): ?>
    <div class="widget meta-boxes" <?php echo e(Html::attributes(Arr::get($meta_box, 'attributes', []))); ?>>
        <div class="widget-title">
            <h4>
                <span> <?php echo e(Arr::get($meta_box, 'title')); ?></span>
            </h4>
        </div>
        <div class="widget-body">
            <?php echo Arr::get($meta_box, 'content'); ?>

        </div>
    </div>
<?php else: ?>
    <?php echo Arr::get($meta_box, 'content'); ?>

<?php endif; ?>

<?php if(Arr::get($meta_box, 'after_wrapper')): ?>
    <?php echo Arr::get($meta_box, 'after_wrapper'); ?>

<?php endif; ?><?php /**PATH D:\WWW\saigonstar2020\platform/core/base/resources/views//forms/partials/meta-box.blade.php ENDPATH**/ ?>