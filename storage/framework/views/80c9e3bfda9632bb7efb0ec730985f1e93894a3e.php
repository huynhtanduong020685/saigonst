<li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
    <a href="javascript:;" class="dropdown-toggle dropdown-header-name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon-envelope-open"></i>
        <span class="badge badge-default"> <?php echo e(count($contacts)); ?> </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right">
        <li class="external">
            <h3><?php echo trans('plugins/contact::contact.new_msg_notice', ['count' => count($contacts)]); ?></h3>
            <a href="<?php echo e(route('contacts.index')); ?>"><?php echo e(trans('plugins/contact::contact.view_all')); ?></a>
        </li>
        <li>
            <ul class="dropdown-menu-list scroller" style="height: <?php echo e(count($contacts) * 70); ?>px;" data-handle-color="#637283">
                <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(route('contacts.edit', $contact->id)); ?>">
                            <span class="photo">
                                <img src="<?php echo e(\Botble\Base\Supports\Gravatar::image($contact->email)); ?>" class="rounded-circle" alt="<?php echo e($contact->name); ?>">
                            </span>
                            <span class="subject"><span class="from"> <?php echo e($contact->name); ?> </span><span class="time"><?php echo e(Carbon\Carbon::parse($contact->created_at)->toDateTimeString()); ?> </span></span>
                            <span class="message"> <?php echo e($contact->phone); ?> - <?php echo e($contact->email); ?> </span>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </li>
    </ul>
</li><?php /**PATH D:\WWW\saigonstar2020\platform/plugins/contact/resources/views//partials/notification.blade.php ENDPATH**/ ?>