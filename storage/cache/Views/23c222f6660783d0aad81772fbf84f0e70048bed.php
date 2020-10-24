
<?php echo e(View::theme('FastDB/Common/Head')); ?>

<?php echo e(View::theme('FastDB/Default/Menu')); ?>


<main>
    <?php echo e(View::theme('FastDB/Default/SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Error</h4>
        </div>
		<div class="content-scroll">
			<div class="component-scroll">
				<div class="create-db-container">
					<center class="error_center">
						<h4><?php echo lang('DataId', 'FastDB'); ?> <?php echo Request::get('id')->give() ?? $id; ?> <?php echo lang('NotFound', 'FastDB'); ?></h4>
					</center>
				</div>
			</div>
		</div>
	</div>
    
</main>

<?php echo e(View::theme('FastDB/Common/Footer')); ?>

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/error_other/not-found-data-id.blade.php ENDPATH**/ ?>