<div class="wrapper-filter">
    <p><?php echo e(trans('core/table::general.filters')); ?></p>

    <input type="hidden" class="filter-data-url" value="<?php echo e(route('tables.get-filter-input')); ?>">

    <div class="sample-filter-item-wrap hidden">
        <div class="filter-item form-filter">
            <div class="ui-select-wrapper">
                <select name="filter_columns[]" class="ui-select filter-column-key">
                    <option value=""><?php echo e(trans('core/table::general.select_field')); ?></option>
                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column_key => $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($column_key); ?>"><?php echo e($column['title']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <svg class="svg-next-icon svg-next-icon-size-16">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                </svg>
            </div>
            <div class="ui-select-wrapper">
                <select name="filter_operators[]" class="ui-select filter-operator filter-column-operator">
                    <option value="like"><?php echo e(trans('core/table::general.contains')); ?></option>
                    <option value="="><?php echo e(trans('core/table::general.is_equal_to')); ?></option>
                    <option value=">"><?php echo e(trans('core/table::general.greater_than')); ?></option>
                    <option value="<"><?php echo e(trans('core/table::general.less_than')); ?></option>
                </select>
                <svg class="svg-next-icon svg-next-icon-size-16">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                </svg>
            </div>
            <span class="filter-column-value-wrap">
                <input class="form-control filter-column-value" type="text" placeholder="<?php echo e(trans('core/table::general.value')); ?>"
                       name="filter_values[]">
            </span>
            <span class="btn-remove-filter-item" title="<?php echo e(trans('core/table::general.delete')); ?>">
                <i class="fa fa-trash text-danger"></i>
            </span>
        </div>
    </div>

    <?php echo e(Form::open(['method' => 'GET', 'class' => 'filter-form'])); ?>

        <input type="hidden" name="filter_table_id" class="filter-data-table-id" value="<?php echo e($tableId); ?>">
        <input type="hidden" name="class" class="filter-data-class" value="<?php echo e($class); ?>">
        <div class="filter_list inline-block filter-items-wrap">
            <?php $__currentLoopData = $requestFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter_key => $filter_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="filter-item form-filter <?php if($loop->first): ?> filter-item-default <?php endif; ?>">
                    <div class="ui-select-wrapper">
                        <select name="filter_columns[]" class="ui-select filter-column-key">
                            <option value=""><?php echo e(trans('core/table::general.select_field')); ?></option>
                            <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column_key => $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($column_key); ?>" <?php if($filter_item['column'] == $column_key): ?> selected <?php endif; ?>><?php echo e($column['title']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <svg class="svg-next-icon svg-next-icon-size-16">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                        </svg>
                    </div>
                    <div class="ui-select-wrapper">
                        <select name="filter_operators[]" class="ui-select filter-column-operator">
                            <option value="like"
                                    <?php if($filter_item['operator'] == 'like'): ?> selected <?php endif; ?>><?php echo e(trans('core/table::general.contains')); ?></option>
                            <option value="="
                                    <?php if($filter_item['operator'] == '='): ?> selected <?php endif; ?>><?php echo e(trans('core/table::general.is_equal_to')); ?></option>
                            <option value=">"
                                    <?php if($filter_item['operator'] == '>'): ?> selected <?php endif; ?>><?php echo e(trans('core/table::general.greater_than')); ?></option>
                            <option value="<"
                                    <?php if($filter_item['operator'] == '<'): ?> selected <?php endif; ?>><?php echo e(trans('core/table::general.less_than')); ?></option>
                        </select>
                        <svg class="svg-next-icon svg-next-icon-size-16">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                        </svg>
                    </div>
                    <span class="filter-column-value-wrap">
                        <input class="form-control filter-column-value" type="text" placeholder="<?php echo e(trans('core/table::general.value')); ?>"
                               name="filter_values[]" value="<?php echo e($filter_item['value']); ?>">
                    </span>
                    <?php if($loop->first): ?>
                        <span class="btn-reset-filter-item" title="<?php echo e(trans('core/table::general.reset')); ?>">
                            <i class="fa fa-eraser text-info" style="font-size: 13px;"></i>
                        </span>
                    <?php else: ?>
                        <span class="btn-remove-filter-item" title="<?php echo e(trans('core/table::general.delete')); ?>">
                            <i class="fa fa-trash text-danger"></i>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div style="margin-top: 10px;">
            <a href="javascript:;" class="btn btn-secondary add-more-filter"><?php echo e(trans('core/table::general.add_additional_filter')); ?></a>
            <a href="<?php echo e(URL::current()); ?>" class="btn btn-info <?php if(!request()->has('filter_table_id')): ?> hidden <?php endif; ?>"><?php echo e(trans('core/table::general.reset')); ?></a>
            <button type="submit" class="btn btn-primary btn-apply"><?php echo e(trans('core/table::general.apply')); ?></button>
        </div>

    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH D:\WWW\saigonstar2020\platform/core/table/resources/views//filter.blade.php ENDPATH**/ ?>