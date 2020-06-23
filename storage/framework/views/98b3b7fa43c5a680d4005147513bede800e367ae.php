<?php if(!is_in_admin() || (Auth::check() && Auth::user()->hasPermission($route . '.create'))): ?>
    <a href="<?php echo e(route($route . '.create')); ?>?ref_from=<?php echo e($item->id); ?>&ref_lang=<?php echo e($language->lang_code); ?>" class="tip" title="<?php echo e(trans('plugins/language::language.add_language_for_item')); ?>"><i class="fa fa-plus"></i></a>
<?php else: ?>
    <i class="fa fa-plus text-primary"></i>
<?php endif; ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/plugins/language/resources/views//partials/status/plus.blade.php ENDPATH**/ ?>