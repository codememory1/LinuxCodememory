<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>

    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Таблица <mark><?php echo e(Request::get('table')); ?></mark> </h4>
        </div>
        <div class="content-scroll">
            <div class="component-scroll">
                <div class="content-list-table" style="width: 100%;">
                   	<div class="statictika">
                   		<h4>Статистика</h4>
                   		<div class="container-static-tables">
							<div class="static-table">
								<span class="title-static-table">Статистика таблицы</span>
								<div class="head-static-table">
									<span>Количество записей</span>
									<span>Количество полей</span>
									<span>Добавлено за сегодня</span>
									<span>Запросов всего</span>
								</div>
								<div class="body-static-table">
									<span><?php echo e(count($dataTable[1])); ?></span>
									<span><?php echo e(count($dataTable[0][0])); ?></span>
									<span>0</span>
									<span>3200</span>
								</div>
							</div>
                  			<div class="static-table">
								<span class="title-static-table">Основная статистика таблицы</span>
								<div class="head-static-table">
									<span>Время запроса</span>
									<span>Размер таблицы</span>
									<span>Последние изменения</span>
								</div>
								<div class="body-static-table">
									<span><?php echo e(number_format(microtime(true) - Server::get('REQUEST_TIME_FLOAT'), 4, '.', '')); ?> s</span>
									<span><?php echo e($sizeTable); ?> KB</span>
									<span><?php echo e(Date::unixDate($lastEdit)->format('d-m-Y H:i')); ?></span>
								</div>
							</div>
                   		</div>
                   	</div>

                    <span style="margin-bottom: 5px;float: left;width: 100%;">В виде:</span>
                    <div class="show-who">
                        <div class="table-data icon active" data-as-data="data-table">Таблицы</div>
                        <div class="table-data icon" data-as-data="data-object">Объекта</div>
                        <a class="prependDataTable" href="<?php echo e(route('FastDB.add-data-table')); ?><?php echo e(Common::collectParameters(['db' => Request::get('db'), 'table' => Request::get('table')])); ?>">Добавить данные</a>
                    </div>
                
                    
                    <div class="table-db-content" id="data-table">
                       	<form action="<?php echo e(route('action-table')); ?>" method="post">
                       		<input type="hidden" name="db" value="<?php echo e(Request::get('db')); ?>">
                       		<input type="hidden" name="table" value="<?php echo e(Request::get('table')); ?>">
							<div class="teable-grid">
								<div class="table-grid__head">
									<span><input type="checkbox" class="minus" all-checkbox="checked-data" add-hidden="false"></span>
									<?php $__currentLoopData = $dataTable[0][0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyFiled => $valueFiled): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<span><?php echo e($keyFiled); ?></span>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<span>Действие</span>
								</div>
								<div class="table-grid__body">
									<?php ($checkboxI = 0) ?>
									<?php $__currentLoopData = $dataTable[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyValue => $valueKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<div class="tr">
											<span><input type="checkbox" name="checked-data[<?php echo e(++$checkboxI); ?>]" add-hidden="false" value="<?php echo e($keyValue); ?>" select-checkbox="checked-data"></span>
											<?php $__currentLoopData = $valueKey; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<span data-url-handle="<?php echo e(route('FastDB.edit-data-handle', ['db' => Request::get('db'), 'table' => Request::get('table'), 'where' => 'table', 'id' => $keyValue])); ?>" id="watch-id-td" data-field="<?php echo e($key); ?>" ><?php echo e($v); ?></span>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<span>
												<div style="display: flex;justify-content: center;align-items: center;">
													<a class="bg-black-radius" href="<?php echo e(route('FastDB.edit-data')); ?><?php echo e(Common::collectParameters(['db' => Request::get('db'), 'table' => Request::get('table'), 'id' => $keyValue])); ?>" style="background-color:green;margin: 2px 3px;float: left;"><i style="transform: translate(15%, -15%);" class="far fa-pen" data-tipfy-side="top" data-tipfy="Редактировать"></i></a>
													<a class="bg-black-radius" style="background-color:crimson;margin: 2px 3px;float: left;cursor:pointer;" modal-open="data-tale-<?php echo e($keyValue); ?>"><i style="transform: translate(15%, -15%);" class="far fa-trash-alt" data-tipfy-side="top" data-tipfy="Удалить"></i></a>
												</div>
											</span>
											<div class="modal-container" modal-container="data-tale-<?php echo e($keyValue); ?>">
												<div class="common-fon-modal"></div>
												<div class="center-modal-container">
													<div class="content-modal-center">
														<div class="title-top-modal">
															<span class="title-modal">Подтвирждение</span>
															<span class="closed-modal close-md"><i class="fal fa-times"></i></span>
														</div>
														<div class="content-modal">
															<h4 style="padding: 5px 10px;">Вы действительно хотите удалить?</h4>
															<div class="hr"></div>
															<a style="float:right;margin-top: 4px;margin-right: 10px;" class="button-success" href="<?php echo e(route('FastDB.delete-data', ['db' => Request::get('db'), 'table' => Request::get('table'), 'id' => $keyValue])); ?>">Да</a>
															<a style="float:right;margin-top: 4px;" class="button-error close-md">Нет</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
							</div>
                      		<button class="button-error" name="button" value="delete">Удалить</button>
                       	</form>
                    	
                    </div>
                    <div class="table-db-content" id="data-object">
                        <div class="container-show-data-object" style="float: left;width: 100%;">
                        	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/watch-table.blade.php ENDPATH**/ ?>