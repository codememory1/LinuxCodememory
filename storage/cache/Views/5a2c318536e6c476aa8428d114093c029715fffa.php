<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>
    
    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Хранилище удаленых данных</h4>
        </div>
        
        <div class="content-scroll">
           	<?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

            <div class="component-scroll">
                <div class="create-db-container">
                    <?php $__currentLoopData = $store[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    	<div class="deletee-data-for-table">
                    		<?php (list($db, $table) = explode('&', $k)) ?>
							<div class="table-name button-info" style="margin-top:13px;width:max-content">
								<span><?php echo e($db); ?> <i class="far fa-chevron-right"></i></span>
								<span><?php echo e($table); ?> <i class="far fa-chevron-right"></i></span>
							</div>
							<div class="content-deletee-data" style="float: left;width: 100%;margin-left:20px;">
								<p class="table-input-text"><input type="checkbox" all-hidden="false" class="minus" all-checkbox="<?php echo e($db); ?>-<?php echo e($table); ?>"><span>Все</span></p>
								<form action="<?php echo e(route('FastDB.data-store-restore', ['db' => $db, 'table' => $table])); ?>" method="post">
									<div class="container-deletee-data" style="float: left;width: 103%;">
										<?php ($i = 0) ?>
										<?php $__currentLoopData = $v; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kD => $vD): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>	
											<div class="m-table" style="float: left;margin-right: 10px;" draggable="true">
												<div class="teable-grid" style="width: auto;">
													<div class="table-grid__head">
														<?php $__currentLoopData = $vD; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kF => $vF): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<span><?php echo e($kF); ?></span>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														<span>
															<p style="float: right;margin: 3px 15px;"><input type="checkbox" name="id-deletee-data[<?php echo e(++$i); ?>]" add-hidden="false" select-checkbox="<?php echo e($db); ?>-<?php echo e($table); ?>" value="<?php echo e($kD); ?>"></p>
														</span>
													</div>
													<div class="table-grid__body">
														<div class="tr">
															<?php $__currentLoopData = $vD; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kF => $vF): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																<span><?php echo e($vF); ?></span>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															<span></span>
														</div>
													</div>
												</div>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
									<button class="button-success" style="margin-top: 20px;">Восстановить</button>
								</form>
							</div>
                    	</div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>


<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/data-store.blade.php ENDPATH**/ ?>