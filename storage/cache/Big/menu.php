<?php $namespace0 = 'App\Models\HistoryModel'; $history = new $namespace0(); ?>

<div class="container-menu">
    <div class="content-menu">
        <ul class="ul-menu">
            <li class="item-menu"><a href="<?php echo route('FastDB.all-db'); ?>"><i class="fas fa-database"></i> <span>Все базы</span></a></li>
            <li class="item-menu"><a href="<?php echo route('FastDB.console'); ?>"><i class="fas fa-terminal"></i> <span>Консоль</span></a></li>
            <li class="item-menu" style="position:relative;"><a href="<?php echo route('FastDB.list-history'); ?>"><i class="fas fa-history"></i> <span>История</span></a><p class="num-new <?php echo $history->getNumberNotRead() !== null ? 'show' : ''; ?>"><?php echo $history->getNumberNotRead() > 99 ? '99+' : $history->getNumberNotRead(); ?></p></li>
            <li class="item-menu"><a href="<?php echo route('FastDB.list-users'); ?>"><i class="fas fa-users"></i> <span>Пользователи</span></a></li>
            <li class="item-menu"><a href=""><i class="fas fa-server"></i> <span>Мои сервера</span></a></li>
            <li class="item-menu"><a href="<?php echo route('FastDB.remote-data-storage'); ?>"><i class="fas fa-trash-restore"></i> <span>Хранилище удаленных данных</span></a></li>
            <li class="item-menu"><a href="<?php echo route('FastDB.representation'); ?>"><i class="fas fa-presentation"></i> <span>Представления</span></a></li>
            <li class="item-menu"><a href="<?php echo route('FastDB.additional-memory'); ?>"><i class="fas fa-sd-card"></i> <span>Дополнительная Память</span></a></li>
            <li class="item-menu"><a href="<?php echo route('FastDB.db-interface'); ?>"><i class="fas fa-pencil-paintbrush"></i> <span>Настройки Интерфейса</span></a></li>
            <li class="item-menu"><a href="<?php echo route('FastDB.settings'); ?>"><i class="fas fa-cogs"></i> <span>Настройки</span></a></li>
        </ul>
    </div>
</div>