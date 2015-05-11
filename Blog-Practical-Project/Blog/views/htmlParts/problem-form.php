<div class="form-group">
    <label for="inputGrade" class="col-md-10 control-label">Клас</label>

    <select name="grade" id="inputGrade" class="form-control">
        <option <?= \Constants\Tools::selected($this->___data['grade'], 4) ?> value="4">4 клас</option>
        <option <?= \Constants\Tools::selected($this->___data['grade'], 5)?> value="5">5 клас</option>
        <option <?= \Constants\Tools::selected($this->___data['grade'], 6) ?> value="6">6 клас</option>
        <option <?= \Constants\Tools::selected($this->___data['grade'], 7) ?> value="7">7 клас</option>
        <option <?= \Constants\Tools::selected($this->___data['grade'], 8) ?> value="8">8 клас</option>
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
        <textarea name="condition" class="form-control" rows="7" id="textArea"><?= $this->___data['condition'] ?></textarea>
    </div>
</div>

<input name="csrf" type="hidden" value="<?= $this->___data['csrf'] ?>"/>
