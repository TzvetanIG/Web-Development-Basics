<?php if(\GFramework\App::getInstance()->getSession()->isAdmin) : ?>
    <div class="form-group">
        <label for="textArea"  class="col-md-12 control-label">Решение</label>
        <div class="col-md-12">
            <textarea name="solution" class="form-control" rows="7" id="textArea"><?= $this->___data['solution'] ?></textarea>
        </div>
    </div>
<?php endif ?>