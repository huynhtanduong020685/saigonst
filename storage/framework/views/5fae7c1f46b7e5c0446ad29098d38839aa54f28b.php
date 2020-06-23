<div id="myHeader">
    <div class="bravo_topbar">
        <div class="container-fluid w90">
            <div class="row">
                <div class="col-12">
                    <div class="content">
                        <div class="topbar-left d-none d-sm-block">
                            <div class="top-socials">
                                <a href="<?php echo e(theme_option('facebook')); ?>" title="Facebook" class="fab fa-facebook-f"></a>
                                <a href="<?php echo e(theme_option('twitter')); ?>" title="Twitter" class="fab fa-twitter"></a>
                                <a href="<?php echo e(theme_option('youtube')); ?>" title="Youtube" class="fab fa-youtube"></a>
                            </div>
                            <span class="line"></span>
                            <a href="mailto:<?php echo e(theme_option('email')); ?>"><?php echo e(theme_option('email')); ?></a>
                        </div>
                        <div class="topbar-right">
                            <div class="contact-address"><?php echo e(__('Address')); ?>: <?php echo e(theme_option('address')); ?></div>
                            <div class="contact-phone"><?php echo e(__('Hotline')); ?>: <?php echo e(theme_option('hotline')); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header class="topmenu bg-light">
        <div class="container-fluid w90">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <?php if(theme_option('logo')): ?>
                            <a class="navbar-brand" href="<?php echo e(route('public.single')); ?>">
                                <img src="<?php echo e(get_image_url(theme_option('logo'))); ?>"
                                    class="logo" height="40" alt="<?php echo e(theme_option('site_name')); ?>">
                            </a>
                        <?php endif; ?>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <?php echo Menu::renderMenuLocation('main-menu', [
                                    'options' => ['class' => 'navbar-nav  justify-content-end'],
                                    'view'    => 'main-menu',
                                ]); ?>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</div>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/partials/header.blade.php ENDPATH**/ ?>