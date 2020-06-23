<div class="page-header navbar navbar-static-top">
    <div class="page-header-inner col-12">

            <div class="page-logo">
                <a href="<?php echo e(route('dashboard.index')); ?>">
                    <img src="<?php echo e(setting('admin_logo') ? get_image_url(setting('admin_logo')) : url(config('core.base.general.logo'))); ?>" alt="logo" class="logo-default" />
                </a>
                <?php if(auth()->guard()->check()): ?>
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if(auth()->guard()->check()): ?>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
            <?php endif; ?>

            <div class="top-menu">
                <ul class="nav navbar-nav float-right">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(config('core.base.general.admin_dir') != ''): ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle dropdown-header-name" style="padding-right: 10px" href="<?php echo e(url('/')); ?>" target="_blank"><i class="fa fa-globe"></i> <span class="d-none d-sm-inline"><?php echo e(trans('core/base::layouts.view_website')); ?></span> </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Auth::check()): ?>
                            <?php echo apply_filters(BASE_FILTER_TOP_HEADER_LAYOUT, null); ?>

                        <?php endif; ?>

                        <?php if(isset($themes) && setting('enable_change_admin_theme') != false): ?>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle dropdown-header-name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span><?php echo e(trans('core/base::layouts.theme')); ?></span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right icons-right">

                                    <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($activeTheme === $name): ?>
                                            <li class="active"><a href="<?php echo e(route('admin.theme', [$name])); ?>"><?php echo e(Str::studly($name)); ?></a></li>
                                        <?php else: ?>
                                            <li><a href="<?php echo e(route('admin.theme', [$name])); ?>"><?php echo e(Str::studly($name)); ?></a></li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if(setting('enable_multi_language_in_admin') != false): ?>
                            <li class="language dropdown">
                                <a href="javascript:;" class="dropdown-toggle dropdown-header-name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php if(array_key_exists(app()->getLocale(), $locales)): ?>
                                        <?php echo language_flag($locales[app()->getLocale()]['flag'], $locales[app()->getLocale()]['name']); ?>

                                        <span class="d-none d-sm-inline"><?php echo e($locales[app()->getLocale()]['name']); ?></span>
                                    <?php endif; ?>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right icons-right">
                                    <?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(app()->getLocale() == $key): ?>
                                            <li class="active">
                                                <a href="<?php echo e(route('admin.language', $key)); ?>">
                                                    <?php echo language_flag($value['flag'], $value['name']); ?> <span><?php echo e($value['name']); ?></span>
                                                </a>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <a href="<?php echo e(route('admin.language', $key)); ?>">
                                                    <?php echo language_flag($value['flag'], $value['name']); ?> <span><?php echo e($value['name']); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <li class="dropdown dropdown-user">
                            <a href="javascript:void(0)" class="dropdown-toggle dropdown-header-name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img alt="<?php echo e(Auth::user()->getFullName()); ?>" class="rounded-circle" src="<?php echo e(Auth::user()->avatar_url); ?>" />
                                <span class="username username-hide-on-mobile"> <?php echo e(Auth::user()->getFullName()); ?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo e(route('user.profile.view', Auth::user()->getKey())); ?>"><i class="icon-user"></i> <?php echo e(trans('core/base::layouts.profile')); ?></a></li>
                                <li><a href="<?php echo e(route('access.logout')); ?>" class="btn-logout"><i class="icon-key"></i> <?php echo e(trans('core/base::layouts.logout')); ?></a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
</div>
<?php /**PATH D:\WWW\saigonstar2020\platform/core/base/resources/views//layouts/partials/top-header.blade.php ENDPATH**/ ?>