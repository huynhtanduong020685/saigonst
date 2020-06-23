<div class="image-box">
    <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>" class="image-data">
    <div class="preview-image-wrapper <?php if(!Arr::get($attributes, 'allow_thumb', true)): ?> preview-image-wrapper-not-allow-thumb <?php endif; ?>">
        <img src="<?php echo e(get_object_image($value, Arr::get($attributes, 'allow_thumb', true) == true ? 'thumb' : null)); ?>" alt="<?php echo e(__('preview image')); ?>" class="preview_image" <?php if(Arr::get($attributes, 'allow_thumb', true)): ?> width="150" <?php endif; ?>>
        <a class="btn_remove_image" title="<?php echo e(trans('core/base::forms.remove_image')); ?>">
            <i class="fa fa-times"></i>
        </a>
    </div>
    <div class="image-box-actions">
        <a href="#" class="btn_gallery" data-result="<?php echo e($name); ?>" data-action="<?php echo e($attributes['action'] ?? 'select-image'); ?>">
            <?php echo e(trans('core/base::forms.choose_image')); ?>

        </a>
    </div>
</div>
<?php /**PATH D:\WWW\saigonstar2020\platform/core/base/resources/views//elements/forms/image.blade.php ENDPATH**/ ?>