<?php if($showLabel && $showField): ?>
    <?php if($options['wrapper'] !== false): ?>
        <div <?php echo $options['wrapperAttrs']; ?>>
    <?php endif; ?>
<?php endif; ?>

<?php if($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?php echo Form::customLabel($name, $options['label'], $options['label_attr']); ?>

<?php endif; ?>

<?php if($showField): ?>
    <?php echo $options['html']; ?>

<?php endif; ?>


<?php if($showLabel && $showField): ?>
    <?php if($options['wrapper'] !== false): ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH D:\WWW\saigonstar2020\platform/core/base/resources/views//forms/fields/html.blade.php ENDPATH**/ ?>