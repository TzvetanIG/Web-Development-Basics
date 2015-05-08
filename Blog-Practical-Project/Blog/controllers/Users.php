<?php

namespace Controllers;

use Models\Repositories\Data;
use Models\Repositories\UsersData;
use Models\User;
use Constants\Codes;

class Users extends BaseController
{
    /**
     * @var \Models\User | null
     */
    private $user = null;

    public function __construct()
    {
        parent::__construct();
        $user = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'confirmPassword' => $this->input->post('confirmPassword'),
            'email' => $this->input->post('email')
        );

        $this->addViewData($user);

        if ($this->input->hasPost('submit')) {
            $this->user = new User($user);
        }
    }

    // "/user/registration"
    public function registration()
    {
        $this->redirectWhenUserIsLogged($this->getLastHistoryPath());

        if ($this->user != null) {
            if ($this->user->validateUserData()) {
                $user = Data::users()->register($this->user);
                if (is_array($user)) {
                    $this->addViewData($user);
                } else {
                    $this->setUserSession($user);
                    $this->redirect($this->getLastHistoryPath());
                }
            } else {
                $user = array('errors' => $this->user->validator->getErrors());
                $this->addViewData($user);
            }
        }

        $this->view->display('layouts.registration', $this->viewData);
    }


    // "/user/login"
    public function login()
    {
        $this->redirectWhenUserIsLogged($this->getLastHistoryPath());

        if ($this->user != null) {
            $userDb = Data::users()->getUser($this->user);
            if ($userDb && password_verify($this->input->post('password'), $userDb->password)) {
                $this->setUserSession($userDb);
                $this->redirect($this->getLastHistoryPath());
            } else {
                $errors = array('errors' => array(Codes::USERNAME . Codes::PASSWORD . Codes::WRONG));
                $this->addViewData($errors);
            }
        }

        $this->view->display('layouts.login', $this->viewData);
    }


    // "/user/logout"
    public function logout()
    {
        $this->unsetUserSession();
        $this->redirectWhenUserIsNotLogged($this->getLastHistoryPath());
    }


    //// "/user/problems"
    public function problems()
    {
        $this->redirectWhenUserIsNotLogged($this->getLastHistoryPath());
        $this->saveHistoryPath(2, 'Качени задачи');

        $page = $this->viewData['page'];
        $userId = $this->session->userId;
        $problems = Data::problems()->getProblemsByUser($userId, $page);

        $this->addViewData(array('maxPage' => $this->getMaxPage($problems['maxCount'])));
        unset($problems['maxCount']);
        $this->addViewData(array('problems' => $problems));

        $this->view->display('layouts.problems-page', $this->viewData);
    }


    private function setUserSession($user)
    {
        $this->session->username = $user->username;
        $this->session->email = $user->email;
        $this->session->userId = $user->id;
        $this->session->isAdmin = (bool)$user->isAdmin;
    }


    private function unsetUserSession()
    {
        $this->session->unsetSessionProperty('username');
        $this->session->unsetSessionProperty('email');
        $this->session->unsetSessionProperty('id');
        $this->session->unsetSessionProperty('isAdmin');
    }
}