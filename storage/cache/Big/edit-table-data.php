<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php echo \Assets::execute()->css('libs/selector'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Редактирование Записи</span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <form action="<?php echo route('FastDB.edit-data-table-handler'); ?>?dbname=<?php echo Request::get('dbname'); ?>&table=<?php echo Request::get('table'); ?>&id=<?php echo Request::get('id'); ?>" method="POST" class="column" style="width: 450px;">
                <input type="hidden" name="cdm_token"value="<?php echo protection_token(); ?>">
                <div>
                    <label for="">Время жизни в Секундах «необязательно»</label>
                    <label for="">< 0 Постоянная</label>
                    <input type="number" name="life" placeholder="Введите время жизни записи" value="<?php echo $structure['life'] < 0 ? -1 : $structure['life'] - Date::unix(); ?>">
                    <div class="hr-light" style="margin-left: 0;"></div>
                </div>
                <?php foreach($structure as $nameColumn => $column): ?>
                    <?php if($nameColumn !== 'life'): ?>
                    <div>
                        <label for=""><?php echo $nameColumn; ?></label>
                        <input type="text" name="<?php echo $nameColumn; ?>" placeholder="<?php echo $nameColumn; ?>" value="<?php echo $column; ?>">
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div>
                    <button class="btn btn-success" style="margin: 0px;" btn-loader="default">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
    
</div>

<?php echo \View::theme('footer'); ?>
