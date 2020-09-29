<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>
    
    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Редактирование пользователя <mark><?php echo e($settingsUserId['login']); ?></mark></h4>
        </div>
        <div class="content-scroll">
			<?php if(Session::has('FastDB-Handle_Message')): ?>
				<div class="handle-message handle-message-<?php echo e(Session::get('FastDB-Handle_Message')['status']); ?>">
					<span><?php echo e(Session::flash('FastDB-Handle_Message')['message']); ?></span>
				</div>
			<?php endif; ?>
            <div class="component-scroll">
                <div class="create-db-container">
                    <form id="form-update-user-id" action="<?php echo e(route('FastDB.handle-edit-user', ['id' => $id])); ?>" method="post">
                        <div style="display: inline-grid;width: 600px;">
                           	<input type="hidden" name="cdm_token" value="<?php echo e(protection_token()); ?>">
                            <label for="" style="margin-bottom: 10px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;">Имя пользователя</label>
                            <div class="container-hash">
                                <input type="text" name="login" placeholder="Имя пользователя" value="<?php echo e($settingsUserId['login']); ?>">
                            </div>
                            
                            <label for="" style="margin-bottom: 20px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;">Пароль</label>
                            <div class="container-hash">
                                <input type="password" name="password" placeholder="Пароль" value="<?php echo e($settingsUserId['password']); ?>">
                            </div>
                            
                            <label for="" style="margin-bottom: 20px;width: 100%;position: relative;top: 8px;float: left;margin-right: 10px;">Разрешить получение уведомлений</label>
                            <div class="permission-data-select" style="width:50%;display:grid;margin-bottom:10px;"></div>
                            <div style="display:grid;">
                            	<p class="table-input-text"><input type="checkbox" name="delets-data-table" <?php echo e($settingsUserId['save-deletee-data'] === true ? 'checked' : null); ?> value="true"><span>Сохронять удаленые данные <mark><i data-tipfy-side="top" data-tipfy="Сохранять удаленые данные из таблицы. После удаление можно востановить. Но если таблица будет удалена, то 'удаленые данные из удаленой таблицы' будут тоже удалены  " class="far fa-question-circle"></i></mark></span></p>
							</div>
                            <button style="width: max-content;" class="btn">Сохранить</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>


<?php ($permission = ($settingsUserId['permission-data-form-users'] === true) ? 'true' : 'false') ?>

<script>
	new Selector([{
		"name": "permission-data",
		"where": ".permission-data-select",
		"add_as": "down",
		"selected": <?php echo e($permission == 'true' ? 0 : 1); ?>

	}],
	[{
		0: {
			"value": "true",
			"value_show": "Да"
		},
		1: {
			"value": "false",
			"value_show": "Нет"
		}
	}]);
</script><?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/edit-users.blade.php ENDPATH**/ ?>