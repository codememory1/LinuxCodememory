<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>
   
    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Редактирование данных</h4>
        </div>
        <div class="content-scroll">
            <div class="component-scroll">
                <div class="create-db-container">
                    <form id="form-update-data-table" action="<?php echo e(route('FastDB.edit-data-handle', ['db' => Request::get('db')->give(), 'table' => Request::get('table')->give(), 'id' => Request::get('id')->give(), 'where' => 'form'])); ?>" method="post">
                        <div class="container-prepend-data" style="display: inline-grid;width: 300px;">
                           <?php ($fileds = Store::getApi($basic->server($basicSettings->patchTables).$username.'/'.$basic->tableName(Request::get('db')->give(), Request::get('table')->give(), 'tablesDir').'/data.json')) ?>
                           <?php ($fileds = Store::uncompress($fileds)) ?>
                           <?php ($fileds = Response::jsonToArray($fileds)) ?>
                           
                           <?php $__currentLoopData = $fileds[1][Request::get('id')->give()]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kName => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           		<div style="margin-bottom:10px;display: inline-grid;">
									<label for="" style="margin-bottom: 12px;width: 55px;position: relative;top: 8px;float: left;margin-right: 10px;"><?php echo e($kName); ?></label>
									<input type="text" name="<?php echo e($kName); ?>" placeholder="<?php echo e($kName); ?>" value="<?php echo e($v); ?>">
								</div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                           <button class="btn">Обновить</button>
                           
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/edit-data-table.blade.php ENDPATH**/ ?>