<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>

    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Добавление данных в таблицу <mark><?php echo e(Request::get('db')); ?></mark></h4>
        </div>
        <div class="content-scroll">
           	<?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

            <div class="component-scroll">
                <div class="create-db-container">
                    <form id="form-prepend-data-table" action="<?php echo e(route('FastDB.add-data-table-handle', ['db' => Request::get('db'), 'table' => Request::get('table')])); ?>" method="post">
                        <div class="container-prepend-data" style="display: inline-grid;width: 300px;">
                           	<input type="hidden" name="cdm_token" value="<?php echo e(protection_token()); ?>">
							<?php ($fileds = Store::getApi('FastDB/Server/'.Session::get('FastDBAuth')['server'].'/Tables/Tables/'.Session::get('FastDBAuth')['username'].'/database='.Request::get('db').'&data&table='.Request::get('table').'/data.json')) ?>
							<?php ($fileds = Store::uncompress($fileds)) ?>
							<?php ($fileds = Response::jsonToArray($fileds)) ?>

							<?php $__currentLoopData = $fileds[0][0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kFiled => $filed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div style="margin-bottom:10px;display: inline-grid;">
									<label for="" style="margin-bottom: 12px;width: 55px;position: relative;top: 8px;float: left;margin-right: 10px;"><?php echo e($filed); ?></label>
									<input type="text" name="<?php echo e($filed); ?>" placeholder="<?php echo e($filed); ?>">
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <button class="btn">Добавить</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div> 
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/prepend-data-table.blade.php ENDPATH**/ ?>