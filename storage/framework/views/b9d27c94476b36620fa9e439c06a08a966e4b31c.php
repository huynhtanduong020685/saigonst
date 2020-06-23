<?php if(is_plugin_active('language')): ?>
    <?php
        $supportedLocales = Language::getSupportedLocales();
    ?>
    <?php if($supportedLocales): ?>
        <?php
            $languageDisplay = setting('language_display', 'all');
            $showRelated = setting('language_show_default_item_if_current_version_not_existed', true);
        ?>

        <div class="padtop10 mb-2 language">
            <?php if(setting('language_switcher_display', 'dropdown') == 'dropdown'): ?>
                <div class="language-switcher-wrapper">
                    <div class="float-left language-label">
                        <?php echo e(__('Languages')); ?>:
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-select-language" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php if(($languageDisplay == 'all' || $languageDisplay == 'flag')): ?>
                                <?php echo language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName()); ?>

                            <?php endif; ?>
                            <?php if(($languageDisplay == 'all' || $languageDisplay == 'name')): ?>
                                <?php echo e(Language::getCurrentLocaleName()); ?>

                            <?php endif; ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu language_bar_chooser">
                            <?php $__currentLoopData = $supportedLocales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li <?php if($localeCode == Language::getCurrentLocale()): ?> class="active" <?php endif; ?>>
                                    <a rel="alternate" hreflang="<?php echo e($localeCode); ?>" href="<?php echo e($showRelated ? Language::getLocalizedURL($localeCode) : url($localeCode)); ?>">
                                        <?php if(($languageDisplay == 'all' || $languageDisplay == 'flag')): ?><?php echo language_flag($properties['lang_flag'], $properties['lang_name']); ?><?php endif; ?>
                                        <?php if(($languageDisplay == 'all' || $languageDisplay == 'name')): ?><span><?php echo e($properties['lang_name']); ?></span><?php endif; ?>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <strong class="language-label"><?php echo e(__('Languages')); ?></strong>:
                <?php $__currentLoopData = $supportedLocales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a rel="alternate" hreflang="<?php echo e($localeCode); ?>" href="<?php echo e(setting('language_show_default_item_if_current_version_not_existed', true) ? Language::getLocalizedURL($localeCode) : url($localeCode)); ?>">
                        <?php if(($languageDisplay == 'all' || $languageDisplay == 'flag')): ?><?php echo language_flag($properties['lang_flag'], $properties['lang_name']); ?><?php endif; ?>
                        <?php if(($languageDisplay == 'all' || $languageDisplay == 'name')): ?><span><?php echo e($properties['lang_name']); ?></span><?php endif; ?>
                    </a> &nbsp;
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/partials/language-switcher.blade.php ENDPATH**/ ?>