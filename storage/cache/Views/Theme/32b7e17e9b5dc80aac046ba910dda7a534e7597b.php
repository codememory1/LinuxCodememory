<?php echo Assets::execute()->css('FastDB/_menu'); ?>


<?php ($user = (object) Session::get('FastDBAuth')) ?>
<?php ($lang = Lang::selectLang(Lang::getActiveLang())) ?>

<style>
	.time span:not(.red){
		color: #fff;
		background: green;
		padding: 7px;
		border-radius: 3px;
		margin: 4px;
		text-align: center;
		justify-content: center;
	}
	
	.tim2e span:not(.red){
		color: #fff;
		background: green;
		padding: 7px;
		border-radius: 3px;
		margin: 4px;
		text-align: center;
		justify-content: center;
	}
	
	.red {
		color: #fff;
	}
</style>

<div class="container-menu">
    <div class="info-auth">
        <div class="content-info-top">
            <span><?php echo e($lang->get('auth_as')); ?> <u><span class="name-auth"><?php echo e($user->username); ?></span></u> <br> <?php echo e($lang->get('server')); ?> <u><span class="name-auth"><?php echo e(Store::replace(['-' => ':'], $user->server)); ?></span></u></span>
            <div class="lang">
            </div>
        </div>
    </div>
    <div class="lang"></div>
    <div class="content-menu">
        <ul class="menu-ul">
            <a href="<?php echo e(route('FastDB.home')); ?>" class="item">
                <li><?php echo e($lang->get('all_db')); ?></li>
            </a>
			<?php if('/'.Common::getUrl() == route('FastDB.watch-table')): ?>
				<?php ($table_uri = route('FastDB.structure').Common::collectParameters(['db' => Request::get('db'), 'table' => Request::get('table')])) ?>

				<a href="<?php echo e($table_uri); ?>" class="item">
					<li><?php echo e($lang->get('structure_table')); ?></li>
				</a>
			<?php endif; ?>
            <a href="<?php echo e(route('FastDB.console').Common::collectParameters(['table' => Request::get('table'), 'dbname' => Request::get('db')])); ?>" class="item">
                <li><?php echo e($lang->get('console')); ?></li>
            </a>
            <a href="<?php echo e(route('FastDB.users')); ?>" class="item">
                <li><?php echo e($lang->get('users')); ?></li>
            </a>
            <?php if('/'.Common::getUrl() == route('FastDB.watch-table')): ?>
                <?php ($table_uri = route('FastDB.export-table', ['db' => Request::get('db'), 'table' => Request::get('table')])) ?>

                <a href="<?php echo e($table_uri); ?>" class="item">
                    <li><?php echo e($lang->get('export_table')); ?></li>
                </a>
            <?php endif; ?>
            <?php if('/'.Common::getUrl() == route('FastDB.list-table')): ?>
                <?php ($table_uri = route('FastDB.import-table', ['db' => Request::get('db')])) ?>
                
                <a href="<?php echo e($table_uri); ?>" class="item">
                    <li><?php echo e($lang->get('import_table')); ?></li>
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('FastDB.data-store')); ?>">
            	<li><?php echo e($lang->get('store_data')); ?></li>
            </a>
            <a href="<?php echo e(route('FastDB.preface')); ?>">
            	<li><?php echo e($lang->get('representation')); ?></li>
            </a>
            <a href="<?php echo e(route('FastDB.settings')); ?>" class="item">
                <li><?php echo e($lang->get('settings')); ?></li>
            </a>
            <a href="<?php echo e(Redirector::getBack()); ?>" class="item hover-i-left" style="float:right;">
                <li><i class="fas fa-arrow-left"></i> <?php echo e($lang->get('back')); ?></li>
            </a>
        </ul>
    </div>
</div>

<style>
    .hover-i-left i {
        transition: transform 0.5s;
    }
    
    .hover-i-left:hover i{
        transform: translate(-3px, 0px);
    }
</style>

<?php ($lang = Lang::getActiveLang() == 'ru' ? 0 : 1) ?>
<script>
    new Selector([{
        name: 'lang',
        where: '.lang',
        add_as: 'down',
        selected: <?php echo e($lang); ?>

    }],
    [
        {
            0: {
                value: 'ru',
                value_show: "<a href='<?php echo e(route('FastDB.home')); ?>?lang=ru'>RU</a>"
            },
            1: {
                value: 'en',
                value_show: "<a href='<?php echo e(route('FastDB.home')); ?>?lang=en'>EN</a>"
            }
        }
    ]);
</script>
<?php /**PATH W:\domains\myDb.loc\resources\Theme/FastDB/Default/Menu.blade.php ENDPATH**/ ?>