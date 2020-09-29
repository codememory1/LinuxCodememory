<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>История</span>
        </div>
        <div class="content-abs">
            <?php if(count($history) < 1): ?>
                <center>
                    <h6>Пусто</h6>
                </center>
            <?php endif; ?>
            <?php foreach($history as $key => $data): ?>
                <div class="card-history" history-id="<?php echo $key; ?>">
                    <span class="new-history <?php echo $data['is-ready'] === false ? 'show' : ''; ?>"></span>
                    <div class="content-card-history">
                        <div class="title-history">
                            <div>
                                <span><?php echo $data['title-history']; ?></span> 
                                <span class="delete-history" history-close-id="<?php echo $key; ?>">
                                    <i class="fas fa-times"></i>
                                </span>
                                <span class="date-create-history"><?php echo $data['date-send']; ?></span>
                            </div>
                        </div>
                        <div class="content-history">
                            <div class="data-sender-history grid">
                                <div>
                                    <span>Данные Отправителя: <span class="show_data_sender"><i class="far fa-eye"></i></span></span>
                                </div>
                                <div style="margin-left:20px;" class="data-sender-div">
                                    <span>Сервер: <mark><?php echo $data['sender-server']; ?></mark></span>
                                    <span>Пользователь: <mark><?php echo $data['sender']; ?></mark></span>
                                </div>
                            </div>
                            <?php echo $data['template-history']; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php echo \View::theme('footer'); ?>
