<div>Баланс: <?php echo e($data->balance); ?></div>
<form action="/auth/handle?cdm_token=red" method="post" enctype="multipart/form-data">
    <input type="hidden" name="cdm_token" value="<?php echo e(protection_token()); ?>">
    <input type="text" name="login" placeholder="login">
    <input type="text" name="password" placeholder="password">
    <input type="file" name="file[]" multiple>
    <button>Login</button>
</form>

<div class="list-users">
    <ul>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(route('chat', ['userid' => $user['userid']])); ?>"><?php echo e($user['userid']); ?></a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div><?php /**PATH W:\domains\myDb.loc\resources\Views/test.blade.php ENDPATH**/ ?>