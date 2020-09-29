<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>
<script>
    let settingsModal = [];
    let contentsModal = [];
</script>
<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Список Пользователей</span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <a href="<?php echo route('FastDB.create-user'); ?>" class="btn btn-success" style="margin-right: 10px;float:right;">Создать Пользователя</a>
            <div class="container-table">
                <div class="content-table">
                    <table>
                        <thead>
                            <th>Имя Пользователя</th>
                            <th>Server</th>
                            <th>Пароль</th>
                            <th>Права</th>
                            <th>Заморожен</th>
                            <th>Дата Создания</th>
                            <th>Действия</th>
                        </thead>
                        <tbody>
                            <?php foreach($users as $k => $user): ?>
                                <?php $countAccessTrue = 0?>
                                <?php foreach($user['access-rights'] as $status): ?>
                                    <?php $status === true ? $countAccessTrue++ : null?>
                                <?php endforeach; ?>
                                <?php $prosentAccess = round($countAccessTrue / count($user['access-rights']) * 100)?>
                                <tr>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['server']; ?><span class="info">:</span><?php echo $user['port']; ?></td>
                                    <td><?php echo empty($user['password']) ? '<i class="green fas fa-badge-check"></i>' : '<i class="red fal fa-times-circle"></i>'; ?></td>
                                    <td><?php echo $prosentAccess > 99 ? '<span class="green">ALL</span>' : '<span class="red">NOT ALL</span>'; ?></td>
                                    <td>
                                        <input type="checkbox" name="freeze-account" class="banned-account on-off" <?php echo $user['freeze-account'] === true ? 'checked' : ''; ?> user-hash="<?php echo $user['hash']; ?>">
                                    </td>
                                    <td><?php echo $user['date-created']; ?></td>
                                    <td>
                                        <a class="btn btn-success" href="<?php echo route('FastDB.edit-user'); ?>?login=<?php echo $user['username']; ?>">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="btn btn-info" href="<?php echo route('FastDB.edit-access'); ?>?login=<?php echo $user['username']; ?>">
                                            <i class="far fa-user-chart"></i>
                                        </a>
                                        <a class="btn btn-error" button-open-modal="delete-user-<?php echo $k; ?>">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <script>
                                    settingsModal.push({
                                        id: 'delete-user-<?php echo $k; ?>',
                                        title: 'Удаление Пользователя'
                                    });
                                    contentsModal.push({
                                        content: '<div class="content-modal-delete-account"><span>Вы действительно хотите <u>Удалить</u> Пользователя <u><?php echo $user["username"]; ?></u>?</span></div><div class="footer-modal"><button class="btn btn-light close-modal-btn" modal-close="delete-user-<?php echo $k; ?>">Отмена</button><a href="<?php echo route("FastDB.delete-user"); ?>?login=<?php echo $user["username"]; ?>" style="float: right;" class="btn btn-error" btn-loader="default">Удалить</a></div>'
                                    });
                                </script>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo \View::theme('footer'); ?>
<script>
    new Modal(true, settingsModal).content(contentsModal).render();
</script>
