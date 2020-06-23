<?php $__currentLoopData = $menus = dashboard_menu()->getAll(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="nav-item <?php if($menu['active']): ?> active <?php endif; ?>" id="<?php echo e($menu['id']); ?>">
        <a href="<?php echo e($menu['url']); ?>" class="nav-link nav-toggle">
            <i class="<?php echo e($menu['icon']); ?>"></i>
            <span class="title"><?php echo e(trans($menu['name'])); ?> <?php echo apply_filters(BASE_FILTER_APPEND_MENU_NAME, null, $menu['id']); ?></span>
            <?php if(isset($menu['children']) && count($menu['children'])): ?> <span class="arrow <?php if($menu['active']): ?> open <?php endif; ?>"></span> <?php endif; ?>
        </a>
        <?php if(isset($menu['children']) && count($menu['children'])): ?>
            <ul class="sub-menu <?php if(!$menu['active']): ?> hidden-ul <?php endif; ?>">
                <?php $__currentLoopData = $menu['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item <?php if($item['active']): ?> active <?php endif; ?>" id="<?php echo e($item['id']); ?>">
                        <a href="<?php echo e($item['url']); ?>" class="nav-link">
                            <i class="<?php echo e($item['icon']); ?>"></i>
                            <?php echo e(trans($item['name'])); ?>

                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/core/base/resources/views//layouts/partials/sidebar.blade.php ENDPATH**/ ?>