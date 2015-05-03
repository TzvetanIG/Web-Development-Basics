<div class="container">
<?php foreach ($this->___data['problems'] as $problem): ?>
    <div class="row">
        <div class="col-md-12 problem">
            <?php if(\GFramework\App::getInstance()->getSession()->isAdmin): ?>
            <div class="row padding8">
                <div class="col-md-2">
                    <label>
                        <input id="<?= $problem['id'] ?>" type="checkbox" <?= \Constants\Tools::checked($problem['is_visible']) ?>> Покажи задачата
                    </label>
                </div>
                <div class="col-md-10 text-right">
                    <a href="/problems/edit/<?= $problem['id'] ?>" class="btn btn-primary btn-sm">Редактиране</a>
                    <a href="/problems/delete/<?= $problem['id'] ?>" class="btn btn-primary btn-sm">Изтриване</a>
                </div>
            </div>
            <?php endif ?>
            <div class="row padding8 italic">
                <div class="col-md-2 col-md-offset-1">Задача <?= $problem['id'] ?></div>
                <div class="col-md-9 text-right">
                    <span>Категория:</span>
                    <?php
                        $length = count($problem['categories']);
                        for($i = 0; $i < $length - 1; $i++):
                            //TODO href category link
                    ?>
                        <a href="/problems/category/<?= $problem['categories'][$i] . '/' . $problem['class']  ?>"><?= $problem['categories'][$i].', ' ?></a>
                    <?php endfor ?>
                    <a href="/problems/category/<?= $problem['categories'][$length - 1] . '/' . $problem['class'] ?>"><?= $problem['categories'][$length - 1] ?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1 text-right italic"><?= $problem['class'] ?> клас</div>
                <div class="col-md-11 condition">
                    <?= $problem['condition'] ?>
                </div>
            </div>
            <div class="row padding8 italic">
                <div class="col-md-11 col-md-offset-1 right">Публикувана на: <?= $problem['publish_date'] ?></div>
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>