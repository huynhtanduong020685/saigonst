<?php if($showLabel && $showField): ?>
    <?php if($options['wrapper'] !== false): ?>
        <div <?php echo $options['wrapperAttrs']; ?>>
    <?php endif; ?>
<?php endif; ?>

<?php if($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?php echo Form::customLabel($name, $options['label'], $options['label_attr']); ?>

<?php endif; ?>

<?php if($showField): ?>
    <?php echo Form::text($name, $options['value'], $options['attr']); ?>

    <?php echo $__env->make('core/base::forms.partials.help_block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php echo $__env->make('core/base::forms.partials.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if($showLabel && $showField): ?>
    <?php if($options['wrapper'] !== false): ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div id="map"></div>
<div id="infowindow-content">
    <img src="" width="16" height="16" id="place-icon">
    <span id="place-name" class="title"></span><br>
    <span id="place-address"></span>
</div>
<br>
<br>

<?php echo $__env->make('plugins/real-estate::partials.components.google-map', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/plugins/real-estate/resources/views//forms/fields/location.blade.php ENDPATH**/ ?>