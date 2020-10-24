<?php ($basic = Model::load('FastDB\\Basic')) ?>
<?php ($config = Model::load('FastDB\\Configuration')) ?>
<?php ($statusConf = $config->getStatusConfigurate()) ?>
<?php ($classProgress = null) ?>
<?php ($lang = Lang::selectLang(Lang::getActiveLang())) ?>

<?php if($statusConf > 60): ?> 
	<?php ($classProgress = 'end') ?>
<?php endif; ?>
<?php if($statusConf <= 60 && $statusConf > 59): ?> 
	<?php ($classProgress = 'center') ?>
<?php endif; ?>
<?php if($statusConf < 25): ?> 
	<?php ($classProgress = '') ?>
<?php endif; ?>


<div class="site-bar-right">
	<div class="content-bar-tight">
		<center>
			<h4><?php echo e($lang->get('statistics')); ?></h4>
		</center>
		<div class="hr"></div>
		<div class="content-state-bar">
			<div>
				<label for=""><?php echo e($lang->get('memory')); ?></label>
				<div class="progress-bar">
					<div class="abs-progress" data-tipfy-side="top" data-tipfy="300MB / 10GB"></div>
				</div>
			</div>
			<div class="hr"></div>
			<div>
				<label for=""><?php echo e($lang->get('configuration')); ?></label>
				<div class="progress-bar" style="margin-top: 7px" data-tipfy-side="top" data-tipfy="<?php echo e($lang->get('tooltip_conf_progress')); ?>">
					<div class="abs-progress <?php echo e($classProgress); ?>" style="width:<?php echo e($statusConf); ?>%"></div>
				</div>
				<center>
					<a href="<?php echo e(route('FastDB.home').Common::collectParameters(['conf' => 'configure'])); ?>" class="button-info" style="margin-top: 7px;"><?php echo e($lang->get('tune')); ?></a>
				</center>
			</div>
			<div class="hr"></div>
			<div>
				<label for=""><?php echo e($lang->get('server')); ?> <mark>127.0.0.1</mark></label>
				<label for=""><?php echo e($lang->get('port')); ?> <mark>8000</mark></label>
			</div>
			<div class="hr"></div>
		</div>
	</div>
</div>
<?php if($statusConf > 0): ?>
<div class="error-settings-configuration">
	<div class="content-window-conf">
		<span><?php echo e(Store::replace(['%br' => '<br>'], $lang->get('not_error_conf'))); ?></span>
	</div>
</div>
<?php endif; ?>
<div class="container-site-bar">
    <h1 class="logo-common">
        <a href="<?php echo e(route('FastDB.home')); ?>" style="color:green;">FastDB</a>
    </h1>
    <div class="content-site-bar">
        <span class="db-title-site-bar">
            <center><?php echo e($lang->get('database')); ?>

            <div class="logout-db" style="float: right;margin-right: 10px;">
                <a style="color:crimson" href="<?php echo e(route('FastDB.auth-logout')); ?>">
                    <i data-tipfy-side="top" data-tipfy="<?php echo e($lang->get('logout')); ?>" class="fad fa-sign-out"></i>
                </a>
            </div>
            </center>
            
        </span>
        <div class="list-db">
            
            <div class="db-conector">
              	<?php if($basic->existsAccessRights('create-db', false) === true): ?>
					<a href="<?php echo e(route('FastDB.create-db')); ?>">
						<div class="create-db">
							<span><?php echo e($lang->get('create_db')); ?></span>
						</div>
					</a>
                <?php endif; ?>
            </div>
            <?php (Customize::get('FastDB', 'GetDbTables')) ?>
            <?php ($dbArr = getDbTables()) ?>
			<?php $__currentLoopData = $dbArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dbName => $tables): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php (list($pseudonym, $dbName) = explode('=', $dbName)) ?>
				<div class="db-conector">
					<div class="content-one-db">
						<span class="db-name">
							<a href="<?php echo e(route('FastDB.list-table')); ?>?db=<?php echo e($dbName); ?>"><?php echo e($dbName); ?></a>
							<div class="settings-db">
								<a href="<?php echo e(route('FastDB.settings-all-table', ['db' => $dbName])); ?>"><i data-tipfy-side="top" data-tipfy="<?php echo e($lang->get('settings_all_table')); ?>" class="far fa-cog"></i></a>
							</div>
						</span>

						<div class="table-db">
							<div class="content-table-db">
								<?php if($basic->existsAccessRights('create-table', false) === true): ?>
									<span><a href="<?php echo e(route('FastDB.create-table')); ?>?db=<?php echo e($dbName); ?>"><?php echo e($lang->get('create_table')); ?></a></span>
								<?php endif; ?>
								<?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php (list($db, $table) = explode('&', $table)) ?>
									<?php (list($pseudonym, $doFullTable) = explode('=', $table)) ?>
									<?php (list($table, $format) = explode('.', $doFullTable)) ?>
									
									<span class="table-span">
										<a href="<?php echo e(route('FastDB.watch-table').Common::collectParameters(['db' => $dbName, 'table' => $table])); ?>"><?php echo e($table); ?></a>
									</span>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>

					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>


<style>
	main {
		display: grid;
		grid-template-columns: 312px 1fr 250px;
	}

	.error-settings-configuration {
		position: fixed;
		bottom: 0;
		background: #e8afaf;
		width: 100%;
		padding: 10px 10px;
		color: #ec1010;
		font-weight: 500;
		text-align: center;
		z-index: 999;
		box-shadow: 1px -2px 4px 0px #00000061;
	}

	.site-bar-right {
		grid-column: 3 / 3;
		grid-row: 1 / 3;
		margin-top: 5px;
		margin-right: 5px;
		background-color: #393838;
		border-right: 1px solid #6d6d6d;
		border-left: 1px solid #6d6d6d;
		border-top: 1px solid #6d6d6d;
		border-radius: 3px;
	}

	.container-site-bar {
		grid-column: 1 / 2;
    	grid-row: 1 / 3;
	}

	.container-content {
		grid-column: 2 / 3;
    	grid-row: 1 / 3;
	}

	.content-state-bar > div {
		margin-right: 10px;
		margin-left: 10px;
		display: flow-root;
		margin-bottom: 20px;
	}

	.content-state-bar > div > label {
		width: 100%;
    	color: #fff;
		float: left;
		margin: 5px 0;
	}

	.progress-bar {
		width: 100%;
		height: 7px;
		background-color: #087cf2;
		margin-top: 5px;
		position: relative;
		border-radius: 3px;
		display: inline-block;
	}
	
	.abs-progress {
		background-color: #14de14;
		position: relative;
		left: 0;
		top: 0;
		width: 25%;
		height: 7px;
		cursor: pointer;
		border-radius: 3px 0 0 3px;
	}

	.abs-progress:before {
		content: '';
		position: absolute;
		right: 0;
		width: 3px;
		height: 14px;
		top: 50%;
		transform: translateY(-50%);
		background-color: #14de14;
		border-radius: 3px;
	}

	.abs-progress.center {
		background-color: orange;
	}
	.abs-progress.center:before {
		background-color: orange;
	}
	.abs-progress.end {
		background-color: red;
	}
	.abs-progress.end:before {
		background-color: red;
	}
</style><?php /**PATH W:\domains\myDb.loc\resources\Theme/FastDB/Default/SiteBarLeft.blade.php ENDPATH**/ ?>