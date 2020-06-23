<div class="bgheadproject hidden-xs">
    <div class="description">
        <div class="container-fluid w90">
        </div>
    </div>
</div>
<div class="container padtop50">
    <?php echo Theme::partial('breadcrumb'); ?>

    <div class="row">
        <div class="col-sm-9">
            <div class="job-list">
                <?php $__currentLoopData = $careers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $career): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="job-item">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="job-title">
                                    <a href="<?php echo e(route('public.career', $career->slug)); ?>"><?php echo e($career->name); ?></a></div>
                                <div class="job-body"><p><?php echo e($career->location); ?></p>
                                    <p><?php echo e(__('Salary')); ?>: <?php echo e($career->salary); ?></p>
                                    <p><?php echo e(__('Posted at')); ?>: <?php echo e($career->created_at->format('Y-m-d')); ?></p></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
           
        </div>
        <div class="col-sm-3">
            <?php echo Theme::partial('sidebar'); ?>

        </div>
    </div>
</div>
<br>
<br>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/views/careers.blade.php ENDPATH**/ ?>