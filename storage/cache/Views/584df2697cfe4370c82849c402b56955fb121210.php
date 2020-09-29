<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>
    
    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Редактирование прав доступа пользователя<mark><?php echo e($username); ?></mark></h4>
        </div>
        <div class="content-scroll">
           	<?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

            <div class="component-scroll">
                <div class="create-db-container">
                    <form id="form-update-user-id" action="<?php echo e(route('FastDB.handle-edit-access-rights', ['id' => $id])); ?>" method="post">
                        <div style="display: inline-grid;width: 600px;">
                          	<input type="hidden" name="cdm_token" value="<?php echo e(protection_token()); ?>">
                          	
                          	<p class="table-input-text"><input type="checkbox" all-checkbox="privilege" class="minus"><span>Выбрать все</span></p>
                          	
                          	<div style="margin-left:35px;display:grid;">
								<label for="" style="margin-bottom:5px!important;margin-top:5px!important;">БД</label>
								<p class="table-input-text"><input type="checkbox" name="rights.create-db" <?php echo e($rightsUser('create-db')); ?> select-checkbox="privilege"><span>Создание БД</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-db" <?php echo e($rightsUser('edit-db')); ?> select-checkbox="privilege"><span>Редактирование БД</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.delete-db" <?php echo e($rightsUser('delete-db')); ?> select-checkbox="privilege"><span>Удаление БД</span></p>
								<label for="" style="margin-bottom:5px!important;margin-top:5px!important;">Таблицы</label>
								<p class="table-input-text"><input type="checkbox" name="rights.create-table" <?php echo e($rightsUser('create-table')); ?> select-checkbox="privilege"><span>Создание Таблиц</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.watch-table" <?php echo e($rightsUser('watch-table')); ?> select-checkbox="privilege"><span>Просмотр Таблиц</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.delete-table" <?php echo e($rightsUser('delete-table')); ?> select-checkbox="privilege"><span>Удаление Таблицы</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-structure-table" <?php echo e($rightsUser('edit-structure-table')); ?> select-checkbox="privilege"><span>Редактирование Структуры</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-data-table" <?php echo e($rightsUser('edit-data-table')); ?> select-checkbox="privilege"><span>Редактирование Данных в Таблице</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.add-data-table" <?php echo e($rightsUser('add-data-table')); ?> select-checkbox="privilege"><span>Добавление Данных в Таблицу</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.delete-data-table" <?php echo e($rightsUser('delete-data-table')); ?> select-checkbox="privilege"><span>Удаление Данных в Таблице</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-settings-table" <?php echo e($rightsUser('edit-settings-table')); ?> select-checkbox="privilege"><span>Редактирование настроек таблицы</span></p>
								<label for="" style="margin-bottom:5px!important;margin-top:5px!important;">Пользователи</label>
								<p class="table-input-text"><input type="checkbox" name="rights.watch-users" <?php echo e($rightsUser('watch-users')); ?> select-checkbox="privilege"><span>Просмотр пользователей</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.add-users" <?php echo e($rightsUser('add-users')); ?> select-checkbox="privilege"><span>Создание Пользователей</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-users" <?php echo e($rightsUser('edit-users')); ?> select-checkbox="privilege"><span>Редактирование Пользователей</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.delete-users" <?php echo e($rightsUser('delete-users')); ?> select-checkbox="privilege"><span>Удаление Пользователей</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.create-server" <?php echo e($rightsUser('create-server')); ?> select-checkbox="privilege"><span>Создание сервера</span></p>
                          	</div>

                            <button style="width: max-content;margin-top:15px;" class="btn">Сохранить</button>
                        </div> 
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>


<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/edit-access-rights-user.blade.php ENDPATH**/ ?>