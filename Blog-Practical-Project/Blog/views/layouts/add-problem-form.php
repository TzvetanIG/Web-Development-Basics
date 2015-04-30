<?= $this->getLayoutData('startPage'); ?>
<?= $this->getLayoutData('header'); ?>
<?= $this->getLayoutData('menu'); ?>
    <div class="container">
        <?php if(isset($this->___data['errors'])){
            echo $this->getLayoutData('errors');
        } ?>

        <div class="row">
            <div class="col-md-8 col-md-offset-2 table-bordered">
                <form class="form-horizontal col-md-12" method="POST">
                    <fieldset>
                        <legend class="center">Добави задача</legend>
                         <div class="form-group">
                             <label for="inputGrade" class="col-md-10 control-label">Клас</label>

                            <?php
                                function selected($v1, $v2) {
                                    if($v1 === $v2){
                                        return 'selected';
                                    }

                                    return null;
                                }
                            ?>

                             <select name="grade" id="inputGrade" class="form-control">
                                <option <?= selected($this->___data['grade'], 4) ?> value="4">4 клас</option>
                                <option <?= selected($this->___data['grade'], 5)?> value="5">5 клас</option>
                                <option <?= selected($this->___data['grade'], 6) ?> value="6">6 клас</option>
                                <option <?= selected($this->___data['grade'], 7) ?> value="7">7 клас</option>
                                <option <?= selected($this->___data['grade'], 8) ?> value="8">8 клас</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputCategories" class="col-md-10 control-label">Въведи категории</label>

                            <div class="col-md-12">
                                <input name="categories" class="form-control" id="inputCategories" placeholder="Въведи категории разделени със запетая"
                                   value="<?= $this->___data['categories'] ?>"    type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="textArea"  class="col-md-12 control-label">Условие на задачата</label>
                            <div class="col-md-12">
                                <textarea name="condition" class="form-control" rows="7" id="textArea"></textarea>
                                <script defer>
                                    document.getElementsByName('condition')[0].innerHTML = '<?= $this->___data['condition'] ?>';
                                </script>
                           </div>
                        </div>

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