<!--FOOTER-->
<footer>
    <br>
    <div class="container-fluid w90">
        <div class="row">
            <div class="col-sm-3">
                <?php if(theme_option('logo')): ?>
                <p>
                    <a href="<?php echo e(route('public.single')); ?>">
                        <img src="<?php echo e(get_image_url(theme_option('logo'))); ?>" style="max-height: 38px" alt="<?php echo e(theme_option('site_name')); ?>">
                    </a>
                </p>
                <?php endif; ?>
                <p><i class="fas fa-map-marker-alt"></i> &nbsp;<?php echo e(theme_option('address')); ?></p>
                <p><i class="fas fa-phone-square"></i> &nbsp;<a href="tel:<?php echo e(theme_option('hotline')); ?>"><?php echo e(theme_option('hotline')); ?></a></p>
                <p><i class="fas fa-tty"></i> &nbsp;<a href="tel:<?php echo e(theme_option('hotline')); ?>">(+84)28 3742 3222</a></p>
                <p><i class="fas fa-envelope"></i>  &nbsp;<a href="mailto:<?php echo e(theme_option('email')); ?>"><?php echo e(theme_option('email')); ?></a>
                </p>
            </div>
            <div class="col-sm-9 padtop10">
                <div class="row">
                    <?php echo dynamic_sidebar('footer_sidebar'); ?>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php echo Theme::partial('language-switcher'); ?>

            </div>
        </div>
        <div class="copyright">
            <div class="col-sm-12">
                <p class="text-center">
                    <?php echo clean(theme_option('copyright')); ?>

                </p>
            </div>
        </div>
    </div>
</footer>
<!--FOOTER-->

<script type="text/javascript">
    window.trans = {
        "Price": "<?php echo e(__('Price')); ?>",
        "Number of rooms": "<?php echo e(__('Number of rooms')); ?>",
        "Number of rest rooms": "<?php echo e(__('Number of rest rooms')); ?>",
        "Square": "<?php echo e(__('Square')); ?>",
        "No property found": "<?php echo e(__('No property found')); ?>",
        "million": "<?php echo e(__('million')); ?>",
        "billion": "<?php echo e(__('billion')); ?>"
    }
</script>
<a href="http://sgstar.edu.vn/projects/book-a-parent-tour" class="social_open" id="bt_open">Book a tour</a>
<!-- <div class="social_group">
      <div class="group_1">
      <a href="http://sgstar.edu.vn/projects/book-a-parent-tour" target="_blank" class="download">Book a tour</a>
      </div> 
</div> -->


<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/partials/footer.blade.php ENDPATH**/ ?>