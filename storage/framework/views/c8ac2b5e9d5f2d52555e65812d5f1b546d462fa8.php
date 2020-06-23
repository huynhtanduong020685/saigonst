<div id="select-post-language">
    <table class="select-language-table">
        <tbody>
            <tr>
                <td class="active-language">
                    <?php echo language_flag($currentLanguage->lang_flag, $currentLanguage->lang_name); ?>

                </td>
                <td class="translation-column">
                    <div class="ui-select-wrapper">
                        <select name="language" id="post_lang_choice" class="ui-select">
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!array_key_exists(json_encode([$language->lang_code]), $related)): ?>
                                    <option value="<?php echo e($language->lang_code); ?>" <?php if($language->lang_code == $currentLanguage->lang_code): ?> selected="selected" <?php endif; ?> data-flag="<?php echo e($language->lang_flag); ?>"><?php echo e($language->lang_name); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <svg class="svg-next-icon svg-next-icon-size-16">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                        </svg>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php if(count($languages) > 1): ?>
    <div><strong><?php echo e(trans('plugins/language::language.translations')); ?></strong>
        <div id="list-others-language">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($language->lang_code != $currentLanguage->lang_code): ?>
                    <?php echo language_flag($language->lang_flag, $language->lang_name); ?>

                    <?php if(array_key_exists($language->lang_code, $related)): ?>
                        <a href="<?php echo e(Route::has($route['edit']) ? route($route['edit'], $related[$language->lang_code]) : '#'); ?>"> <?php echo e($language->lang_name); ?> <i class="fa fa-edit"></i></a>
                        <br>
                    <?php else: ?>
                        <?php
                            $queryString ='ref_from=' . (!empty($args[0]) ? $args[0]->id : 0) . '&ref_lang=' . $language->lang_code;
                            $currentQueryString = remove_query_string_var(Request::getQueryString(), ['ref_from', 'ref_lang']);
                            if (!empty($currentQueryString)) {
                                $queryString = $currentQueryString . '&' . $queryString;
                            }
                        ?>
                        <a href="<?php echo e(Route::has($route['create']) ? route($route['create']) : '#'); ?>?<?php echo e($queryString); ?>"> <?php echo e($language->lang_name); ?> <i class="fa fa-plus"></i></a>
                        <br>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <input type="hidden" id="lang_meta_created_from" name="ref_from" value="<?php echo e(Request::get('ref_from')); ?>">
    <input type="hidden" id="reference_id" value="<?php echo e($args[0] ? $args[0]->id : ''); ?>">
    <input type="hidden" id="reference_type" value="<?php echo e($args[1]); ?>">
    <input type="hidden" id="route_create" value="<?php echo e(Route::has($route['create']) ? route($route['create']) : '#'); ?>">
    <input type="hidden" id="route_edit" value="<?php echo e(Route::has($route['edit']) ? route($route['edit'], $args[0] && $args[0]->id ? $args[0]->id : '') : '#'); ?>">
    <input type="hidden" id="language_flag_path" value="<?php echo e(BASE_LANGUAGE_FLAG_PATH); ?>">

    <div data-change-language-route="<?php echo e(route('languages.change.item.language')); ?>"></div>

    <?php echo Form::modalAction('confirm-change-language-modal', trans('plugins/language::language.confirm-change-language'), 'warning', trans('plugins/language::language.confirm-change-language-message'), 'confirm-change-language-button', trans('plugins/language::language.confirm-change-language-btn')); ?>

<?php endif; ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/plugins/language/resources/views//language-box.blade.php ENDPATH**/ ?>