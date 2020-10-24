<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<?php ($cstSettTbl = Customize::get('TableSettings', 'SettingsTable')) ?>

<main>

    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Структура талицы</h4>
        </div>
        <div class="content-scroll">
            <div class="component-scroll">
                <div class="create-db-container">
                    <form form-ajax="true" data-redirect="<?php echo e(route('FastDB.watch-table').Common::collectParameters(['db' => Request::get('db')->give(), 'table' => Request::get('table')->give()])); ?>" id="form-edit-tbl" action="<?php echo e(route('FastDB.structure-handle', ['db' => Request::get('db')->give(), 'table' => Request::get('table')->give()])); ?>" method="post">
                        <div class="add-new-pole-btn btn">
                            <span>Добавить новое поле</span>
                        </div>
                        <div class="data-tables">
                            <?php ($i = 0) ?>
							<?php $__currentLoopData = $getSettingsTable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php ($i++) ?>

								<div class="content-filed-table" data-field="<?php echo e($k); ?>">
									<div class="content-data-tables-form">
										<label for="name-db">Название поля</label><br><br>
										<input type="text" name="fields[<?php echo e($i); ?>]" id="name-filed" value="<?php echo e($k); ?>" placeholder="Название поля">
										<input type="hidden" name="oldFields[<?php echo e($i); ?>]" value="<?php echo e($k); ?>">
									</div>
									<div class="content-data-tables-form">
										<label for="name-db">Тип</label><br><br>
										<select name="types[<?php echo e($i); ?>]">
											<?php ($typeCus = null) ?>
											
											<?php $__currentLoopData = $cstSettTbl['Html']['type']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php ($typeCus .= $type) ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											
											<?php echo Store::replace(['value="'.$v['types'].'"' => 'value="'.$v['types'].'" selected'], $typeCus); ?>

										</select>
									</div>
									<div class="content-data-tables-form">
										<label for="name-db">Длина</label><br><br>
										<input type="text" name="length[<?php echo e($i); ?>]" id="name-filed" value="<?php echo e($v['length']); ?>" placeholder="Длина">
									</div>
									<div class="content-data-tables-form">
										<label for="name-db">По умолчанию</label><br><br>
										<select name="default[<?php echo e($i); ?>]" id="defaultDataTable">
											<?php ($defaultCus = null) ?>
											
											<?php $__currentLoopData = $cstSettTbl['Html']['default']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $default): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php ($defaultCus .= $default) ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											
											<?php echo Store::replace(['value="'.$v['default'].'"' => 'value="'.$v['default'].'" selected'], $defaultCus); ?>

										</select>
										<div class="content-data-tables-form">
											<label for="name-db"></label><br><br>
											<input type="text" name="default-his[<?php echo e($i); ?>]" id="name-filed" placeholder="Свое значение" value="<?php echo e($v['default-his']); ?>">
										</div>
									</div>
									<div class="content-data-tables-form">
										<label for="name-db">Кодировка</label><br><br>
										<select name="charset[<?php echo e($i); ?>]" id="charset-db" class="select-style">
											<?php ($charsetNew = "") ?>

											<?php $__currentLoopData = mb_list_encodings(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $charset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php ($charsetNew .= '<option value="'.$charset.'">'.$charset.'</option>') ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

											<?php echo Store::replace(['value="'.$v['charset'].'"' => 'value="'.$v['charset'].'" selected'], $charsetNew); ?>

										</select>
									</div>
									<div class="delete-fields" delete-field="<?php echo e($k); ?>">
										<i data-tipfy-side="top" data-tipfy="Удалить" class="fas fa-trash"></i>
									</div>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button class="btn">Обновить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>


<script type="text/javascript">
    $('.add-new-pole-btn').on('click', function(){
        var randDeleteField = randStr(20);
        var num = $('.data-tables');
        let result = num[0].childElementCount + 1;
        num.append('<div class="content-filed-table" data-field="'+randDeleteField+'"><div class="content-data-tables-form"><label for="name-db">Название поля</label><br><br><input type="text" name="fields['+result+']"'+ ' id="name-filed" placeholder="Название поля"></div><div class="content-data-tables-form"><label for="name-db">Тип</label><br><br><select name="types[' +result+ ']"><?php $__currentLoopData = $cstSettTbl['Html']['type']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo $type; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="content-data-tables-form"><label for="name-db">Длина</label><br><br><input type="text" name="length[' +result+ ']" id="name-filed" placeholder="Длина"></div><div class="content-data-tables-form"><label for="name-db">По умолчанию</label><br><br><select name="default[' +result+ ']" id="defaultDataTable"><?php $__currentLoopData = $cstSettTbl['Html']['default']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> {<?php echo $type; ?>} <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><div class="content-data-tables-form"><label for="name-db"></label><br><br><input type="text" name="default-his['+result+']" id="name-filed" placeholder="Свое значение"></div></div><div class="content-data-tables-form"><label for="name-db">Кодировка</label><br><br><select name="charset[' +result+ ']" id="charset-db" class="select-style"><?php $__currentLoopData = mb_list_encodings(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $charset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo str_replace('value="UTF-8"', 'value="UTF-8" selected', '<option value="'.$charset.'">'.$charset.'</option>'); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="delete-fields" delete-field="'+randDeleteField+'"><i data-tipfy-side="top" data-tipfy="Удалить" class="fas fa-trash"></i></div></div>');
    });
</script>
<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/structure.blade.php ENDPATH**/ ?>