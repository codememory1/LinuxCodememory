<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php echo \Assets::execute()->css('libs/selector'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Добавление Данных в Таблицу <mark><?php echo Request::get('table'); ?></mark></span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <form action="<?php echo route('FastDB.embed-data-handler'); ?>?dbname=<?php echo Request::get('dbname'); ?>&table=<?php echo Request::get('table'); ?>" method="POST" class="column" style="width: 450px;">
                <input type="hidden" name="cdm_token"value="<?php echo protection_token(); ?>">
                <div>
                    <label for="">Время жизни в Секундах «необязательно»</label>
                    <label for="">< 0 Постоянная</label>
                    <input type="number" name="life" placeholder="Введите время жизни записи" value="-1">
                    <div class="hr-light" style="margin-left: 0;"></div>
                </div>
                <?php foreach($structure as $column): ?>
                    <?php if($column['name-column'] !== 'life'): ?>
                        <div>
                            <label for=""><?php echo $column['name-column']; ?></label>
                            <input type="text" name="<?php echo $column['name-column']; ?>" placeholder="<?php echo $column['name-column']; ?>">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div>
                    <button class="btn btn-success" style="margin: 0px;" btn-loader="default">Добавить</button>
                </div>
            </form>
        </div>
    </div>
    
</div>

<?php echo \View::theme('footer'); ?>
