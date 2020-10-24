<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<?php echo \Assets::execute()->css('libs/selector'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Консоль</span>
        </div>
        <div class="content-abs">
            <?php echo \View::theme('flash'); ?>
            <button class="btn btn-success" style="font-size: 13px;margin-right: 0;">SHOW</button>
            <button class="btn btn-success" style="font-size: 13px;margin-right: 0;">EMBED</button>
            <button class="btn btn-success" style="font-size: 13px;margin-right: 0;">UPDATE</button>
            <button class="btn btn-success" style="font-size: 13px;margin-right: 0;">DELETE</button>
            <div contenteditable="true" style="height: 150px;" class="console-input">
            </div>
            <form action="">
                <input type="hidden" name="command">
                <button class="btn btn-info" style="font-size: 13px;">Выполнить</button>
            </form>
        </div>
    </div>
    
</div>

<?php echo \View::theme('footer'); ?>
