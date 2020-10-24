<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Редактирование Структуру таблицы</span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <input type="text" class="num-add-column" placeholder="Кол-во новых колонок" value="1">
            <button class="btn btn-info btn-add-column" style="margin-left: 0;">Добавить Колонку</button>
            <form action="<?php echo route('FastDB.edit-structure-handler'); ?>?dbname=<?php echo Request::get('dbname'); ?>&table=<?php echo Request::get('table'); ?>" method="POST" class="row full-column-width" style="width: 100%;" id="create-table-form" data-fetch>
                <div class="sections-form-create-table">
                    <?php foreach($structure as $key => $column): ?>
                        <?php $key = explode('-', $key)[1];?>
                        <?php $randId = Random::randString(5);?>
                        <section class="full-width" data-id-column="<?php echo $randId; ?>" draggable="true">
                            <div>
                                <label for="">Имя колонки</label>
                                <input type="text" name="name-column[<?php echo $key; ?>]" placeholder="Имя колонки" value="<?php echo $column['name-column']; ?>">
                                <input type="hidden" name="old-name-column[<?php echo $key; ?>]" value="<?php echo $column['name-column']; ?>">
                            </div>
                            <div>
                                <label for="">Тип</label>
                                <select name="type[<?php echo $key; ?>]">
                                    <?php echo Store::replace([sprintf('value="%s"', $column['type']) => sprintf('value="%s" selected', $column['type'])], '<option value="int">Int</option><option value="string">String</option><option value="float">Float</option><option value="date">Date</option>'); ?>
                                </select>
                            </div>
                            <div>
                                <label for="">Длина</label>
                                <input type="text" name="length[<?php echo $key; ?>]" placeholder="Длина">
                            </div>
                            <div>
                                <label for="">По умолчанию</label>
                                <select name="default[<?php echo $key; ?>]">
                                    <?php echo Store::replace([sprintf('value="%s"', $column['default']) => sprintf('value="%s" selected', $column['default'])], '<option value="null">NULL</option><option value="date">Date</option><option value="datetime">Date Time</option><option value="timestamp">Timestamp</option><option value="autoid">Auto Id</option>'); ?>
                                </select>
                                <input type="text" name="other-default[<?php echo $key; ?>]" placeholder="Свое по умолчанию" value="<?php echo $column['other-default']; ?>">
                            </div>
                            <div>
                                <label for="">Кодировка</label>

                                <?php $charsets = null;?>
                                <?php foreach(mb_list_encodings() as $charset): ?>
                                    <?php $charsets .= '<option value="'.$charset.'">'.$charset.'</option>';?>
                                <?php endforeach; ?>

                                <select name="charset[<?php echo $key; ?>]">
                                    <?php echo Store::replace([sprintf('value="%s"', $column['charset']) => sprintf('value="%s" selected', $column['charset'])], $charsets); ?>
                                </select>
                            </div>
                            <span class="close-column" onclick="deleteColumn('<?php echo $randId; ?>')">
                                <i class="fal fa-times"></i>
                            </span>
                        </section>
                    <?php endforeach; ?>
                </div>
                <div class="loader-add-column-block" style="justify-content: center;"></div>
                <button class="btn btn-success" style="margin: 0px 7px;width: max-content;">Создать</button>
            </form>
        </div>
    </div>
</div>
<script>
    let types = {
        int: 'Int',
        string: 'String',
        float: 'Float',
        date: 'Date'
    };
    let defaults = {
        null: 'NULL',
        date: 'Date',
        datetime: 'Date Time',
        timestamp: 'Timestamp',
        autoid: 'Auth Id'
    };
    let charsets = {
        <?php foreach(mb_list_encodings() as $charset): ?>
            '<?php echo $charset; ?>': '<?php echo down_line($charset); ?>',
        <?php endforeach; ?>
    };
</script>
<?php echo \View::theme('footer'); ?>
