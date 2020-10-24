<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>
    
    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Настройки таблицы</h4>
        </div>
        <div class="content-scroll">
           	<?php if(Session::has('FastDB-Handle_Message')): ?>
				<div class="handle-message handle-message-<?php echo e(Session::get('FastDB-Handle_Message')['status']); ?>">
					<span><?php echo e(Session::flash('FastDB-Handle_Message')['message']); ?></span>
				</div>
           	<?php endif; ?>
            <div class="component-scroll">
                <div class="create-db-container">
                    <form id="form-update-settings-table" class="d-center" action="<?php echo e(route('FastDB.edit-settings-table-handle', ['db' => Request::get('db')->give(), 'table' => Request::get('table')->give()])); ?>" method="post">
                       	<input type="hidden" name="cdm_token" value="<?php echo e(protection_token()); ?>">
                        <div class="container-prepend-data" style="display: inline-grid;width: 600px;">
                            <div style="margin-bottom:10px;display: inline-grid;">
                                <label for="" style="margin-bottom: 12px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;">Название таблицы</label>
                                <input type="text" name="name-table" placeholder="Название таблицы" value="<?php echo e(Request::get('table')->give()); ?>">
                            </div>
                            <div style="margin-bottom:10px;display: inline-grid;">
                                <label for="" style="margin-bottom: 20px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;">База данных для таблицы</label>
                                <div class="db-table-seleted__div" style="width:50%;height:35px;"></div>
                            </div>
                            <!-- <div style="margin-bottom:10px;display: inline-grid;">
                                <label for="" style="margin-bottom: 12px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;"><center>Передать таблицу пользователю</center></label>
                                <label for="" style="margin-bottom: 12px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;">Имя пользователя</label>

                                <input type="text" name="hash-user" placeholder="Имя пользователя">
                            </div> -->
                            <button style="width: max-content;" class="btn">Сохранить</button>
                        </div>
                    </form>
                </div> 
            </div> 
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>


<script type="text/javascript">
    new Selector(
        [
            {
                "name": "db-table",
                "add_as": "down",
                "where": ".db-table-seleted__div"
            }
        ],
        [
            {
                "0": {
                    "value": "<?php echo e(Request::get('db')->give()); ?>",
                    "value_show": "<?php echo e(Request::get('db')->give()); ?>"
                },
				<?php ($i = 1) ?>

				<?php if(count($listDB) > 1): ?>
					<?php $__currentLoopData = $listDB; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $db): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if($db != Request::get('db')->give()): ?>
							"<?php echo e($i++); ?>": {
								"value": "<?php echo e($db); ?>",
								"value_show": "<?php echo e($db); ?>"
							},
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
            }
        ]
    );
</script><?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/edit-settings-table.blade.php ENDPATH**/ ?>