<?php echo \View::theme('header'); ?>
<?php echo \View::theme('menu'); ?>

<div class="basic-content grid">
    <?php echo \View::theme('sitebars'); ?>

    <div class="content-center">
        <div class="title-content">
            <span>Дполнительная Память</span>
        </div>
        <div class="content-abs">
            <div class="container-card grid">
                <div class="card">
                    <h6>Дополнительно:</h6>
                    <span class="status-memory-bye"></span>
                    <span class="num-memory">100 MB</span>
                    <span class="price-memory">
                        Цена: <span class="price">400 <i class="fas fa-ruble-sign"></i></span>
                    </span>
                    <a href="" class="btn btn-success btn-bye-memory">Купить</a>
                </div>
                <div class="card">
                    <span class="status-memory-bye">
                        <i class="check-mark-bye-memory far fa-check"></i>
                    </span>
                    <h6>Дополнительно:</h6>
                    <span class="num-memory">300 MB</span>
                    <span class="price-memory">
                        Цена: <span class="price">800 <i class="fas fa-ruble-sign"></i></span>
                    </span>
                    <a href="" class="btn btn-gray btn-bye-memory disabled" disabled="disabled">Куплено</a>
                </div>
                <div class="card">
                    <h6>Дополнительно:</h6>
                    <span class="status-memory-bye"></span>
                    <span class="num-memory">600 MB</span>
                    <span class="price-memory">
                        Цена: <span class="price">1300 <i class="fas fa-ruble-sign"></i></span>
                    </span>
                    <a href="" class="btn btn-success btn-bye-memory">Купить</a>
                </div>
                <div class="card">
                    <h6>Дополнительно:</h6>
                    <span class="status-memory-bye"></span>
                    <span class="num-memory">1.2 GB</span>
                    <span class="price-memory">
                        Цена: <span class="price">2800 <i class="fas fa-ruble-sign"></i></span>
                    </span>
                    <a href="" class="btn btn-success btn-bye-memory">Купить</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo \View::theme('footer'); ?>
