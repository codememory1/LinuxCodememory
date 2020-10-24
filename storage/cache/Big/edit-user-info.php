<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php echo \Assets::execute()->css('libs/selector'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Создание Пользователя</span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <form action="<?php echo route('FastDB.edit-user-handler'); ?>?login=<?php echo Request::get('login'); ?>" method="POST" class="column" style="width: 400px">
                <input type="hidden" name="cdm_token" value="<?php echo protection_token(); ?>">
                <h6>Основные</h6>
                <div class="hr-light" style="width: 100%"></div>
                <div>
                    <label for="">Имя пользователя</label>
                    <input type="text" name="username" placeholder="Имя пользователя" value="<?php echo $userdata['username']; ?>">
                </div>
                <div>
                    <label for="">Пароль</label>
                    <input type="password" name="password" placeholder="Пароль пользователя" value="<?php echo base64_decode($userdata['password']); ?>">
                </div>
                <h6>Удаленные данные</h6>
                <div class="hr-light" style="width: 100%"></div>
                <div style="display: flex;">
                    <label for="" style="flex: 1;">Сохранять удаленные данные</label>
                    <input type="checkbox" name="save-deleted-data" class="on-off" <?php echo $userdata['deleted-data']['save'] === true ? 'checked' : ''; ?>>
                </div>
                <div style="display: flex;">
                    <label for="" style="flex: 1;">Локально</label>
                    <input type="radio" name="as-save-deleted-data" class="on-off" value="local" <?php echo $userdata['deleted-data']['asa'] === 'local' ? 'checked' : ''; ?>>
                </div>
                <div style="display: flex;">
                    <label for="" style="flex: 1;">На сервере</label>
                    <input type="radio" name="as-save-deleted-data" class="on-off" value="server" <?php echo $userdata['deleted-data']['asa'] === 'server' ? 'checked' : ''; ?>>
                </div>
                <h6>Другое</h6>
                <div class="hr-light" style="width: 100%"></div>
                <div style="display: block;position: relative;top:10px">
                    <label for="">Количество памяти</label>
                    <input style="width: 100%" type="range" id="range-memory-in-create-user" name="max-memory" min="10" max="600" value="<?php echo $userdata['memory']['of']; ?>">
                    <mark style="position: absolute;top: -10px;right: 0;"><span class="num-select-memory"><?php echo $userdata['memory']['of']; ?></span> MB</mark>
                </div>
                <div style="display: flex;position: relative;top:10px">
                    <label for="" style="flex: 1;">Freeze Account</label>
                    <input type="checkbox" empty-checkbox="true" name="freeze-account" class="on-off" <?php echo $userdata['freeze-account'] === true ? 'checked' : ''; ?>>
                </div>
                <div>
                    <button class="btn btn-success" style="margin: 0px;" btn-loader="default">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
    
</div>

<?php echo \View::theme('footer'); ?>
