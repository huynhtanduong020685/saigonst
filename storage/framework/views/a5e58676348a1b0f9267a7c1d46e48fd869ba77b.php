<p class="post-meta">
    <small><?php echo e(__('Posted At')); ?>: <?php echo e($post->created_at->format('Y/m/d')); ?> <?php echo e(__('in')); ?> <?php $__currentLoopData = $post->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($category->url); ?>"><?php echo e($category->name); ?></a>
            <?php if(!$loop->last): ?>
                ,
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </small>
</p>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/partials/post-meta.blade.php ENDPATH**/ ?>