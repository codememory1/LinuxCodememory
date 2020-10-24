<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<?php ($structure = (count($dataTable) > 0) ? implode(',', $dataTable['data'][0][0]) : null) ?>

<main>
    
    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Консоль</h4>
        </div>

        <div class="content-scroll">
            <div class="component-scroll">
                <div class="content-list-table" style="width: 100%;">
					<form>
						<div class="color-code" spellcheck="false" contenteditable="true" style="background:#fff;outline:none;height:150px;padding:25px 25px;white-space: pre;overflow: auto;"></div>
						<input type="hidden" name="console" id="console-input">
						<button result-ajax=".color-code" method-ajax="POST" url-ajax="<?php echo e(route('FastDB.console-handle')); ?>?dbname=<?php echo e(Request::get('dbname')); ?>" style="position: absolute;right: 15px;" class="button-info" id="exe-command">EXECUTE COMMAND</button>
					</form>
               		<span class="add-command button-success" command="SHOW" search-replace="%table" replace="<?php echo e(Request::get('table')); ?>">SHOW</span>
               		<span class="add-command button-success" command="WRITE" search-replace="%table&%fields&%values" replace="<?php echo e(Request::get('table')); ?>&<?php echo e($structure); ?>">WRITE</span>
               		<span class="add-command button-success" command="UPDATE" search-replace="%table&%fields&%values" replace="<?php echo e(Request::get('table')); ?>&<?php echo e($structure); ?>">UPDATE</span>
               		<span class="add-command button-success" command="DELETE" search-replace="%table" replace="<?php echo e(Request::get('table')); ?>">DELETE</span>
               		<span class="add-command button-success" command="COUNT" search-replace="%table" replace="<?php echo e(Request::get('table')); ?>">COUNT</span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/console.blade.php ENDPATH**/ ?>