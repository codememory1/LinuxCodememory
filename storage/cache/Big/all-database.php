<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php $namespace0 = 'App\\Models\\DatabaseModel'; $dbWithTables = new $namespace0(); ?>

<script>
    let settingsModal = [];
    let contentsModal = [];
</script>
<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Все Базы Данных</span>
        </div>
        <div class="content-abs">
            <div class="all-database-with-info">
                <?php echo \View::theme('flash'); ?>

                <?php if(count($all) < 1): ?>
                    <center><h6>Пусто</h6></center>
                <?php endif; ?>

                <?php foreach($all as $dbname => $tables): ?>
                    <?php $info = $dbWithTables->getInfo($dbname);?>
                    
                    <div class="item-db">
                        <h6><?php echo $dbname; ?> <a href="<?php echo route('FastDB.open-db'); ?>?dbname=<?php echo $dbname; ?>">[Открыть]</a></h6>
                        <div class="information-database-click">
                            <div class="content-info-database" style="height: max-content;">
                                <span class="title-content-info-db">Информация о БД</span>
                                <div class="hr-light"></div>
                                <div class="name-columns">
                                    <span>Имя</span>
                                    <span>Кодировка</span>
                                    <span>Вес</span>
                                    <span>Создана</span>
                                    <span>Действия</span>
                                </div>
                                <div class="value-columns">
                                    <span><?php echo $info['information']['name']; ?></span>
                                    <span><?php echo down_line($info['information']['charset']); ?></span>
                                    <span><?php echo $dbWithTables->getSize($dbname); ?> B</span>
                                    <span><?php echo $info['information']['date-create']; ?></span>
                                    <span class="actions-buttons-column">
                                        <a href="<?php echo route('FastDB.open-db'); ?>?dbname=<?php echo $dbname; ?>" class="btn btn-success">
                                            <i class="far fa-external-link"></i>
                                        </a>
                                        <a href="" class="btn btn-info">
                                            <i class="far fa-cogs"></i>
                                        </a>
                                        <a <?php echo !$del_db ? 'forbidden-none' : ''; ?> class="btn btn-error" button-open-modal="delete-database-<?php echo $dbname; ?>">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                        <a class="btn btn-info" button-open-modal="info-database-<?php echo $dbname; ?>">
                                            <i class="far fa-info-circle"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <?php if(count($tables) > 0): ?>
                                <div class="content-info-database" style="height: max-content;">
                                    <span class="title-content-info-db">Таблицы</span>
                                    <div class="hr-light"></div>
                                    <ul class="list-tables-database">
                                        <?php foreach($tables as $table): ?>
                                            <li><a href="<?php echo route('FastDB.watch-table', ['db' => $dbname, 'table' => $table]); ?>"><?php echo $table; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <script>
                        settingsModal.push({
                            id: 'delete-database-<?php echo $dbname; ?>',
                            title: 'Удаление Базы  Данных'
                        },
                        {
                            id: 'info-database-<?php echo $dbname; ?>',
                            title: 'Инфомация о Базе Данных'
                        });
                        contentsModal.push({
                            content: '<div class="content-modal-delete-account"><span>Вы действительно хотите <u>Удалить</u> Базу Данных <u><?php echo $dbname; ?></u>?</span></div><div class="footer-modal"><button class="btn btn-light close-modal-btn" modal-close="delete-database-<?php echo $dbname; ?>">Отмена</button><a href="<?php echo route("FastDB.delete-db"); ?>?dbname=<?php echo $dbname; ?>" style="float: right;" class="btn btn-error">Удалить</a></div>'
                        },
                        {
                            content: '<div class="content-modal-delete-account"><div style="margin-bottom:10px;"><span>Запросов: <mark><?php echo $info["statistics"]["requests"]; ?></mark></span></div><div style="margin-bottom:10px;"><span>Создатель БД: <mark><?php echo $info["information"]["creator"]; ?></mark></span></div><div style="margin-bottom:10px;"><span>Таблиц в БД: <mark><?php echo count($tables); ?></mark></span></div></div><div class="footer-modal"><button class="btn btn-info close-modal-btn" modal-close="info-database-<?php echo $dbname; ?>">Закрыть</button>'
                        });
                    </script>
                    <div class="hr-light"></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php echo \View::theme('footer'); ?>
<script>
    new Modal(true, settingsModal).content(contentsModal).render();
</script>