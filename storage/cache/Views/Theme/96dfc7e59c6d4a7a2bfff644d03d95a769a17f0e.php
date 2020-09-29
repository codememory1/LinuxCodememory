<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    
    <title>FastDB - база данных для хранение информации</title>
    <?php ($theme = (Cookie::get('theme')) ? Cookie::get('theme') : 'dark') ?>
    <?php ($theme = ($theme != 'white' && $theme != 'dark') ? 'dark' : $theme) ?>
	
	<?php echo Assets::execute()->css('FastDB/Theme/_'.$theme); ?>

	<?php echo Assets::execute()->css('FastDB/_common'); ?>

	<?php echo Assets::execute()->css('all.min'); ?>

	<?php echo Assets::execute()->css('libs_component/selector'); ?>

	<?php echo Build::execute()->js('libs.min'); ?>

	<?php echo Assets::execute()->js('libs/selector'); ?>

	<script>
	  new Tipfy('[data-tooltip]');
	</script>
    <style>
        .container-content {
            overflow: auto!important;
        }
    </style>
</head>
<body>
<noscript>I do not have JavaScript enabled to work with FastDB</noscript>
    
<div class="loader-database">
	<div id="spinningSquaresG">
		<h2 class="nameLoaderText">Зазрузка <span class="logo-common"><a>FastDB</a></span></h2>
		<div id="spinningSquaresG_1" class="spinningSquaresG"></div>
		<div id="spinningSquaresG_2" class="spinningSquaresG"></div>
		<div id="spinningSquaresG_3" class="spinningSquaresG"></div>
		<div id="spinningSquaresG_4" class="spinningSquaresG"></div>
		<div id="spinningSquaresG_5" class="spinningSquaresG"></div>
		<div id="spinningSquaresG_6" class="spinningSquaresG"></div>
		<div id="spinningSquaresG_7" class="spinningSquaresG"></div>
		<div id="spinningSquaresG_8" class="spinningSquaresG"></div>
		<div id="spinningSquaresG_9" class="spinningSquaresG"></div>
	</div>
</div>
<div class="log"></div>
<?php /**PATH W:\domains\myDb.loc\resources\Theme/FastDB/Common/Head.blade.php ENDPATH**/ ?>