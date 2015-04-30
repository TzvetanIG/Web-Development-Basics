<?= $this->getLayoutData('startPage'); ?>
<?= $this->getLayoutData('header'); ?>
<?= $this->getLayoutData('menu'); ?>
    <a href="/">Начало</a> ->
    <a href="/problems/grade/<?= $this->___data[0]['class'] ?>">клас <?= $this->___data[0]['class'] ?></a>
<?= $this->getLayoutData('problem'); ?>
<?= $this->getLayoutData('endPage'); ?>