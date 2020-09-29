<nav aria-label="navigation">
    <ul class="pagination">
       
        <?php

            if($this->getCurrent() > 1)
            {
                ?>
                    <a class="page-item" href="?page=<?php echo $this->getCurrent() - 1; ?>"><li>Назад</li></a>
                <?
            }

            if($this->getCurrent() < $this->btn)
            {
                for($i = 1; $i <= $this->btn; $i++)
                {

                    if($this->getCurrent() == $i)
                    {
                        ?>
                            <a class="page-item active" href="?page=<?php echo $i; ?>"><li><?php echo $i; ?></li></a>
                        <?
                    }else {
                        ?>
                            <a class="page-item" href="?page=<?php echo $i; ?>"><li><?php echo $i; ?></li></a>
                        <?
                    }
                }
            }
        
            if($this->getCurrent() < $this->totalBtn())
            {
                ?>
                    <a class="page-item" href="?page=<?php echo $this->getCurrent() + 1; ?>"><li>Вперед</li></a>
                <?
            }

        ?>
        
    </ul>
</nav>


<style>
    
    .navigation {
        position: relative;
        width: 100%;
    }
    
    .pagination {
        display: flex;
    }
    
    .page-item {
        padding: 7px 10px;
        list-style-type: none;
        text-decoration: none;
        color: #007bff;
        background-color: #fff;
        border-top: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
        border-left: 1px solid #dee2e6;
        transition: background-color 0.5s;
    }
    
    .page-item.active {
        background: #007bff;
        color: #fff;
    }
    
    .page-item.active:hover {
        background-color: #3d95f4;
    }
    
    .page-item:hover {
        background-color: #f2f2f2;
    }
    
    .page-item:nth-child(1) {
        border-radius: 3px 0px 0px 3px;
        border-right: none;
    }
    
    .page-item:last-child {
        border-radius: 0px 3px 3px 0px;
        border-right: 1px solid #dee2e6;
    }
    
</style>