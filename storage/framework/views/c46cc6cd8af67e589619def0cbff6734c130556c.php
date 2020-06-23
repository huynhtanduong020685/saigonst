<li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
    <a href="javascript:;" class="dropdown-toggle dropdown-header-name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon-envelope-open"></i>
        <span class="badge badge-default"> <?php echo e(count($consults)); ?> </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right">
        <li class="external">
            <h3><?php echo trans('plugins/real-estate::consult.new_consult_notice', ['count' => count($consults)]); ?></h3>
            <a href="<?php echo e(route('consult.index')); ?>"><?php echo e(trans('plugins/real-estate::consult.view_all')); ?></a>
        </li>
        <li>
            <ul class="dropdown-menu-list scroller" style="height: <?php echo e(count($consults) * 70); ?>px;" data-handle-color="#637283">
                <?php $__currentLoopData = $consults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consult): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(route('consult.edit', $consult->id)); ?>">
                            <span class="photo">
                                <img src="<?php echo e(\Botble\Base\Supports\Gravatar::image($consult->email)); ?>" class="rounded-circle" alt="<?php echo e($consult->name); ?>">
                            </span>
                            <span class="subject"><span class="from"> <?php echo e($consult->name); ?> </span><span class="time"><?php echo e(Carbon\Carbon::parse($consult->created_at)->toDateTimeString()); ?> </span></span>
                            <span class="message"> <?php echo e($consult->phone); ?> - <?php echo e($consult->email); ?> </span>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </li>
    </ul>
</li>
<?php /**PATH D:\WWW\saigonstar2020\platform/plugins/real-estate/resources/views//notification.blade.php ENDPATH**/ ?>