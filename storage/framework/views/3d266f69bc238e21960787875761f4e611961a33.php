<?php if(!empty($pages)): ?>
    <div class="widget meta-boxes">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapsePages">
            <h4 class="widget-title" style="margin-top: 0">
                <span><?php echo e(trans('packages/page::pages.menu')); ?></span>
                <i class="fa fa-angle-up narrow-icon"></i>
            </h4>
        </a>
        <div id="collapsePages" class="panel-collapse collapse in">
            <div class="widget-body">
                <div class="box-links-for-menu">
                    <div class="the-box">
                        <?php echo $pages; ?>

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
<?php endif; ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/packages/page/resources/views//partials/menu-options.blade.php ENDPATH**/ ?>