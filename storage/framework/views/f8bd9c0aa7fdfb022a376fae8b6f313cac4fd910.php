<?php if(!empty($tags)): ?>
    <div class="widget meta-boxes">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTags">
            <h4 class="widget-title">
                <span><?php echo e(trans('plugins/blog::tags.menu')); ?></span>
                <i class="fa fa-angle-down narrow-icon"></i>
            </h4>
        </a>
        <div id="collapseTags" class="panel-collapse collapse">
            <div class="widget-body">
                <div class="box-links-for-menu">
                    <div class="the-box">
                        <?php echo $tags; ?>

                        <div class="text-right">
                            <div class="btn-group btn-group-devided">
                                <a href="#" class="btn-add-to-menu btn btn-primary">
                                    <span class="text"><i class="fa fa-plus"></i> <?php echo e(trans('packages/menu::menu.add_to_menu')); ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?><?php /**PATH D:\WWW\saigonstar2020\platform/plugins/blog/resources/views//tags/partials/menu-options.blade.php ENDPATH**/ ?>