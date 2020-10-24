<?php echo \Assets::execute()->js('configuration'); ?>
<?php echo \Assets::execute()->js('libs/super/Range'); ?>
<?php echo \Assets::execute()->js('libs/super/PaginationTable'); ?>
<?php echo \Assets::execute()->js('Modules/Request'); ?>
<?php echo \Build::execute()->js('app.min'); ?>

<script>    
    new Modal(true, [
    {
        id: 'delete-account',
        title: 'Удаление аккаунта'
    },
    {
        id: 'freeze-account',
        title: 'Заморозка аккаунта'
    },
    {
        id: 'logout-account',
        title: 'Выход из аккаунта'
    }
    ])
    .content([
    {
        content: '<div class="content-modal-delete-account"><span>Вы действительно хотите <u>Удалить</u> аккаунт без возможности восстановления?</span></div><div class="footer-modal"><button class="btn btn-light close-modal-btn" modal-close="delete-account">Отмена</button><button class="btn btn-error">Удалить</button></div>'
    },
    {
        content: '<div class="content-modal-delete-account">Content</div><div class="footer-modal"><button class="btn btn-light close-modal-btn">Отмена</button><button class="btn btn-error">Удалить</button></div>'
    },
    {
        content: '<div class="content-modal-delete-account"><span style="font-size: 15px!important;">Вы действительно хотите <u>Покинуть</u> аккаунт?</span></div><div class="footer-modal"><button class="btn btn-light close-modal-btn" style="padding: 5px 20px;" modal-close="logout-account">Отмена</button><a href="<?php echo route("FastDB.logout"); ?>"><button class="btn btn-error">Да, Покинуть</button></a></div>'
    }
    ]).render();

    ContextMenuObject.add('logout', 'Выйти из аккаунта').render();
</script>

</body>
</html>