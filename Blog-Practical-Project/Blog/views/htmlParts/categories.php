<div class="container-fluid">
    <div class="row  margin-bottom-5">
        <div class="col-md-8 col-md-offset-2">
            <div class="row container-fluid">
                <ul class="nav nav-pills">
                    <li class="active">
                        <a href="/" class="btn btn-lg">Всички класове</a>
                    </li>
                    <li>
                        <a href="/categories/grade/4" class="btn btn-lg">4 клас</a>
                    </li>
                    <li>
                        <a href="/categories/grade/5" class="btn btn-lg">5 клас </a>
                    </li>
                    <li>
                        <a  href="/categories/grade/6"class="btn btn-lg">6 клас</a>
                    </li>
                    <li>
                        <a  href="/categories/grade/7"class="btn btn-lg">7 клас</a>
                    </li>
                    <li>
                        <a href="/categories/grade/8" class="btn btn-lg">8 клас</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-default col-md-8 col-md-offset-2 categories-box">
            <div class="panel-body">
                <div class="row">
                    <a href="/problems/all/<?= $this->___data['grade'] ?>" class="btn btn-info">Всички задачи</a>
                </div>
                <ul class="categories">
                    <?php foreach($this->___data['categories'] as $category) : ?>
                    <li>
                        <a href="/problems/category/<?= $category.'/'.$this->___data['grade']  ?>" ><?= $category ?></a>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</div>
