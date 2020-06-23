<?php $__env->startSection('body-class'); ?> login <?php $__env->stopSection(); ?>
<?php $__env->startSection('body-style'); ?> background-image: url(<?php echo e(url('vendor/core/images/backgrounds/background-' . rand(1, 7) . '.jpg')); ?>); <?php $__env->stopSection(); ?>

<?php $__env->startPush('header'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="faded-bg animated"></div>
            <div class="hidden-xs col-sm-7 col-md-8">
                <div class="clearfix">
                    <div class="col-sm-12 col-md-10 col-md-offset-2">
                        <div class="logo-title-container">
                            <div class="copy animated fadeIn">
                                <h1><?php echo e(setting('admin_title')); ?></h1>
                                <p><?php echo trans('core/base::layouts.copyright', ['year' => now(config('app.timezone'))->format('Y'), 'company' => setting('admin_title', config('core.base.general.base_name')), 'version' => get_cms_version()]); ?></p>
                                <div class="copyright">
                                    <?php if(setting('enable_change_admin_theme') != false && count(Assets::getAdminLocales()) > 1): ?>
                                        <p> <?php echo e(__('Languages')); ?>:
                                            <?php $__currentLoopData = Assets::getAdminLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span <?php if(app()->getLocale() == $key): ?> class="active" <?php endif; ?>>
                                                    <a href="<?php echo e(route('admin.language', $key)); ?>">
                                                        <?php echo language_flag($value['flag'], $value['name']); ?> <span><?php echo e($value['name']); ?></span>
                                                    </a>
                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div> <!-- .logo-title-container -->
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

                <div class="login-container">

                    <?php echo $__env->yieldContent('content'); ?>

                    <div style="clear:both"></div>

                </div> <!-- .login-container -->

            </div> <!-- .login-sidebar -->
        </div> <!-- .row -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('core/base::layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WWW\saigonstar2020\platform/core/acl/resources/views//auth/master.blade.php ENDPATH**/ ?>