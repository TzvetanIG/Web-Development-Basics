<div class="container">
<?php foreach ($this->___data as $problem): ?>
    <div class="row">
        <div class="col-md-12 problem">
            <div class="row padding8">
                <div class="col-md-10 col-md-offset-2 right">
                    <span>Категория:</span>
                    <?php
                        $length = count($problem['categories']);
                        for($i = 0; $i < $length - 1; $i++):
                            //TODO href category link
                    ?>
                        <a href="#"><?= $problem['categories'][0].', ' ?></a>
                    <?php endfor ?>
                    <a href="#"><?= $problem['categories'][$length - 1] ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 right">Задача <?= $problem['id'] ?></div>
                <div class="col-md-10 condition">
                    <?= $problem['condition'] ?>
                </div>
            </div>
            <div class="row padding8">
                <div class="col-md-10 col-md-offset-2 right">Публикувана на: <?= $problem['publish_date'] ?></div>
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>