<div class="list-photo-hover-overlay">
    <ul class="photo-overlay-actions">
        <li>
            <a class="mr10 btn-trigger-edit-object-image" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo e(__('Thay hình')); ?>">
                <i class="fa fa-edit"></i>
            </a>
        </li>
        <li>
            <a class="mr10 btn-trigger-remove-object-image" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo e(__('Xóa hình ảnh')); ?>">
                <i class="fa fa-trash"></i>
            </a>
        </li>
    </ul>
</div>
<div class="custom-image-box image-box">
    <input type="hidden"
           name="<?php echo e($name); ?>"
           value="<?php echo e($value); ?>"
           class="image-data">
    <img
            src="<?php echo e(get_image_url($value, 'thumb', false, config('media.default-img'))); ?>"
            alt="preview image" class="preview_image">
    <div class="image-box-actions">
        <a class="btn-images" data-result="<?php echo e($name); ?>" data-action="<?php echo e($attributes['action'] ?? 'select-image'); ?>">
            <?php echo e(trans('core/base::forms.choose_image')); ?>

        </a> |
        <a class="btn_remove_image">
            <span></span>
        </a>
    </div>
</div>
<?php /**PATH D:\WWW\saigonstar2020\platform/plugins/real-estate/resources/views//partials/components/image.blade.php ENDPATH**/ ?>