<ul <?php echo $options; ?>>
    <?php $__currentLoopData = $menu_nodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="<?php echo e($row->css_class); ?> <?php if($row->url == Request::url()): ?> current <?php endif; ?>">
            <a href="<?php echo e($row->url); ?>" target="<?php echo e($row->target); ?>">
                <i class='<?php echo e(trim($row->icon_font)); ?>'></i> <span><?php echo e($row->title); ?></span>
            </a>
            <?php if($row->has_child): ?>
                <?php echo Menu::generateMenu([
                    'slug' => $menu->slug,
                    'parent_id' => $row->id
                ]); ?>

            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH D:\WWW\saigonstar2020\platform/packages/menu/resources/views//partials/default.blade.php ENDPATH**/ ?>