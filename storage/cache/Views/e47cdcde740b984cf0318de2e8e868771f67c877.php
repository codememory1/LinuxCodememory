<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>
    
    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Добавление пользователя</h4>
        </div>
        <div class="content-scroll">
           	<?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

            <div class="component-scroll">
                <div class="create-db-container">
                    <form id="form-add-user" action="<?php echo e(route('FastDB.handle-add-new-user')); ?>" method="post">
                        <div style="display: inline-grid;width: 400px;" class="form-label">
                           	<input type="hidden" name="cdm_token" value="<?php echo e(protection_token()); ?>">
                            <label for="">Имя пользователя</label>
                            <input type="text" name="login" placeholder="Имя пользователя">
                            
                            <label for="">Пароль</label>
                            <input type="password" name="password" placeholder="Пароль">
                            
                            <label for="" style="margin-bottom:25px!important;">Разрешить получение уведомлений</label>
                            <div class="permission-data__div" style="width:50%; height:35px;"></div>
                            
                            <div style="display:grid;">
                            	<p class="table-input-text"><input type="checkbox" name="delets-data-table" value="true"><span>Сохронять удаленые данные <mark><i data-tipfy-side="top" data-tipfy="Сохранять удаленые данные из таблицы. После удаление можно востановить. Но если таблица будет удалена, то 'удаленые данные из удаленой таблицы' будут тоже удалены  " class="far fa-question-circle"></i></mark></span></p>
							</div>
                            
                            <label for="" style="margin-bottom:10px!important;">Права доступа</label>
                            <p class="table-input-text"><input type="checkbox" all-checkbox="privilege" class="minus"><span>Выбрать все</span></p>

                            <div style="margin-left:35px;display:grid;">
                            	<label for="" style="margin-bottom:10px!important;">БД</label>
								<p class="table-input-text"><input type="checkbox" name="rights.create-db" select-checkbox="privilege"><span>Создание БД</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-db" select-checkbox="privilege"><span>Редактирование БД</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.delete-db" select-checkbox="privilege"><span>Удаление БД</span></p>
								<label for="" style="margin-bottom:10px!important;">Таблицы</label>
								<p class="table-input-text"><input type="checkbox" name="rights.create-table" checked select-checkbox="privilege"><span>Создание Таблиц</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.watch-table" checked select-checkbox="privilege"><span>Просмотр Таблиц</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.delete-table" checked select-checkbox="privilege"><span>Удаление Таблицы</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-structure-table" checked select-checkbox="privilege"><span>Редактирование Структуры</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-data-table" checked select-checkbox="privilege"><span>Редактирование Данных в Таблице</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.add-data-table" checked select-checkbox="privilege"><span>Добавление Данных в Таблицу</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.delete-data-table" checked select-checkbox="privilege"><span>Удаление Данных в Таблице</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-settings-table" checked select-checkbox="privilege"><span>Редактирование настроек таблицы</span></p>
								<label for="" style="margin-bottom:10px!important;">Пользователи</label>
								<p class="table-input-text"><input type="checkbox" name="rights.watch-users" select-checkbox="privilege"><span>Просмотр пользователей</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.add-users" select-checkbox="privilege"><span>Создание Пользователей</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.edit-users" select-checkbox="privilege"><span>Редактирование Пользователей</span></p>
								<p class="table-input-text"><input type="checkbox" name="rights.delete-users" select-checkbox="privilege"><span>Удаление Пользователей</span></p>
                                <p class="table-input-text"><input type="checkbox" name="rights.create-server" select-checkbox="privilege"><span>Создание сервера</span></p>
                            </div>
                            
                            <button style="width: max-content;margin-top: 10px;" class="btn">Создать</button>
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
                "name": "permission-data",
                "add_as": "down",
                "where": ".permission-data__div"
            }
        ],
        [
            {
                "0": {
                    "value": "true",
                    "value_show": "Да"
                },
                "1": {
                    "value": "false",
                    "value_show": "Нет"
                }
            }
        ]
    );
</script><?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/add-user.blade.php ENDPATH**/ ?>