<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php $namespace0 = 'App\\Models\\UsersModel'; $users = new $namespace0(); ?>
<?php $access = $users->getUserData($users->getFullServer('server-dir'), Request::get('login'))['access-rights']?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Редактирование прав пользователя: <mark><?php echo Request::get('login'); ?></mark></span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <form action="<?php echo route('FastDB.edit-access-handler'); ?>?login=<?php echo Request::get('login'); ?>" method="POST" class="column" style="width: 300px">
                <input type="hidden" name="cdm_token"value="<?php echo protection_token(); ?>">
                    <h6>Настройка прав</h6>
                    <div class="hr-light" style="width: 100%"></div>
                    <div>
                        <label for=""><input type="checkbox" select-all-checkbox="all-privileges" class="minus"> <span class="span-privilege">Выбрать все</span></label>
                    </div>
                    <div style="position: relative;left: 20px;">
                        <h6>Базы Данных</h6>
                        <div style="position: relative;left: 20px;margin-top: 6px">
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[create-db]" select-checkbox="all-privileges" class="marker" <?php echo $access['create-db'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Создание Базы Данных</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[delete-db]" select-checkbox="all-privileges" class="marker" <?php echo $access['delete-db'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Удаление Базы Данных</span></label>
                        </div>
                        <h6>Таблицы</h6>
                        <div style="position: relative;left: 20px;margin-top: 6px">
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[create-table]" select-checkbox="all-privileges" class="marker" <?php echo $access['create-table'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Создание Таблицы</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[watch-table]" select-checkbox="all-privileges" class="marker" <?php echo $access['watch-table'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Просмотр Таблиц</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[embed-data-table]" select-checkbox="all-privileges" class="marker" <?php echo $access['embed-data-table'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Вставлять Данные</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[delete-table]" select-checkbox="all-privileges" class="marker" <?php echo $access['delete-table'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Удаление Таблицы</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[cleans-table]" select-checkbox="all-privileges" class="marker" <?php echo $access['cleans-table'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Очищать Таблицы</span></label>
                        </div>
                        <h6>Пользователи</h6>
                        <div style="position: relative;left: 20px;margin-top: 6px">
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[create-user]" select-checkbox="all-privileges" class="marker" <?php echo $access['create-user'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Создание Пользователя</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[check-all-users]" select-checkbox="all-privileges" class="marker" <?php echo $access['check-all-users'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Просмотр Пользователей</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[edit-user-access]" select-checkbox="all-privileges" class="marker" <?php echo $access['edit-user-access'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Редактирование прав</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[edit-user-info]" select-checkbox="all-privileges" class="marker" <?php echo $access['edit-user-info'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Редактирование Данны Пользователя</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[delete-user]" select-checkbox="all-privileges" class="marker" <?php echo $access['delete-user'] === true ? 'checked' : ''; ?>> <span class="span-privilege">Удаления Пользователей</span></label>
                        </div>
                    </div>
                <div>
                    <button class="btn btn-success" style="margin: 0px;" btn-loader="default">Сохранить</button>
                </div>
                
            </form>
        </div>
    </div>
    
</div>

<?php echo \View::theme('footer'); ?>
