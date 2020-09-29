<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Просмотр Таблицы <mark><?php echo $table; ?></mark></span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <div style="height: 30px;margin-left: 5px;">
                <a href="<?php echo route('FastDB.embed-data'); ?>?dbname=<?php echo $dbname; ?>&table=<?php echo $table; ?>" class="btn btn-success">Вставить Данные</a>
                <a href="" class="btn btn-info">Редактировать структуру таблицы</a>
            </div>
            <div class="table_statistics grid">
                <div class="content-statictic grid">
                    <div>
                        <div>
                            <span>Всего Запросов:</span>
                            <span><?php echo $datas['statistics']['all-request']; ?></span>
                        </div>
                        <div>
                            <span>Последний Запрос:</span>
                            <span><?php echo $datas['statistics']['last-request']; ?></span>
                        </div>
                        <div>
                            <span>Индитификатор Последней Записи:</span>
                            <span><?php echo $datas['statistics']['id-last-add-record']; ?></span>
                        </div>
                    </div>
                    <div>
                        <div>
                            <span>Всего Записей:</span>
                            <span><?php echo count($datas['data']); ?></span>
                        </div>
                        <div>
                            <span>Время Ответа:</span>
                            <span><?php echo number_format(microtime(true) - Server::get('REQUEST_TIME_FLOAT'), 4, '.', ''); ?> s</span>
                        </div>
                        <div>
                            <span>Индитификатор Последней Записи:</span>
                            <span>20</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-table">
                <div class="content-table">
                    <form action="<?php echo route('FastDB.delete-selection-record'); ?>?dbname=<?php echo $dbname; ?>&table=<?php echo $table; ?>" method="POST">
                        <button class="btn btn-error" style="margin-left: 0;font-size: 13px;">Удалить выбраное</button>
                        <table>
                            <thead>
                                <th><input type="checkbox" select-all-checkbox="all-delete-data" class="minus"></th>
                                <?php foreach($structure as $column): ?>
                                    <th style="position: relative;">
                                            <?php echo $column['name-column']; ?>
                                        <span class="type-column-th">
                                            <?php echo $column['type']; ?>
                                        </span>
                                        <span class="resize"></span>
                                    </th>
                                <?php endforeach; ?>
                                <th>Действия</th>
                            </thead>
                            <tbody>
                                <?php foreach($datas['data'] as $key => $data): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" select-checkbox="all-delete-data" class="marker" name="unique-id-record[]" value="<?php echo $key; ?>">
                                        </td>
                                        <?php foreach($structure as $column): ?>
                                            <?php foreach($data as $nameColumn => $dataValue): ?>
                                                <?php if($column['name-column'] === 'life'): ?>
                                                    <?php if($data[$column['name-column']] < 0): ?>
                                                        <td>
                                                            <?php echo $data[$column['name-column']]; ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>
                                                            <?php echo $data[$column['name-column']] - Date::unix(); ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <?php else: ?>
                                                    <td edit-field="true"><?php echo $data[$column['name-column']]; ?></td>
                                                <?php endif; ?>
                                                
                                                <?php break;?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                        <td>
                                            <a class="btn btn-success" href="<?php echo route('FastDB.edit-data-table'); ?>?dbname=<?php echo $dbname; ?>&table=<?php echo $table; ?>&id=<?php echo $key; ?>">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a class="btn btn-info" href="<?php echo route('FastDB.edit-access'); ?>?login=<?php echo $user['username']; ?>">
                                                <i class="far fa-user-chart"></i>
                                            </a>
                                            <a class="btn btn-error" href="<?php echo route('FastDB.delete-selection-record'); ?>?dbname=<?php echo $dbname; ?>&table=<?php echo $table; ?>&id=<?php echo $key; ?>">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                               
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    ContextMenuObject.addGroup([
        {
            name: 'structure-table',
            value: 'Показать структуру таблицы'
        },
        {
            name: 'info-column-table',
            value: 'Информация о колонках таблицы <span class="right" style="margin-top: 2px;"><input type="checkbox" class="on-off" id="info-column-table"></span>'
        },
        {
            name: 'on-off-statictic',
            value: 'Статистика таблицы <span class="right" style="margin-top: 2px;"><input type="checkbox" class="on-off" id="check-staticic-table"></span>'
        }
    ]);
</script>

<?php echo \View::theme('footer'); ?>
