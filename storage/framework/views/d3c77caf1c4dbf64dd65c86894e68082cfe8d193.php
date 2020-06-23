<div class="bgheadproject hidden-xs">
    <div class="description">
        <div class="container-fluid w90 text-center">
            
        </div>
    </div>
</div>
<div class="container padtop50">
             <?php echo Theme::partial('breadcrumb'); ?>

             <h1><?php echo e($category->name); ?></h1>
            <p><?php echo e($category->description); ?></p>
            
    <div class="row">
        <div class="col-sm-9">
            <!--<h1 class="titlenews"><?php echo e($category->name); ?></h1>-->
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="form-group row itemnews">
                    <div class="col-sm-4">
                        <a href="<?php echo e($post->url); ?>" title="<?php echo e($post->name); ?>"><img class="img-thumbnail" data-src="<?php echo e(get_object_image($post->image, 'small')); ?>" src="<?php echo e(get_object_image($post->image, 'small')); ?>" alt="<?php echo e($post->name); ?>"></a>
                    </div>
                    <div class="col-sm-8">
                        <h3><a class="title" href="<?php echo e($post->url); ?>" title="<?php echo e($post->name); ?>"><?php echo e($post->name); ?></a></h3>
                        <?php echo Theme::partial('post-meta', compact('post')); ?>

                        <p><?php echo e(Str::words($post->description, 50)); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <br>
            <div class="pagination">
                <?php echo $posts->links(); ?>

            </div>
        </div>
        <div class="col-sm-3">
            <?php echo dynamic_sidebar('primary_sidebar'); ?>

        </div>
    </div>
</div>
<br>
<br>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/views/category.blade.php ENDPATH**/ ?>