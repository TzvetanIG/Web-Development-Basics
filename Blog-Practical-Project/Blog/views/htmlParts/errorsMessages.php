<div class="row">
    <div class="col-md-6 col-md-offset-3 table-bordered error">
        <?php
        $messages = \GFramework\App::getInstance()->getConfig()->errors;
        foreach($this->___data['errors'] as $v) {
            ?>
            <div><?php echo $messages[$v] ?></div>
        <?php } ?>
    </div>
</div>