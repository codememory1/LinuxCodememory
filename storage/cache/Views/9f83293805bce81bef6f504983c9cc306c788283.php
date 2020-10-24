<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>

	<?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

   
    <div class="container-content">
        <div class="block-content-top">
            <h4>Создание базы данных</h4><br>
        </div>
        <div class="content-scroll">
        <?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

            <div class="component-scroll">
                <div class="create-db-container">
                    <form id="form-create-db" action="<?php echo e(route('FastDB.create-db-handle')); ?>" method="post">
                       	<input type="hidden" name="cdm_token" value="<?php echo e(protection_token()); ?>">
                        <label for="name-db">Название базы данных</label>
                        <input type="text" name="name-db" id="name-db" placeholder="Название базы данных"><br><br>
                        <label for="charset-db">Кодировка базы данных</label><br><br>
                        <div class="charset-db-div" style="width:191px;"></div><br>
                        <button class="btn">Создать</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>


<script type="text/javascript">
new Selector([{"name": "charset-db","add_as": "down","where": ".charset-db-div"}],[{<?php $i = 1;foreach(mb_list_encodings() as $charset){if($charset == 'UTF-8'){?>"0": {"value": "<?php echo $charset; ?>","value_show": "<?php echo $charset; ?>"},<?}else {?>"<?php echo $i++; ?>": {"value": "<?php echo $charset; ?>","value_show": "<?php echo $charset; ?>"},<?}}?>}]);
</script>
<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/create-db.blade.php ENDPATH**/ ?>