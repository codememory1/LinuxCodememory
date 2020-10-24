<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>

	<?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

   
    <div class="container-content">
        <div class="block-content-top">
            <h4>Создание сервера</h4><br>
        </div>
        <div class="content-scroll">
           	<?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

            <div class="component-scroll">
                <div class="create-db-container">
                    <form id="form-create-db" action="<?php echo e(route('FastDB.create-server-handle')); ?>" method="post">
                        <input type="hidden" name="cdm_token" value="<?php echo e(protection_token()); ?>">
                        <label for="name-db">IP сервера (000.000.00.00.0)</label>
                        <input type="text" name="server-ip" id="name-db" placeholder="IP"><br><br>
                        <label for="charset-db">Порт сервера (1001-9999)</label><br><br>
                        <input type="text" name="server-port" id="name-db" placeholder="PORT"><br><br>
                        <button class="btn">Создать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/create-server.blade.php ENDPATH**/ ?>