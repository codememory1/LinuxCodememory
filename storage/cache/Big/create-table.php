<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Созданиие Таблицы</span>
        </div>
        <div class="content-abs">
            <input type="text" class="num-add-column" placeholder="Кол-во новых колонок" value="1">
            <button class="btn btn-info btn-add-column" style="margin-left: 0;">Добавить Колонку</button>
            <form action="<?php echo route('FastDB.create-table-handler'); ?>?dbname=<?php echo Request::get('dbname'); ?>" method="POST" class="row full-column-width" style="width: 100%;" id="create-table-form" data-fetch>
                <input type="text" class="num-add-column" placeholder="Название таблицы" name="table-name" style="width: max-content;margin-left: 6px;">
                <label for="" style="margin-top: 10px;width:max-content;margin-left: 5px;">
                    <input type="checkbox" name="add-column-life" class="on-off" checked>
                    <span style="margin: 3px 6px;font-size: 14px;display: block;float: right;">
                        Добавить колонки life
                    </span>
                </label>
                <div class="sections-form-create-table">
                    <section class="full-width" data-id-column="-1" draggable="true">
                        <div>
                            <label for="">Имя колонки</label>
                            <input type="text" name="name-column[]" placeholder="Имя колонки">
                        </div>
                        <div>
                            <label for="">Тип</label>
                            <select name="type[]">
                                <option value="int" selected>Int</option>
                                <option value="string">String</option>
                                <option value="float">Float</option>
                                <option value="date">Date</option>
                            </select>
                        </div>
                        <div>
                            <label for="">Длина</label>
                            <input type="text" name="length[]" placeholder="Длина">
                        </div>
                        <div>
                            <label for="">По умолчанию</label>
                            <select name="default[]">
                                <option value="null" selected>NULL</option>
                                <option value="date">Date</option>
                                <option value="datetime">Date Time</option>
                                <option value="timestamp">Timestamp</option>
                                <option value="autoid">Auto Id</option>
                            </select>
                            <input type="text" name="other-default[]" placeholder="Свое по умолчанию">
                        </div>
                        <div>
                            <label for="">Кодировка</label>
                            <select name="charset[]">
                                <?php foreach(mb_list_encodings() as $charset): ?>
                                    <?php if($charset === 'UTF-8'): ?>
                                        <option value="<?php echo $charset; ?>" selected><?php echo down_line($charset); ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $charset; ?>"><?php echo down_line($charset); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <span class="close-column" onclick="deleteColumn(-1)">
                            <i class="fal fa-times"></i>
                        </span>
                    </section>
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
