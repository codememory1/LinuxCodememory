<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>

    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Список Таблиц базы данных <mark><?php echo e(Request::get('db')); ?></mark></h4>
        </div>
        <div class="content-scroll">
           <?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

            <div class="content-scroll-center" style="display: flex;justify-content: center;min-height: auto;">
				<div class="component-scroll" style="width:45%">
					<div class="content-list-table">
						<div class="table-db-content" id="data-table">
							<table>
								<thead>
									<tr>
										<th>Название таблицы</th>
										<th>Действие</th>
									</tr>
							   </thead>
							   <tbody>
								  	<?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								   	<tr>
										<td>
											<a href="<?php echo e(route('FastDB.watch-table')); ?><?php echo e(Common::collectParameters(['db' => Request::get('db'), 'table' => $table])); ?>"><?php echo e($table); ?></a>
										</td>
										<td>
											<div class="act">
												<span class="edit-act-btn"><a href="<?php echo e(route('FastDB.edit-settings-table').Common::collectParameters(['db' => Request::get('db'), 'table' => $table])); ?>">Редактировать</a></span>
												<span class="delete-act-btn"><a href="<?php echo e(route('FastDB.delete-table', ['db' => Request::get('db'), 'table' => $table])); ?>">Удалить <i class="fad fa-trash-alt"></i></a></span>
											</div>
										</td>
									</tr>
								   	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/table.blade.php ENDPATH**/ ?>