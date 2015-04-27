<?php

namespace Controllers;


class Users extends BaseController{

    public function registration() {
        $this->view->display('layouts.registration');
    }

    public function login() {
        $this->view->display('layouts.login');
    }
} 