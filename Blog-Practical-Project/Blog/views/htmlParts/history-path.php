<?php
$history = \GFramework\App::getInstance()->getSession()->history;
if (isset($history)):
    ?>
    <div class="container">
        <div class="row">
            <?php
            foreach ($history as $link) : ?>
                <a href="<?= $link['path'] ?>" class="btn btn-primary btn-sm"><?= $link['key'] ?></a>
            <?php endforeach ?>
        </div>
        <hr>
    </div>
<?php endif ?>
