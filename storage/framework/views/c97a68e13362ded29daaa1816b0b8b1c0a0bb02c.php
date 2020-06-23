<div class="ui-select-wrapper">
    <?php
        Arr::set($selectAttributes, 'class', Arr::get($selectAttributes, 'class') . ' ui-select');
    ?>
    <?php echo Form::select($name, $list, $selected, $selectAttributes, $optionsAttributes, $optgroupsAttributes); ?>

    <svg class="svg-next-icon svg-next-icon-size-16">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
    </svg>
</div><?php /**PATH D:\WWW\saigonstar2020\platform/core/base/resources/views//elements/forms/custom-select.blade.php ENDPATH**/ ?>