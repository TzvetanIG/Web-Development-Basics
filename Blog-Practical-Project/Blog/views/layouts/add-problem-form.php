<?= $this->getLayoutData('startPage'); ?>
<?= $this->getLayoutData('header'); ?>
<?= $this->getLayoutData('menu'); ?>
<?= $this->getLayoutData('history'); ?>
    <div class="container">
        <?php if(isset($this->___data['errors'])){
            echo $this->getLayoutData('errors');
        } ?>

        <div class="row">
            <div class="col-md-8 col-md-offset-2 table-bordered">
                <form class="form-horizontal col-md-12" method="POST">
                    <fieldset>
                        <legend class="center">Добави задача</legend>

                        <?= $this->getLayoutData('problem-form'); ?>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button name="submit" type="submit" class="btn btn-primary">Добави задачата</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
<?= $this->getLayoutData('endPage'); ?>