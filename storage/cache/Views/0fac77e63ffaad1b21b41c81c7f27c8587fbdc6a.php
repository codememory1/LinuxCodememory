<?php echo e(View::theme('FastDB.Common.Head')); ?>

<?php echo e(View::theme('FastDB.Default.Menu')); ?>


<main>

    <?php echo e(View::theme('FastDB.Default.SiteBarLeft')); ?>

    
    <div class="container-content">
        <div class="block-content-top">
            <h4>Загрузка таблицы</h4>
        </div>
        <div class="content-scroll" style="display: flex;">
            <dic class="component-scroll">
                <div class="content-list-table" style="width: 100%;">
                    <p>
                        Внимание! Файл таблицы должен иметь формат .fd
                    </p>
                    <hr>
                    <form id="form-import-table" enctype="multipart/form-data" action="<?php echo e(route('FastDB.import-table-handle', ['db' => $db])); ?>" method="post" form-ajax="true" data-redirect="<?php echo e(route('FastDB.list-table')); ?><?php echo e(Common::collectParameters(['db' => $db])); ?>">

                        <div class="info-loaded">
                            <label class="label-i-file" for="i-file-table">Выбрать</label>
                            <div class="text-loaded" style="display: flex;"><span style="padding: 0 10px;">Таблица не выбрана</span></div>
                        </div>

                        <input type="file" name="loaded-table[]" id="i-file-table" multiple>
                        <button class="prependDataTable left" >Загрузить TBL</button>
                    </form>
                </div>
            </dic>
        </div>
    </div>
</main>

<script>
    let invalidTableFormat = 'Формат таблицы неверный';
</script>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>

<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/import-table.blade.php ENDPATH**/ ?>