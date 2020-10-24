<?php echo Assets::execute()->css('FastDB/home'); ?>

<?php echo e(View::theme('FastDB/Common/Head')); ?>

<?php echo e(View::theme('FastDB/Default/Menu')); ?>


<main>
    <?php
        echo View::theme('FastDB/Default/SiteBarLeft');
    ?>
    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Error</h4>
        </div>
		<div class="content-scroll">
			<div class="component-scroll">
				<div class="create-db-container">
					<center class="error_center">
						<h4>У вас нет прав доступа для данной операции</h4>
					</center>
				</div>
			</div>
		</div>
	</div>
    
</main>

<?php echo e(View::theme('FastDB/Common/Footer')); ?>

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/error_other/error_rights_access.blade.php ENDPATH**/ ?>