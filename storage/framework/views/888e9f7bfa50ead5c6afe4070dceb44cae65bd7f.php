<div class="boxright">
    <h5><?php echo e($config['name']); ?></h5>
    <ul class="listnews">
        <?php $__currentLoopData = get_categories(['select' => ['categories.id', 'categories.name']]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="<?php echo e($category->url); ?>" class="text-dark"><?php echo e($category->name); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/////widgets/categories/templates/frontend.blade.php ENDPATH**/ ?>