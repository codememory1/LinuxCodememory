<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php echo \Assets::execute()->css('libs/selector'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Создание Пользователя</span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <form action="<?php echo route('FastDB.create-user-handler'); ?>" method="POST" class="column" style="display: grid;grid-template-columns: 1fr 1fr;width: 100%;grid-column-gap: 30px;">
                <div class="left-infomration">
                    <input type="hidden" name="cdm_token"value="<?php echo protection_token(); ?>">
                    <h6>Основные</h6>
                    <div class="hr-light" style="width: 100%"></div>
                    <div>
                        <label for="">Имя пользователя</label>
                        <input type="text" name="username" placeholder="Имя пользователя">
                    </div>
                    <div>
                        <label for="">Пароль</label>
                        <input type="password" name="password" placeholder="Пароль пользователя">
                    </div>
                    <h6>Удаленные данные</h6>
                    <div class="hr-light" style="width: 100%"></div>
                    <div style="display: flex;">
                        <label for="" style="flex: 1;">Сохранять удаленные данные</label>
                        <input type="checkbox" name="save-deleted-data" class="on-off">
                    </div>
                    <div style="display: flex;">
                        <label for="" style="flex: 1;">Локально</label>
                        <input type="radio" name="as-save-deleted-data" class="on-off" value="local">
                    </div>
                    <div style="display: flex;">
                        <label for="" style="flex: 1;">На сервере</label>
                        <input checked type="radio" name="as-save-deleted-data" class="on-off" value="server">
                    </div>
                    <h6>Настройка прав</h6>
                    <div class="hr-light" style="width: 100%"></div>
                    <div>
                        <label for=""><input type="checkbox" select-all-checkbox="all-privileges" class="minus"> <span class="span-privilege">Выбрать все</span></label>
                    </div>
                    <div style="position: relative;left: 20px;">
                        <h6>Базы Данных</h6>
                        <div style="position: relative;left: 20px;margin-top: 6px">
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[create-db]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Создание Базы Данных</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[delete-db]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Удаление Базы Данных</span></label>
                        </div>
                        <h6>Таблицы</h6>
                        <div style="position: relative;left: 20px;margin-top: 6px">
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[create-table]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Создание Таблицы</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[watch-table]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Просмотр Таблиц</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[delete-table]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Удаление Таблицы</span></label>
                        </div>
                        <h6>Пользователи</h6>
                        <div style="position: relative;left: 20px;margin-top: 6px">
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[create-user]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Создание Пользователя</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[check-all-users]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Просмотр Пользователей</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[edit-user-access]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Редактирование прав</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[edit-user-info]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Редактирование Данных Пользователя</span></label>
                            <label for=""><input type="checkbox" empty-checkbox="true" name="privilege[delete-user]" select-checkbox="all-privileges" class="marker"> <span class="span-privilege">Удаления Пользователей</span></label>
                        </div>
                    </div>
                </div>
                <div class="right-infomration" style="display: block;">
                    <div style="display: block;margin-top: 65px;position: relative;">
                        <label for="">Количество памяти</label>
                        <input style="width: 100%" type="range" id="range-memory-in-create-user" name="max-memory" min="10" max="600" value="50">
                        <mark style="position: absolute;top: 0;right: 0;"><span class="num-select-memory">50</span> MB</mark>
                    </div>
                    <br>
                    <div style="display: flex;">
                        <label for="" style="flex: 1;">Freeze Account</label>
                        <input type="checkbox" empty-checkbox="true" name="freeze-account" class="on-off">
                    </div>
                </div>
                <div>
                    <button class="btn btn-success" style="margin: 0px;" btn-loader="default">Создать</button>
                </div>
                
            </form>
        </div>
    </div>
    
</div>

<?php echo \View::theme('footer'); ?>
