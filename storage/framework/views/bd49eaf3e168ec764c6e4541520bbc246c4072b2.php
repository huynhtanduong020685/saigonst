<?php if(!empty($menu) && $menu->id): ?>
    <input type="hidden" name="deleted_nodes">
    <textarea name="menu_nodes" id="nestable-output" class="form-control hidden"></textarea>
    <div class="row widget-menu">
        <div class="col-md-4">
            <div class="panel-group" id="accordion">

                <?php do_action(MENU_ACTION_SIDEBAR_OPTIONS) ?>

                <div class="widget meta-boxes">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCustomLink">
                        <h4 class="widget-title">
                            <span><?php echo e(trans('packages/menu::menu.add_link')); ?></span>
                            <i class="fa fa-angle-down narrow-icon"></i>
                        </h4>
                    </a>
                    <div id="collapseCustomLink" class="panel-collapse collapse">
                        <div class="widget-body">
                            <div class="box-links-for-menu">
                                <div id="external_link" class="the-box">
                                    <div class="node-content">
                                        <div class="form-group">
                                            <label for="node-title"><?php echo e(trans('packages/menu::menu.title')); ?></label>
                                            <input type="text" class="form-control" id="node-title" autocomplete="false">
                                        </div>
                                        <div class="form-group">
                                            <label for="node-url"><?php echo e(trans('packages/menu::menu.url')); ?></label>
                                            <input type="text" class="form-control" id="node-url" placeholder="http://" autocomplete="false">
                                        </div>
                                        <div class="form-group">
                                            <label for="node-icon"><?php echo e(trans('packages/menu::menu.icon')); ?></label>
                                            <input type="text" class="form-control" id="node-icon" placeholder="fa fa-home" autocomplete="false">
                                        </div>
                                        <div class="form-group">
                                            <label for="node-css"><?php echo e(trans('packages/menu::menu.css_class')); ?></label>
                                            <input type="text" class="form-control" id="node-css" autocomplete="false">
                                        </div>
                                        <div class="form-group">
                                            <label for="target"><?php echo e(trans('packages/menu::menu.target')); ?></label>
                                            <div class="ui-select-wrapper">
                                                <select name="target" class="ui-select" id="target">
                                                    <option value="_self"><?php echo e(trans('packages/menu::menu.self_open_link')); ?></option>
                                                    <option value="_blank"><?php echo e(trans('packages/menu::menu.blank_open_link')); ?></option>
                                                </select>
                                                <svg class="svg-next-icon svg-next-icon-size-16">
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="text-right form-group node-actions hidden">
                                            <a class="btn red btn-remove" href="#"><?php echo e(trans('packages/menu::menu.remove')); ?></a>
                                            <a class="btn blue btn-cancel" href="#"><?php echo e(trans('packages/menu::menu.cancel')); ?></a>
                                        </div>

                                        <div class="form-group">
                                            <div class="text-right add-button">
                                                <div class="btn-group">
                                                    <a href="#" class="btn-add-to-menu btn btn-primary"><span class="text"><i class="fa fa-plus"></i> <?php echo e(trans('packages/menu::menu.add_to_menu')); ?></span></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="widget meta-boxes">
                <div class="widget-title">
                    <h4>
                        <span><?php echo e(trans('packages/menu::menu.structure')); ?></span>
                    </h4>
                </div>
                <div class="widget-body">
                    <div class="dd nestable-menu" id="nestable" data-depth="0">
                        <?php echo Menu::generateMenu([
                                'slug' => $menu->slug,
                                'view' => 'packages/menu::partials.menu',
                                'theme' => false,
                                'active' => false,
                             ]); ?>

                    </div>
                    <?php if(defined('THEME_MODULE_SCREEN_NAME')): ?>
                        <hr>
                        <h3><?php echo e(__('Menu settings')); ?></h3>
                        <div class="row">
                            <div class="col-md-4">
                                <p><i><?php echo e(__('Display location')); ?></i></p>
                            </div>
                            <div class="col-md-8">
                                <?php $__currentLoopData = Menu::getMenuLocations(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location => $description): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <input type="checkbox" <?php if(in_array($location, $locations)): ?> checked <?php endif; ?> class="hrv-checkbox" name="locations[]" value="<?php echo e($location); ?>" id="menu_location_<?php echo e($location); ?>">
                                        <label for="menu_location_<?php echo e($location); ?>"><?php echo e($description); ?></label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/packages/menu/resources/views//menu-structure.blade.php ENDPATH**/ ?>