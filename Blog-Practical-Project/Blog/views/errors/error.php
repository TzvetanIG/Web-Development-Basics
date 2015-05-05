<?php
$this->appendLayout('startPage', 'htmlParts.startHTML');
$this->appendLayout('endPage', 'htmlParts.endHTML');
$this->appendLayout('header', 'htmlParts.header');
$this->appendLayout('menu', 'htmlParts.menu');
$this->display('errors.404');

