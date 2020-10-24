<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<?php ($lang = Lang::selectLang(Lang::getActiveLang())) ?>

<main>

    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4><?php echo e($lang->get('database')); ?></h4>
        </div>
        
        <div class="content-scroll">
           	<?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

           	 <div class="content-scroll-center" style="display: flex;justify-content: center;min-height: auto;">
            	<div class="component-scroll" style="width:65%">
					<div class="content-list-table">
						<div class="table-db-content" id="data-table">
							<table>
								<thead>
									<tr>
										<th><?php echo e($lang->get('name_database')); ?></th>
										<th><?php echo e($lang->get('size')); ?></th>
										<th><?php echo e($lang->get('data_create')); ?></th>
										<th><?php echo e($lang->get('action')); ?></th>
									</tr>
							   </thead>
							   <tbody>
						   			<?php if(count($listDb) > 0): ?>
										<?php $__currentLoopData = $listDb['database']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
												<td>
													<a href="<?php echo e(route('FastDB.list-table')); ?><?php echo e(Common::collectParameters(['db' => $name])); ?>"><?php echo e($name); ?></a>
												</td>
												<td>
													<?php echo e($listDb['size'][$key]); ?> KB
												</td>
												<td>
													<span style="color:#000;"><?php echo e($listDb['info'][$key][0]['DB'][0]['DB_Created']); ?></span>
												</td>
												<td>
													<div class="act">
														<span class="delete-act-btn"><a href="<?php echo e(route('FastDB.delete-database', ['db' => $name])); ?>"><?php echo e($lang->get('delete')); ?> <i class="fad fa-trash-alt"></i></a></span>
													</div>
												</td>
											</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							   		<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>



<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/home.blade.php ENDPATH**/ ?>