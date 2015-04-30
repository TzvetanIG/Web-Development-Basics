<?php

namespace Controllers;

use Models\Repositories\Data;
use Models\Repositories\UsersData;
use Models\User;
use Constants\Codes;

class Users extends BaseController{

    private $usersData = null;
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

        $this->addViewData($user);

        if($this->input->hasPost('submit')){
            $this->user = new User($user);
            $this->usersData = new UsersData();
        }
    }

    public function registration() {
        $this->redirectWhenUserIsLogged('/');
        if($this->user != null) {
            if($this->user->validateUserData()){
                $errors = $this->usersData->register($this->user);
                if(is_array($errors)){
                    $this->addViewData($errors);
                } else {
                    $this->setUserSession();
                    $this->redirect("/users/login");
                }
            } else {
                $errors = array('errors' => $this->user->validator->getErrors());
                $this->addViewData($errors);
            }
        }

        $this->view->display('layouts.registration', $this->viewData);
    }

    public function login() {
        $this->redirectWhenUserIsLogged('/');
        if($this->user != null) {
            $userDb = $this->usersData->getUser($this->user);
            if($userDb && password_verify($this->input->post('password'), $userDb->password)){
                $this->setUserSession($userDb);
                $this->redirect("/");
            } else {
                $errors = array('errors' => array(Codes::USERNAME.Codes::PASSWORD.Codes::WRONG));
                $this->addViewData($errors);
            }
        }

        $this->view->display('layouts.login', $this->viewData);
    }

    public function logout(){
        $this->unsetUserSession();
        $this->redirectWhenUserIsNotLogged($_SERVER['HTTP_REFERER']);
    }

    public function problems()
    {
        $userId = $this->session->userId;
        $problems = Data::problems()->getProblemsByUser($userId);
        $this->view->display('layouts.problems-page', $problems);
    }

    private function setUserSession($user){
        $this->session->username = $user->username;
        $this->session->email = $user->email;
        $this->session->userId = $user->id;
    }

    private function unsetUserSession(){
        $this->session->unsetSessionProperty('username');
        $this->session->unsetSessionProperty('email');
        $this->session->unsetSessionProperty('id');
    }


}