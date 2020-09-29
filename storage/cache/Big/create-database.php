<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php echo \Assets::execute()->css('libs/selector'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Создание Базы Данных</span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <form action="<?php echo route('FastDB.create-db-handler'); ?>" method="POST" class="column" style="width: 300px;">
                <input type="hidden" name="cdm_token"value="<?php echo protection_token(); ?>">
                <div>
                    <label for="">Имя Базы Данных</label>
                    <input type="text" name="db-name" placeholder="Имя Базы Данных">
                </div>
                <div>
                    <label for="">Кодировка Базы Данных</label>
                    <select name="charset">
                        <?php foreach(mb_list_encodings() as $charset): ?>
                            <?php if($charset === 'UTF-8'): ?>
                                <option value="<?php echo $charset; ?>" selected><?php echo down_line($charset); ?></option>
                            <?php else: ?>
                                <option value="<?php echo $charset; ?>"><?php echo down_line($charset); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <button class="btn btn-success" style="margin: 0px;" btn-loader="default">Создать</button>
                </div>
            </form>
        </div>
    </div>
    
</div>

<?php echo \View::theme('footer'); ?>
