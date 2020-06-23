<?php if(empty($object)): ?>
    <div class="form-group <?php if($errors->has('slug')): ?> has-error <?php endif; ?>">
        <?php echo Form::permalink('slug', old('slug'), 0, $prefix); ?>

        <?php echo Form::error('slug', $errors); ?>

    </div>
<?php else: ?>
    <div class="form-group <?php if($errors->has('slug')): ?> has-error <?php endif; ?>">
        <?php echo Form::permalink('slug', $object->slug, $object->slug_id, $prefix, SlugHelper::canPreview(get_class($object)) && $object->status != \Botble\Base\Enums\BaseStatusEnum::PUBLISHED); ?>

        <?php echo Form::error('slug', $errors); ?>

    </div>
<?php endif; ?>
<input type="hidden" name="model" value="<?php echo e(get_class($object)); ?>">
<?php /**PATH D:\WWW\saigonstar2020\platform/packages/slug/resources/views//partials/slug.blade.php ENDPATH**/ ?>