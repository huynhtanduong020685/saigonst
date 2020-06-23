<h5 class="padtop40 titlenewnews"><?php echo e($config['name']); ?></h5>

<?php $__currentLoopData = get_recent_posts($config['number_display']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="mb-4 w-100 float-left lastestnews">
        <a href="<?php echo e($post->url); ?>" class="text-dark">
            <img class="img-thumbnail float-left mr-2" data-src="<?php echo e(get_object_image($post->image, 'thumb')); ?>" src="<?php echo e(get_object_image($post->image, 'thumb')); ?>" width="90" alt="<?php echo e($post->name); ?>">
            <?php echo e($post->name); ?>

        </a>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/////widgets/recent-posts/templates/frontend.blade.php ENDPATH**/ ?>