<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>FastDB</title>
	
	<?php echo \Assets::execute()->css('all.min'); ?>
	<?php echo \Build::execute()->css('main.min'); ?>
	<?php echo \Assets::execute()->js('Modules/ContextMenu'); ?>

	<script>
		let defaultMenu = [
			{name: 'reload', value: 'Перезагрузить'},
			{name: 'prev', value: 'Предыдущея страница'}
		];
		const ContextMenuObject = new ContextMenu();
    	ContextMenuObject.addGroup(defaultMenu);
	</script>
</head>
<body>

<div class="content-all-notifications"></div>
