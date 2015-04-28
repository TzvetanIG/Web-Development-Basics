<?php

namespace Controllers;

use Models\User;
use Constants\Codes;

class Users extends BaseController{
    /**
     * @var \Models\User | null
     */
    private $user = null;

    public function __construct() {
        parent::__construct();
        $user = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'confirmPassword' => $this->input->post('confirmPassword'),
            'email' => $this->input->post('email')
        );

        if($this->input->hasPost('submit')){
            $this->user = new User($user);
        }
    }

    public function registration() {
        $this->redirectWhenUserIsLogged('/');
        if($this->user != null) {
            $errors = $this->user->register();
            if(is_array($errors)){
                $this->view->display('layouts.registration', $errors);
            } else {
                $this->session->username = $this->user->getUsername();
                $this->redirect("/users/login");
            }
        } else {
            $this->view->display('layouts.registration');
        }
    }

    public function login() {
        $this->redirectWhenUserIsLogged('/');
        if($this->user != null) {
            $password = $this->user->getPassword();
            if($password && password_verify($this->input->post('password'), $password)){
                $this->session->username = $this->user->getUsername();
                $this->redirect("/");
            } else {
                $errors = array('error' => array(Codes::USERNAME.Codes::PASSWORD.Codes::WRONG));
                $this->view->display('layouts.login', $errors);
            }
        } else {
            $this->view->display('layouts.login');
        }
    }

    public function logout(){
        $this->session->unsetSessionProperty('username');
        $this->redirectWhenUserIsNotLogged($_SERVER['HTTP_REFERER']);
    }
}