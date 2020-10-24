<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>
    
    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Создание Представления</h4>
        </div>
        <div class="content-scroll">
           	<?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

            <div class="component-scroll">
                <div class="menu-preface">
						<ul class="preface-block-menu-ul">
							<li class="li-menu-preface" dinamic-link="create-preface" dinamic-default="create-preface">Создать</li>
							<li class="li-menu-preface" dinamic-link="all-preface">Все Представления</li>
						</ul>
				</div>
				<div class="content-block-preface">
					<div class="block-perface" dinamic-block="create-preface">
						<form action="<?php echo e(route('FastDB.preface-create')); ?>" method="post">
							<div class="event-preface">
								<h4><mark>Событие:</mark></h4>
								<div style="margin-left: 30px;display:flex;">
									<p class="table-input-text"><input type="radio" name="event" value="auth" id="event-auth"><span><label for="event-auth">Авторизация</label></span></p>
									<p class="table-input-text"><input type="radio" name="event" value="create-db" id="event-create-db"><span><label for="event-create-db">Создание БД</label></span></p>
									<p class="table-input-text"><input type="radio" name="event" value="create-table" id="event-create-table"><span><label for="event-create-table">Создание Таблицы</label></span></p>
									<p class="table-input-text"><input type="radio" name="event" value="new-data-table" id="event-new-data-table"><span><label for="event-new-data-table">Новая запись в таблице</label></span></p>
									<p class="table-input-text"><input type="radio" name="event" value="update-structure-table" id="event-update-structure"><span><label for="event-update-structure">Обновление структуры</label></span></p>
									<p class="table-input-text"><input type="radio" name="event" value="full-update-table" id="event-full-update-table"><span><label for="event-full-update-table">Полное обновление таблицы</label></span></p>
									<p class="table-input-text"><input type="radio" name="event" value="create-user" id="event-create-user"><span><label for="event-create-user">Новый пользователь</label></span></p>
								</div>
								<h4><mark>Основыне данные:</mark></h4>
								<div style="margin-left: 30px;">
									<h4>Имя Предсталения</h4>
									<div><input type="text" name="name-representation" id="name-preface" placeholder="Название"></div>
									<div class="hr"></div>
									<h4>Название существующей БД</h4>
									<div id="db-select"></div>
									<h4>Название таблицы из указаной БД</h4>
									<div><input type="text" name="table-name" id="name-preface" placeholder="Название таблицы"></div>
									<div class="hr"></div>
									<h4>URL - обработчик: <mark><i data-tipfy-side="top" data-tipfy="Ссылка на обработчик озночает: ссылку на скрипт обработчик, который выполнится во время операции представления" class="far fa-question-circle"></i></mark></h4>
									<div class="form-input" style="display:-webkit-inline-box;height:-webkit-fill-available">
										<div><input type="text" name="url" id="name-db" placeholder="URL"></div>
										<div class="method-prefare" style="margin-left: 10px;"></div>
										<div class="count-request" style="margin-left: 10px;"></div>
										<button class="button-info" style="padding: 7px 8px;margin-left: 15px;">Создать Предсталения <i style="font-size: 15px;transform: translate(3px, 1px);" class="far fa-plus"></i></button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="block-perface" dinamic-block="all-preface">
						<div class="teable-grid">
							<div class="table-grid__head" id="all-preface">
								<span>Название</span>
								<span>Событие</span>
								<span>Обработчик</span>
								<span>Метод запроса</span>
								<span>База</span>
								<span>Таблица</span>
								<span>Запросов выполнено</span>
								<span>Процесс работы(end)</span>
								<span>Статус работы</span>
								<span>Создан</span>
								<span>Действие</span>
							</div>
							<div class="table-grid__body">
								<?php $__currentLoopData = $rep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="tr" style="text-align: center;">
									<span data-tipfy-side="top" data-tipfy="<u>Название:</u> <?php echo e($data['name-representation']); ?>"><?php echo e($data['name-representation']); ?></span>
									<span data-tipfy-side="top" data-tipfy="<u>Событие:</u> <?php echo e($data['event']); ?>"><?php echo e($data['event']); ?></span>
									<span data-tipfy-side="top" data-tipfy="<u>Url обработчик:</u> <?php echo e($data['url-handler']); ?>"><?php echo e($data['url-handler']); ?></span>
									<span data-tipfy-side="top" data-tipfy="<u>Метод запроса:</u> <?php echo e($data['method']); ?>"><mark><?php echo e($data['method']); ?></mark></span>
									<span data-tipfy-side="top" data-tipfy="<u>База данных:</u> <?php echo e($data['dbname']); ?>"><?php echo e($data['dbname']); ?></span>
									<span data-tipfy-side="top" data-tipfy="<u>Таблица:</u> <?php echo e($data['table-name']); ?>"><?php echo e($data['table-name']); ?></span>
									<span><span style="color: orange;font-weight: 500;"><?php echo e($data['statistics']['executed-requests']); ?></span> из <?php if($data['requests'] == 'infinitely'): ?> <span style="color: green;font-weight: 500;"><i class="far fa-infinity"></i></span><?php else: ?> <span style="color: green;font-weight: 500;"><?php echo e($data['requests']); ?></span> <?php endif; ?></span>
									<span data-tipfy-side="top" data-tipfy="<u>Процесс:</u> <?php echo e($data['statistics']['performance-over']); ?>"><mark><?php echo e($data['statistics']['performance-over']); ?></mark></span>
									<span data-tipfy-side="top" data-tipfy="<u>Статус работы:</u> <?php echo e($data['statistics']['job-status']); ?>"><?php echo $data['statistics']['job-status'] === true ? '<span style="color: green;font-weight: 500;">On</span>' : '<span style="color: maroon;font-weight: 500;">Off</span>'; ?></span>
									<span data-tipfy-side="top" data-tipfy="<u>Дата создане:</u> <?php echo e($data['date-created']); ?>"><?php echo e($data['date-created']); ?></span>
									<span><a href="<?php echo e(route('FastDB.preface-delete', ['event' => $data['event'], 'file' => $data['name-representation']])); ?>" class="button-error">Удалить</a></span>
								</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</main>

<style>
	
	.preface-block-menu-ul li {
		padding: 5px 5px;
		color: #fff;
		cursor: pointer;
		border-bottom: 1.5px solid #319c97;
		margin-right: 5px;
	}
	
	.preface-block-menu-ul li.active{
    	background: #429a1d;
		color: #fff;
		border-bottom: none;
		border-radius: 0;
	}
	
	.block-perface {
		transition: opacity 1s ease-out;
		opacity: 0;
		height: 0;
		overflow: hidden;
	}
	
	.block-perface.active {
		opacity: 1;
		height: auto;
	}
	
	.content-block-preface {
		float: left;
		width: 100%;
		height: max-content;
		padding: 15px;
		box-sizing: border-box;
	}
	
	#all-preface > span{
		text-align: center;
	}
	
	#all-preface {
		align-items: center;
	}
	
</style>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>

<?php echo Assets::execute()->js('libs/Dinamic-Link'); ?>

<script>
	new Selector(
		[{
			"name": "method",
			"where": ".method-prefare",
			"add_as": "down",
			"selected": 0,
			"width": "200px"
		},
		{
			"name": "count-request",
			"where": ".count-request",
			"add_as": "down",
			"selected": 0,
			"width": "210px"
		},
		{
			"name": "db-name",
			"add_as": "down",
			"where": "#db-select",
			"selected": 0,
			"width": "200px"
		}],
		[{
			0: {
				"value": "",
				"value_show": "Метод Запроса"
			},
			1: {
				"value": "post",
				"value_show": "POST"
			},
			2: {
				"value": "get",
				"value_show": "GET"
			}
		},
		{
			0: {
				"value": "",
				"value_show": "Запросов"
			},
			1: {
				"value": "1",
				"value_show": "1"
			},
			2: {
				"value": "5",
				"value_show": "5"
			},
			3: {
				"value": "20",
				"value_show": "20"
			},
			4: {
				"value": "infinitely",
				"value_show": "Много+"
			}
		},
		{
			
			0: {
				"value": "",
				"value_show": "--Не выбрано--"
			},
			
			<?php ($i = 1) ?>

			<?php if(count($listDB['database']) > 1): ?>
				<?php $__currentLoopData = $listDB['database']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $db): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					"<?php echo e($i++); ?>": {
						"value": "<?php echo e($db); ?>",
						"value_show": "<?php echo e($db); ?>"
					},
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
			
		}]
	);
</script>

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/preface.blade.php ENDPATH**/ ?>