<script>
    RV_MEDIA_URL = <?php echo json_encode(RvMedia::getUrls()); ?>;
    RV_MEDIA_CONFIG = <?php echo json_encode([
        'permissions' => RvMedia::getPermissions(),
        'translations' => trans('core/media::media.javascript'),
        'pagination' => [
            'paged' => config('core.media.media.pagination.paged'),
            'posts_per_page' => config('core.media.media.pagination.per_page'),
            'in_process_get_media' => false,
            'has_more' =>  true,
        ],
    ]); ?>

</script>
<?php /**PATH D:\WWW\saigonstar2020\platform/core/media/resources/views//config.blade.php ENDPATH**/ ?>