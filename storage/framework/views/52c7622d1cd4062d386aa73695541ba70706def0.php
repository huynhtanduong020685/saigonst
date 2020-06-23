<?php if(request()->input('media-action') === 'select-files'): ?>
    <html>
        <head>
            <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
            <?php echo Assets::renderHeader(); ?>

            <?php echo RvMedia::renderHeader(); ?>

        </head>
        <body>
            <?php echo RvMedia::renderContent(); ?>

            <?php echo Assets::renderFooter(); ?>

            <?php echo RvMedia::renderFooter(); ?>

        </body>
    </html>
<?php else: ?>
    <?php echo RvMedia::renderHeader(); ?>


    <?php echo RvMedia::renderContent(); ?>


    <?php echo RvMedia::renderFooter(); ?>

<?php endif; ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/core/media/resources/views//popup.blade.php ENDPATH**/ ?>