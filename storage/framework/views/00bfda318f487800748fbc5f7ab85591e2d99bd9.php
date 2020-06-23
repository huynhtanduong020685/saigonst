<div class="bgheadproject hidden-xs">
    <div class="description">
        <div class="container-fluid w90">
        </div>
    </div>
</div>
<div class="container padtop50">
            <h1 class="text-center"><?php echo e(__('Careers')); ?></h1>
            <?php echo Theme::partial('breadcrumb'); ?>

    <div class="row">
        <div class="col-sm-9">
            <h2 class="titlenews"><?php echo e($career->name); ?></h2>
            <div class="job-list">
                <div class="job-item">
                    <div class="job-header"><p><strong><?php echo e(__('Location')); ?>:</strong>&nbsp;<?php echo e($career->location); ?></p>
                        <p><strong><?php echo e(__('Salary')); ?>:</strong>&nbsp;<?php echo e($career->salary); ?></p>
                        <p><strong><?php echo e(__('Posted at')); ?>:</strong>&nbsp;<?php echo e($career->created_at->format('Y-m-d')); ?></p></div>
                    <div class="job-content">
                        <?php echo $career->description; ?>

                    </div>
                </div>
            </div>
            <?php echo Theme::partial('uploadfiles'); ?>

        </div>
        <div class="col-sm-3">
        <!-- <?php echo Theme::partial('sidebar'); ?> -->
        </div>
       
    </div>
</div>
<br>
<br>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/views/career.blade.php ENDPATH**/ ?>