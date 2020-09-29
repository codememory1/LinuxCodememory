<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<?php ($cdm_token = protection_token()) ?>

<main>

    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Настройки</h4>
        </div>
        
        <div class="content-scroll">
            <div class="component-scroll"> 
                <?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

                <div class="create-db-container">
                    <form id="form-update-settings" action="<?php echo e(route('FastDB.settings-handle', ['what' => 'user'])); ?>" method="post">
                       	<input type="hidden" name="cdm_token" value="<?php echo e($cdm_token); ?>">
                        <div style="display: inline-grid;width: 600px;">
                            <label for="" style="margin-bottom: 20px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;">Разрешить получение уведомлений</label>
                            <span class="permission-data-form-users__div" style="height: 35px;width: 50%;"></span>
                            <label for="" style="margin-bottom: 20px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;">Хэш Пользователя</label>
                            <div class="container-hash">
                                <input data-where-update-value="hash-user-update" data-indicator-status="true" data-indicator="eye-key-settings" class="dis-key disabled" type="text" name="hash" placeholder="Hash" value="<?php echo e($user['hash']); ?>">
                                <span class="eye-hash" style="cursor:pointer;margin-left: 10px;" data-show="eye-key-settings"><i data-tipfy-side="top" data-tipfy="Показать"  style="font-size: 18px;cursor: pointer;" class="fad fa-eye"></i></span>
                                <span data-update-value-rand="hash-user-update" class="update-key" style="cursor:pointer;margin-left: 10px;">
                                    <i data-tipfy-side="top" data-tipfy="Обновить"  class="fad fa-sync-alt" style="font-size: 16px;cursor: pointer;"></i>
                                </span>
                            </div>
                            <div style="margin: 15px 0;">
                            	<div style="display:flex"><input class="switch" type="checkbox" name="delets-data-table" <?php echo e($user['save-deletee-data'] === true ? 'checked' : null); ?> value="true"><label style="margin: 2px 7px">Сохронять удаленые данные <mark><i data-tipfy-side="top" data-tipfy="Сохранять удаленые данные из таблицы. После удаление можно востановить. Но если таблица будет удалена, то 'удаленые данные из удаленой таблицы' будут тоже удалены  " class="far fa-question-circle"></i></mark></label></div>
                            </div>
                            <button style="width: max-content;" class="btn">Обновить профиль</button>
                        </div> 
                    </form>
                    <form id="form-settings-FastDB-update" action="<?php echo e(route('FastDB.settings-handle', ['what' => 'basic'])); ?>" method="post">
                       	<input type="hidden" name="cdm_token" value="<?php echo e($cdm_token); ?>">
                        <div id="settings-title">
                            <div>
                                <h4>Настройки Базы Данных</h4>
                            </div>
                        </div> 
                        <div style="display: inline-grid;width: 600px;">
                            <label for="" style="margin-bottom: 20px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;">Тема Базы Данных</label>
                            <div class="theme-db__div" style="height: 35px;width: 50%;"></div>
                            <button style="width: max-content;" class="btn">Обновить настройки БД</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>


<script type="text/javascript">
    new Selector(
        [
            {
                "name": "permission-data-form-users",
                "where": ".permission-data-form-users__div",
                "add_as": "down",
                "selected": <?php echo e(($user['permission-data-form-users'] === true) ? 1 : 0); ?>

            },
            {
                "name": "theme-db",
                "where": ".theme-db__div",
                "add_as": "down",
                "selected": <?php if(!Cookie::get('theme')): ?> <?php echo e(1); ?> <?php else: ?> <?php echo e((Cookie::get('theme') == 'white') ? 0 : 1); ?> <?php endif; ?>
            }
        ],
        [
            {
                "1": {
                    "value": "true",
                    "value_show": "Да"
                },
                "0": {
                    "value": "false",
                    "value_show": "Нет"
                }
            },
            {
                "0": {
                    "value": "white",
                    "value_show": "Белый"
                },
                "1": {
                    "value": "dark",
                    "value_show": "Темный"
                }
            }
        ]
    );
</script><?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/settings.blade.php ENDPATH**/ ?>