<?php
$page = $this->___data['page'];
$maxPage = $this->___data['maxPage'];
$url = explode('page/', $_SERVER['PATH_INFO'])[0] . '/page/';
$previousPage = ($page - 1) < 1 ? 1 : $page - 1;
$nextPage = ($page + 1) > 1 ? $maxPage : $page + 1;
?>
<?php if($this->___data['maxPage']) : ?>
<div class="container  text-center">
    <ul class="pagination pagination-lg">
        <li><a href="<?= $url . $previousPage ?>">«</a></li>
        <?php for ($i = 1; $i <= $maxPage; $i++): ?>
            <li class="<?= Constants\Tools::active($page, $i) ?>"><a href="<?= $url . $i ?>"><?= $i ?></a></li>
        <?php endfor ?>
        <li><a href="<?= $nextPage ?>">»</a></li>
    </ul>
</div>
<?php endif ?>