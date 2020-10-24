<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php echo \Assets::execute()->css('libs/selector'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Настройки Таблицы <mark><?php echo Request::get('table'); ?></mark></span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <div style="max-width: 600px;margin: 0 auto">
                <form action="<?php echo route('FastDB.settings-table-handler'); ?>?dbname=<?php echo Request::get('dbname'); ?>&table=<?php echo Request::get('table'); ?>" method="POST" class="column" style="width: 600px;">
                    <input type="hidden" name="cdm_token"value="<?php echo protection_token(); ?>">
                    <div>
                        <label for="">Имя Таблицы</label>
                        <input type="text" name="table-name" placeholder="Имя Таблицы" value="<?php echo Request::get('table'); ?>">
                    </div>
                    <div>
                        <label for="">В Базе Данных</label>
                        <select name="dbname">
                            <?php foreach($allDb as $dbname): ?>
                                <?php if($dbname === Request::get('dbname')): ?>
                                    <option value="<?php echo $dbname; ?>" selected><?php echo $dbname; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $dbname; ?>"><?php echo $dbname; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="display: flex;float: right;">
                        <a class="btn btn-error" button-open-modal="clear-table-<?php echo Request::get('table'); ?>" style="font-size: 13px;">Очистить Таблицу</a>
                        <a class="btn btn-success" button-open-modal="share-table-<?php echo Request::get('table'); ?>" style="font-size: 13px;">Поделиться</a>
                        <button class="btn btn-info" btn-loader="default" style="font-size: 13px;margin-right: 0;">Обновить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo \View::theme('footer'); ?>

<script>
    new Modal(true, [{
        id: 'clear-table-<?php echo Request::get("table"); ?>',
        title: 'Удаление Таблицы'
    },
    {
        id: 'share-table-<?php echo Request::get("table"); ?>',
        title: 'Поделиться таблицей',
        height: 'max-content'
    }]).content([{
        content: '<div class="content-modal-delete-account"><span>Вы действительно хотите <u>Очистить</u> Таблицу <u><?php echo Request::get("table"); ?></u>?</span></div><div class="footer-modal"><button class="btn btn-light close-modal-btn" modal-close="clear-table-<?php echo Request::get("table"); ?>">Отмена</button><a href="<?php echo route("FastDB.cleans-table"); ?>?dbname=<?php echo Request::get("dbname"); ?>&table=<?php echo Request::get("table"); ?>" style="float: right;" class="btn btn-error" btn-loader="default">Очистить</a></div>'
    },{
        content: '<div class="content-modal-delete-account"><form action="/fastdb/db/create/handler" method="POST" class="column" style="width: 300px;"><div><label for="">IP Сервера</label><input type="text" name="ip-server" placeholder="Введите IP Сервера"></div><div><label for="">PORT Сервера</label><input type="text" name="port-server" placeholder="Введите PORT Сервера"></div><div><label for="">Имя Пользователя</label><input type="text" name="username" placeholder="Введите Имя Пользователя"></div></form></div><div class="footer-modal" style="position: unset;"><button class="btn btn-light close-modal-btn" modal-close="clear-table-<?php echo Request::get("table"); ?>">Отмена</button><button style="float: right;" class="btn btn-success" btn-loader="default">Отправить</button></div>'
    }]).render();
</script>
