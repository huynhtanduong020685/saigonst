<ul <?php echo $options; ?>>
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <label for="menu_id_<?php echo e(strtolower(Str::slug($type))); ?>_<?php echo e($row->id); ?>" data-title="<?php echo e($row->name); ?>" data-reference-id="<?php echo e($row->id); ?>"
                   data-reference-type="<?php echo e($type); ?>">
                <?php echo Form::checkbox('menu_id', $row->id, null, ['id' => 'menu_id_' . $type . '_' . $row->id]); ?>

                <?php echo e($row->name); ?>

            </label>

            <?php if($row->children): ?>
                <?php echo Menu::generateSelect([
                        'model'     => $model,
                        'type'      => $type,
                        'parent_id' => $row->id
                    ]); ?>

            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH D:\WWW\saigonstar2020\platform/packages/menu/resources/views//partials/select.blade.php ENDPATH**/ ?>