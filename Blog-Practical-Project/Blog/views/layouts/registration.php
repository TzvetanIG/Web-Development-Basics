<?= $this->getLayoutData('startPage'); ?>
<?= $this->getLayoutData('header'); ?>
<?= $this->getLayoutData('menu'); ?>
    <div class="container">
        <?php if(isset($this->___data['errors'])){
           echo $this->getLayoutData('errors');
        } ?>

        <div class="row">
            <div class="col-md-4 col-md-offset-4 table-bordered">
                <form class="form-horizontal col-md-12" method="POST">
                    <fieldset>
                        <legend class="center">Регистрация</legend>
                        <div class="form-group">
                            <label for="inputUsername" class="col-md-10 control-label">Потребителско име</label>

                            <div class="col-md-12">
                                <input name="username" class="form-control" id="inputUsername" placeholder="Потребителско име"
                                       type="text" value="<?= $this->___data['username'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail" class="col-md-10 control-label">Email</label>

                            <div class="col-md-12">
                                <input name="email" class="form-control" id="inputEmail" placeholder="Email" type="email"
                                       value="<?= $this->___data['email'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  for="inputPassword" class="col-md-10 control-label">Парола</label>

                            <div class="col-md-12">
                                <input name="password" class="form-control" id="inputPassword" placeholder="Парола" type="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputConfirmPassword" class="col-md-10 control-label">Повтори паролата</label>

                            <div class="col-md-12">
                                <input name="confirmPassword" class="form-control" id="inputConfirmPassword" placeholder="Повтори паролата" type="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button name="submit" type="submit" class="btn btn-primary">Регистрация</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
<?= $this->getLayoutData('endPage'); ?>