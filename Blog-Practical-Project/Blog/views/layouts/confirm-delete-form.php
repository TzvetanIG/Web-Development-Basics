<?= $this->getLayoutData('startPage'); ?>
<?= $this->getLayoutData('header'); ?>
<?= $this->getLayoutData('menu'); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 table-bordered">
            <form class="form-horizontal col-md-12" method="POST">
                <fieldset>
                    <div class="form-group">
                        <div>Искате ли да изтриете задача <?= $this->___data['id'] ?>?</div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button name="cancel" type="submit" class="btn btn-default">Отказ</button>
                            <button name="delete" type="submit" class="btn btn-primary">Изтрий</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    </div>
<?= $this->getLayoutData('endPage'); ?>