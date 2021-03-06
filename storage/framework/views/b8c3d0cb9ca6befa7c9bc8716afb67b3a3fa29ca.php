<a href="#" class="btn-trigger-show-seo-detail"><?php echo e(trans('packages/seo-helper::seo-helper.edit_seo_meta')); ?></a>
<div class="seo-preview">
    <p class="default-seo-description <?php if(!empty($object->id)): ?> hidden <?php endif; ?>"><?php echo e(trans('packages/seo-helper::seo-helper.default_description')); ?></p>
    <div class="existed-seo-meta <?php if(empty($object->id)): ?> hidden <?php endif; ?>">
        <span class="page-title-seo">
             <?php echo e($meta['seo_title'] ?? (!empty($object->id) ? $object->name ?? $object->title : null)); ?>

        </span>

        <div class="page-url-seo ws-nm">
            <p>-</p>
        </div>

        <div class="page-description-seo ws-nm">
            <?php echo e(strip_tags($meta['seo_description'] ?? (!empty($object->id) ? $object->description : (!empty($object->id) && $object->content ? Str::limit($object->content, 250) : old('seo_meta.seo_description'))))); ?>

        </div>
    </div>
</div>


<div class="seo-edit-section hidden">
    <hr>
    <div class="form-group">
        <label for="seo_title" class="control-label"><?php echo e(trans('packages/seo-helper::seo-helper.seo_title')); ?></label>
        <?php echo Form::text('seo_meta[seo_title]', $meta['seo_title'] ?? old('seo_meta.seo_title'), ['class' => 'form-control', 'id' => 'seo_title', 'placeholder' => trans('packages/seo-helper::seo-helper.seo_title'), 'data-counter' => 120]); ?>

    </div>
    <div class="form-group">
        <label for="seo_description" class="control-label"><?php echo e(trans('packages/seo-helper::seo-helper.seo_description')); ?></label>
        <?php echo Form::textarea('seo_meta[seo_description]', strip_tags($meta['seo_description']) ?? old('seo_meta.seo_description'), ['class' => 'form-control', 'rows' => 3, 'id' => 'seo_description', 'placeholder' => trans('packages/seo-helper::seo-helper.seo_description'), 'data-counter' => 155]); ?>

    </div>
</div>
<?php /**PATH D:\WWW\saigonstar2020\platform/packages/seo-helper/resources/views//meta_box.blade.php ENDPATH**/ ?>