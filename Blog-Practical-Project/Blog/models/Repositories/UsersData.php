<?php
namespace Models\Repositories;

use Models\User;
use Constants\Codes;

class UsersData extends DataDb
{
    /**
     * @param User $user
     * @return array|bool
     */
    public function register($user)
    {
        if ($this->hasUserInDb($user)) {
            return array('errors' => array(Codes::USERNAME . Codes::EXIST));
        }

        $subscriptionDate = date('Y-m-d');
        $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
        $this->db->prepare("INSERT INTO users(username, password, email, subscription_date) VALUES(?, ?, ?, ?)")
            ->execute(array($user->username, $hashedPassword, $user->email, $subscriptionDate));

        $userDb = $this->getUser($user);
        return $userDb;
    }

    public function hasUserInDb($user)
    {
        $res = $this->db->prepare("SELECT count(*) FROM users WHERE username = ?", array($user->username))
            ->execute()
            ->fetchRowNum()[0];
        return (bool)$res;
    }

    /**
     * @param User $user
     * @return User | null
     */
    public function getUser($user)
    {
        $result = $this->db->prepare("SELECT id, username, email, password, is_admin FROM users WHERE username = ?", array($user->username))
            ->execute()
            ->fetchRowAssoc();
        if($result){
            $userDb = new User($result);
            return $userDb;
        }

        return null;
    }
}