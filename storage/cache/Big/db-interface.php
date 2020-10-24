<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Настройки Интерфейса</span>
        </div>
        <div class="content-abs">
            <div class="menu-interface-site">
                <button class="btn active" dinamic-btn="menu">Меню</button>
                <button class="btn" dinamic-btn="content">Контент</button>
                <button class="btn" dinamic-btn="right-sitebar">Правый сайт-бар</button>
            </div>
            <div class="container-dinamic interface-settings-container">
                <div class="page-dinamic active" name-dinamic-page="menu">
                    <div>
                        <label for="">Показывать Иконки меню</label>
                        <input type="checkbox" class="on-off change-display-icon-menu">
                    </div>
                    <div>
                        <label for="">Показывать Текст меню</label>
                        <input type="checkbox" class="on-off change-display-text-menu">
                    </div>
                    <div>
                        <label for="">Размер Иконок <mark><span class="num-size-icon-menu">13</span>px</mark></label>
                        <input type="range" min="5" max="30" class="range-size-icon-menu">
                    </div>
                    <div>
                        <label for="">Размер Текста <mark><span class="num-size-text-menu">13</span>px</mark></label>
                        <input type="range" min="5" max="30" class="range-size-text-menu">
                    </div>
                </div>
                <div class="page-dinamic" name-dinamic-page="content">
                    <div>
                        <label for="">Показывать логотип</label>
                        <input type="checkbox" class="on-off display-logo">
                    </div>
                </div>
                <div class="page-dinamic" name-dinamic-page="right-sitebar">
                    <div>
                        <label for="">Показывать информацию подключения</label>
                        <input type="checkbox" class="on-off display-info-connect">
                    </div>
                    <div>
                        <label for="">Показывать кол-во памяти</label>
                        <input type="checkbox" class="on-off display-used-memory">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo \View::theme('footer'); ?>
