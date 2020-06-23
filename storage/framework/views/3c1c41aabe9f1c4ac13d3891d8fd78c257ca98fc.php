<ul <?php echo $options; ?>>
    <?php $__currentLoopData = $menu_nodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="nav-item <?php echo e($row->css_class); ?>">
        <a class="nav-link <?php if($row->url == Request::url() || Str::contains(Request::url() . '?', $row->url)): ?> active text-orange <?php endif; ?>" href="<?php echo e($row->url); ?>" target="<?php echo e($row->target); ?>">
            <?php if($row->icon_font): ?><i class='<?php echo e(trim($row->icon_font)); ?>'></i> <?php endif; ?><?php echo e($row->title); ?>

            <?php if($row->url == Request::url()): ?> <span class="sr-only">(current)</span> <?php endif; ?>
        </a>
        <?php if($row->has_child): ?>
            <?php echo Menu::generateMenu([
                    'slug' => $menu->slug,
                    'view' => 'main-menu',
                    'options' => ['class' => 'dropdown-menu'],
                    'parent_id' => $row->id,
                ]); ?>

        <?php endif; ?>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/partials/main-menu.blade.php ENDPATH**/ ?>