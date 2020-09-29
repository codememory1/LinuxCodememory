<?php $namespace0 = 'App\\Models\\Repositories\\ImportRepository'; $importRep = new $namespace0(); ?>

<?php $dbWithTables = $importRep->model->load('Database');?>
<?php $common = $importRep->model->load('Common');?>
<?php $confRep = $importRep->getConfig();?>

<?php $dataUser = $confRep->getUserData($confRep->getFullServer()['server-dir'], $confRep->getUsername());?>

<?php $memoryPros = ($common->getCountMemory()['kb'] / $common->getCountMemory()['all']['kb']) * 100;?>

<div class="sitebar-left">
    <a href="<?php echo route('FastDB.all-db'); ?>">
        <div class="logo-sitebar-left">
            <h1>FastDB</h1>
        </div>
    </a>
    <div class="content-sitebar" style="overflow-x: hidden;position: relative;">
        <center>
            <button <?php echo !$common->getAccess('create-db') ? 'forbidden-none' : ''; ?> class="btn btn-success">
                <a href="<?php echo route('FastDB.create-db'); ?>" style="color:#fff">Создать Базу Данных <i style="margin-left: 6px;" class="fal fa-plus-circle"></i></a>
            </button>
        </center>
        <div class="hr-light"></div>
        <i style="margin-top: 10px;font-size: 29rem;color: #cccccc0d;position: absolute;left: 0;transform: rotate(45deg);pointer-events: none;" class="fas fa-database"></i>
        <?php if(count($dbWithTables->listWithTables()) < 1): ?>
            <center>
                <h4>Пусто</h4>
                <br>
                <div class="hr-light"></div>
                <span style="color: #ccccccba;">Создайте свою первую Базу Данных</span>
                <br>
                <center><a class="icon-create-database" href="<?php echo route('FastDB.create-db'); ?>"><i style="margin-top: 10px;font-size: 3.5em;color: #cccccc3b;" class="fal fa-plus-circle"></i></a></center>
            </center>
        <?php endif; ?>
        <?php foreach($dbWithTables->listWithTables() as $dbname => $tables): ?>
            <div class="db-container-click <?php echo Request::get('dbname') === $dbname ? 'active' : ''; ?>">
                <div class="default-show-db grid">
                    <span class="db-name">
                        <?php echo $dbname; ?>
                    </span>
                    <span class="ico-open-info-db grid"><i class="fal fa-plus-square"></i></span>
                </div>
                <div class="tables-db">
                    <ul>
                        <a <?php echo !$common->getAccess('create-table') ? 'forbidden-none' : ''; ?> href="<?php echo route('FastDB.create-table', ['db' => $dbname]); ?>?dbname=<?php echo $dbname; ?>"><li>Создать таблицу</li></a>
                        <?php foreach($tables as $table): ?>
                            <a href="<?php echo route('FastDB.watch-table', ['db' => $dbname, 'table' => $table]); ?>">
                                <li><?php echo $table; ?></li>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
        
    </div>
</div>

<div class="sitebar-right">
    <div class="content-sitebar" style="overflow-x: hidden;position: relative;">
        <i style="margin-top: 10px;font-size: 29rem;color: #cccccc0d;position: absolute;left: 0;transform: rotate(45deg);pointer-events: none;" class="fas fa-database"></i>
        <center>
            <h4>Статистика</h4>
        </center>
        <div class="hr-light"></div>
        <div class="container-info-server container-configuration-status">
            <div>Имя пользователя: <mark><?php echo $confRep->getUsername(); ?></mark></div>
            <div>Сервер: <mark><?php echo $confRep->getServer(); ?></mark></div>
            <div>Порт: <mark><?php echo $confRep->getPort(); ?></mark></div>
        </div>
        <div class="container-memory container-configuration-status">
            <span>Память:</span>
            <div class="progress progress-memory">
                <div class="progress-abs" style="width:<?php echo $memoryPros; ?>%"></div>
            </div>
            <span class="memory-left"><?php echo $common->getCountMemory()['kb']; ?> KB</span>
            <span class="memory-right"><?php echo $dataUser['memory']['of']; ?> <?php echo $dataUser['memory']['unit']; ?></span>
        </div>
        <br>
        <center>
            <h4>Настройки</h4>
        </center>
        <div class="hr-light"></div>
        <div class="container-info-server container-configuration-status">
            <div>Сохранение удаленых данных: <input type="checkbox" class="on-off" value="off" id="save-deleted-data" name="save-deleted-data" style="float:right;" <?php echo $dataUser['deleted-data']['save'] === true ? 'checked' : ''; ?> empty-checkbox="true"></div>
        </div>
        <div class="container-info-server container-configuration-status">
            <div>Сохранить <input type="radio" style="float:right;" id="as-save-deleted-data" name="as-save-deleted-data" class="on-off" value="local" <?php echo $dataUser['deleted-data']['asa'] === 'local' ? 'checked' : ''; ?>> <mark> локально </mark></div>
            <div>Сохранить <input type="radio" style="float:right;" id="as-save-deleted-data" name="as-save-deleted-data" class="on-off" value="server" <?php echo $dataUser['deleted-data']['asa'] === 'server' ? 'checked' : ''; ?>> <mark> на сервере </mark></div>
        </div>
        <div class="container-configuration-status">
            <span>Конфигурация:</span>
            <div class="progress progress-memory">
                <div class="progress-abs"></div>
            </div>
            <center>
                <a href="">
                    <button class="btn btn-info">Настроить</button>
                </a>
            </center>
        </div>
        <br>
        <center>
            <h4>Аккаунт</h4>
        </center>
        <br>
        <div class="hr-light" style="margin-bottom: 0;"></div>
        <div class="container-configuration-status" button-open-modal="freeze-account">
            <center>
                <a style="color:#de7777d6"><div>Заморозить аккаунт</div></a>
            </center>
        </div>
        <div class="container-configuration-status" button-open-modal="delete-account">
            <center>
                <a style="color:#de7777d6"><div>Удалить аккаунт</div></a>
            </center>
        </div>
        <div class="container-configuration-status" button-open-modal="logout-account">
            <center>
                <a style="color:#de7777d6"><div>Выйти</div></a>
            </center>
        </div>
    </div>
</div>
