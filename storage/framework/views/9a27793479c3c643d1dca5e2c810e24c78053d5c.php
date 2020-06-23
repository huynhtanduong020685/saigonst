<div class="object-images-wrapper">
    <a href="#" class="add-new-object-image js-btn-trigger-add-image"
       data-name="images[]"><?php echo e(trans('plugins/real-estate::property.form.button_add_image')); ?>

    </a>
    <?php $object_images = old('images', !empty($object) ? $object->images : null); ?>
    <div class="images-wrapper">
        <div data-name="images[]" class="text-center cursor-pointer js-btn-trigger-add-image default-placeholder-object-image <?php if(is_array($object_images) && !empty($object_images)): ?> hidden <?php endif; ?>">
            <img src="<?php echo e(url('vendor/core/images/placeholder.png')); ?>" alt="<?php echo e(__('Image')); ?>" width="120">
            <br>
            <p style="color:#c3cfd8"><?php echo e(__('Sử dụng nút')); ?> <strong><?php echo e(__('Chọn hình')); ?></strong> <?php echo e(__('để thêm hình')); ?>.</p>
        </div>
        <ul class="list-unstyled list-gallery-media-images clearfix <?php if(!is_array($object_images) || empty($object_images)): ?> hidden <?php endif; ?>" style="padding-top: 20px;">
            <?php if(is_array($object_images) && !empty($object_images)): ?>
                <?php $__currentLoopData = $object_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="object-image-item-handler">
                        <?php echo $__env->make('plugins/real-estate::partials.components.image', [
                            'name' => 'images[]',
                            'value' => $image
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script id="object_select_image_template" type="text/x-custom-template">
    <?php echo $__env->make('plugins/real-estate::partials.components.image', [
        'name' => '__name__',
        'value' => null
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</script>
<?php /**PATH D:\WWW\saigonstar2020\platform/plugins/real-estate/resources/views//partials/form-images.blade.php ENDPATH**/ ?>