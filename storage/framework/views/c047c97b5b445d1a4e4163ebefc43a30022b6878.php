<div class="bgheadproject hidden-xs">
    <div class="description">
        <div class="container-fluid w90">
            <!-- <h1 class="text-center"><?php echo e($page->name); ?></h1> -->
        </div>
    </div>
</div>
<div class="container padtop50">
        <?php echo Theme::partial('breadcrumb'); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="scontent">
                <?php echo apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $page->content, $page); ?>

            </div>
        </div>
    </div>
</div>
<br>
<br>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/views/page.blade.php ENDPATH**/ ?>