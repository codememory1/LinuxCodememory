<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<?php ($rand = Random::randAny(20)) ?>

<?php ($cstSettTbl = Customize::get('TableSettings', 'SettingsTable'))
?>

<main>
   	
   	<?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

   	
    <div class="container-content">
        <div class="block-content-top">
            <h4>Создание таблицы</h4>
        </div>
        <div class="content-scroll">
            <div class="component-scroll">
                <div class="create-db-container">
                    <form id="form-create-tbl" action="<?php echo e(route('FastDB.create-table-handle').Common::collectParameters(['db' => Request::get('db')])); ?>" method="post" form-ajax="true" data-redirect="<?php echo e(route('FastDB.list-table').Common::collectParameters(['db' => Request::get('db')])); ?>">
                        <div class="top-create-table">
                            <div>
                                <label for="name-db">Название таблицы</label>
                                <input type="text" name="name-table" id="name-db" placeholder="Название таблицы"><br><br><br>
                            </div>
                        </div>
                        <div class="add-new-pole-btn btn">
                            <span>Добавить новое поле</span>
                        </div>
                        <div class="data-tables">
                            <div class="content-filed-table" data-field="<?php echo e($rand); ?>">
                                <div class="content-data-tables-form">
                                    <label for="name-db">Название поля</label><br><br>
                                    <input type="text" name="fields[0]" id="name-filed" placeholder="Название поля">
                                </div>
                                <div class="content-data-tables-form">
                                    <label for="name-db">Тип</label><br><br>
                                    <select name="types[0]">
										<?php $__currentLoopData = $cstSettTbl['Html']['type']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php echo $type; ?>

										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="content-data-tables-form">
                                    <label for="name-db">Длина</label><br><br>
                                    <input type="text" name="length[0]" id="name-filed" placeholder="Длина">
                                </div>
                                <div class="content-data-tables-form">
                                    <label for="name-db">По умолчанию</label><br><br>
                                    <select name="default[0]" id="defaultDataTable">
										<?php $__currentLoopData = $cstSettTbl['Html']['default']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php echo $type; ?>

                                   		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="content-data-tables-form">
                                        <label for="name-db"></label><br><br>
                                        <input type="text" name="default-his[0]" id="name-filed" placeholder="Свое значение">
                                    </div>
                                </div>
                                <div class="content-data-tables-form">
                                    <label for="name-db">Кодировка</label><br><br>
                                    <select name="charset[0]" id="charset-db" class="select-style">
										<?php $__currentLoopData = mb_list_encodings(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $charset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                   			<?php echo Store::replace(['value="UTF-8"' => 'value="UTF-8" selected'], '<option value="'.$charset.'">'.$charset.'</option>'); ?>

                                   		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="delete-fields" delete-field="<?php echo e($rand); ?>">
                                    <i data-tipfy-side="top" data-tipfy="Удалить" class="fas fa-trash"></i>
                                </div>
                            </div>
                        </div>
                        <button class="btn">Создать</button>
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
        num.append('<div class="content-filed-table" data-field="'+randDeleteField+'"><div class="content-data-tables-form"><label for="name-db">Название поля</label><br><br><input type="text" name="fields['+result+']"'+ ' id="name-filed" placeholder="Название поля"></div><div class="content-data-tables-form"><label for="name-db">Тип</label><br><br><select name="types[' +result+ ']"><?php $__currentLoopData = $cstSettTbl['Html']['type']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo $type; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="content-data-tables-form"><label for="name-db">Длина</label><br><br><input type="text" name="length[' +result+ ']" id="name-filed" placeholder="Длина"></div><div class="content-data-tables-form"><label for="name-db">По умолчанию</label><br><br><select name="default[' +result+ ']" id="defaultDataTable"><?php $__currentLoopData = $cstSettTbl['Html']['default']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo $type; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><div class="content-data-tables-form"><label for="name-db"></label><br><br><input type="text" name="default-his['+result+']" id="name-filed" placeholder="Свое значение"></div></div><div class="content-data-tables-form"><label for="name-db">Кодировка</label><br><br><select name="charset[' +result+ ']" id="charset-db" class="select-style"><?php $__currentLoopData = mb_list_encodings(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $charset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo str_replace('value="UTF-8"', 'value="UTF-8" selected', '<option value="'.$charset.'">'.$charset.'</option>'); ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>}</select></div><div class="delete-fields" delete-field="'+randDeleteField+'"><i data-tipfy-side="top" data-tipfy="Удалить" class="fas fa-trash"></i></div></div>');
    });
</script><?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/create-tables.blade.php ENDPATH**/ ?>