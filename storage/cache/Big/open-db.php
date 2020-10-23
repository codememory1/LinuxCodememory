<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php $namespace0 = 'App\\Models\\TablesModel'; $tablesModel = new $namespace0(); ?>

<script>
    let settingsModal = [];
    let contentsModal = [];
</script>
<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Открыта База Данных <mark><?php echo Request::get('dbname'); ?></mark></span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <div class="container-table">
                <div class="content-table">
                    <table>
                        <thead>
                            <th>Имя Таблицы</th>
                            <th>Кол-во Данных</th>
                            <th>Вес</th>
                            <th>Дата Создания</th>
                            <th>Действия</th>
                        </thead>
                        <tbody>
                            <?php foreach($tables as $table): ?>
                                <?php $info = $tablesModel->getInfo(Request::get('dbname'), $table);?>
                                <tr>
                                    <td>
                                        <?php echo $table; ?>
                                    </td>
                                    <td>
                                        <?php echo count($info['data']); ?>
                                    </td>
                                    <td>
                                        <?php echo $info['size'] / 1000; ?> KB
                                    </td>
                                    <td>
                                        <?php echo $info['stat']['date-create']; ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="<?php echo route('FastDB.settings-table'); ?>?dbname=<?php echo Request::get('dbname'); ?>&table=<?php echo $table; ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="btn btn-error" button-open-modal="delete-table-<?php echo $table; ?>">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <script>
                                    settingsModal.push({
                                        id: 'delete-table-<?php echo $table; ?>',
                                        title: 'Удаление Таблицы'
                                    });
                                    contentsModal.push({
                                        content: '<div class="content-modal-delete-account"><span>Вы действительно хотите <u>Удалить</u> Таблицу <u><?php echo $table; ?></u>?</span></div><div class="footer-modal"><button class="btn btn-light close-modal-btn" modal-close="delete-table-<?php echo $table; ?>">Отмена</button><a href="<?php echo route("FastDB.delete-table"); ?>?dbname=<?php echo Request::get("dbname"); ?>&table=<?php echo $table; ?>" style="float: right;" class="btn btn-error">Удалить</a></div>'
                                    });
                                </script>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if($tables === []): ?>
                        <center><h6>Пусто</h6></center>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo \View::theme('footer'); ?>
<script>
    new Modal(true, settingsModal).content(contentsModal).render();
</script>
