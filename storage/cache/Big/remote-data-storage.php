<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php echo \Assets::execute()->css('libs/selector'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Хранилище Удаленных Данных</span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            
            <div class="container-storage-db">
                <?php if(count($all) < 1): ?>
                    <center>
                        <h6>Пусто</h6>
                    </center>
                <?php endif; ?>
                <?php foreach($all as $data): ?>
                    <div class="item-db" style="margin-bottom: 10px;">
                        <h6><?php echo $data['dbname']; ?> > <?php echo $data['table']; ?></h6>
                        <label for="" style="font-size: 13px;margin-left: 30px;margin-top: 10px;display: block;"><input select-all-checkbox="select-<?php echo $data['dbname']; ?>-<?php echo $data['table']; ?>" type="checkbox" class="minus" style="position: relative;top: 4px;"> Выбрать все</label>
                        <form action="" method="GET">
                            <?php foreach($data['data'] as $record): ?>
                                <div class="information-database-click">
                                    <div class="content-info-database" style="height: max-content;background: #737272fa;">
                                        <div class="name-columns" style="background: #353131">
                                            <?php foreach($record as $column => $value): ?>
                                                <span><?php echo $column; ?></span>
                                            <?php endforeach; ?>
                                            <span><input type="checkbox" class="marker" name="id-data[]" select-checkbox="select-<?php echo $data['dbname']; ?>-<?php echo $data['table']; ?>" value="1"></span>
                                        </div>
                                        <div class="value-columns">
                                            <?php foreach($record as $column => $value): ?>
                                                <span><?php echo $value; ?></span>
                                            <?php endforeach; ?>
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div style="width: 100%;height: 35px;">
                                <button class="btn btn-info">Восстановить</button>
                            </div>
                        </form>
                    </div>
                    <div class="hr-light"></div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
    
</div>

<?php echo \View::theme('footer'); ?>
