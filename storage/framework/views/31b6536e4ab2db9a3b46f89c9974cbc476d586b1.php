<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo e(page_title()->getTitle()); ?></title>

    <meta name="robots" content="noindex,follow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="icon shortcut" href="<?php echo e(setting('admin_favicon') ? get_image_url(setting('admin_favicon'), 'thumb') : url(config('core.base.general.favicon'))); ?>">
    <link rel='stylesheet'
          href='//fonts.googleapis.com/css?family=Roboto:100%2C100italic%2C300%2C300italic%2C400%2Citalic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic|Roboto+Slab:100%2C300%2C400%2C700&#038;subset=greek-ext%2Cgreek%2Ccyrillic-ext%2Clatin-ext%2Clatin%2Cvietnamese%2Ccyrillic'
          type='text/css' media='all'/>

    <?php echo Assets::renderHeader(['core']); ?>


    <?php echo $__env->yieldContent('head'); ?>

    <?php echo $__env->yieldPushContent('header'); ?>
</head>
<body class="<?php echo $__env->yieldContent('body-class', 'page-sidebar-closed-hide-logo page-content-white page-container-bg-solid'); ?>" style="<?php echo $__env->yieldContent('body-style'); ?>">

    <?php echo $__env->yieldContent('page'); ?>

    <?php echo $__env->make('core/base::elements.common', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Assets::renderFooter(); ?>


    <?php echo $__env->yieldContent('javascript'); ?>

    <?php echo $__env->yieldPushContent('footer'); ?>
</body>
</html>
<?php /**PATH D:\WWW\saigonstar2020\platform/core/base/resources/views//layouts/base.blade.php ENDPATH**/ ?>