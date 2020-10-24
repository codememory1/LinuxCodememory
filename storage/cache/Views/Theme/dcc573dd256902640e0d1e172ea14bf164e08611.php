<?php if(Flash::has('error') === true): ?>
    <?php $__currentLoopData = Flash::get('error'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err => $mess): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="handle-message handle-message-<?php echo e($err); ?>">
            <span><?php echo e($mess); ?></span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php /**PATH W:\domains\myDb.loc\resources\Theme/FastDB/Common/FlashMessage.blade.php ENDPATH**/ ?>