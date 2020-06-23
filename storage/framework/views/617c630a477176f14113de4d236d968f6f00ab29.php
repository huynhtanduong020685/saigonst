<div class="panel panel-primary">
        <div class="panel-heading"><h2>Please upload your CV.</h2></div>
        <div class="panel-body">
    
            <?php if($message = Session::get('success')): ?>
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong><?php echo e($message); ?></strong>
            </div>
            <img src="uploads/<?php echo e(Session::get('file')); ?>">
            <?php endif; ?>
    
            <?php if(count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
    
            <form action="<?php echo e(url('public.upload')); ?>" method="POST" enctype="multipart/form-data">                  <?php echo csrf_field(); ?>
                <?php echo e(csrf_field()); ?>

                 <div class="row">
                    <div class="col-md-6">
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
    
                </div>
            </form>
    
        </div>
</div><?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/partials/uploadfiles.blade.php ENDPATH**/ ?>