<?php
namespace Models;

use GFramework\DB\SimpleDB;
use GFramework\Validation;
use GFramework\ValidationRules;
use Constants\Codes;

class User
{
    /**
     * @var SimpleDB
     */
    private $db;
    private $username;
    private $password;
    private $confirmPassword;
    private $email;
    /**
     * @var Validation
     */
    private $validator;

    public function __construct($user = array())
    {
        $this->validator = new Validation();
        $this->db = new SimpleDB();

        if (is_array($user)) {
            $this->username = $user['username'];
            $this->password = $user['password'];
            $this->confirmPassword = $user['confirmPassword'];
            $this->email = $user['email'];
        } else {
            //TODO
            throw new \Exception("Invalid $user's data'");
        }
    }

    public function register()
    {
        if ($this->validateUserData()) {
            if ($this->hasUserInDb()) {
                return array('error' => array(Codes::USERNAME.Codes::EXIST));
            }

            $subscriptionDate = date('Y-m-d');
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $this->db->prepare("INSERT INTO users(username, password, email, subscription_date) VALUES(?, ?, ?, ?)")
                ->execute(array($this->username, $hashedPassword, $this->email, $subscriptionDate));
            return true;
        } else {
            return array('error' => $this->validator->getErrors());
        }
    }

    public function hasUserInDb()
    {
        $res  = $this->db->prepare("SELECT count(*) FROM users WHERE username = ?", array($this->username))
            ->execute()
            ->fetchRowNum()[0];
        return (bool) $res;
    }

    public function getPassword()
    {
        $password  = $this->db->prepare("SELECT password FROM users WHERE username = ?", array($this->username))
            ->execute()
            ->fetchRowNum()[0];
        return $password;
    }

    private function validateUserData()
    {
        return $this->validator
            ->setRules(ValidationRules::ALPHA_NUM_DASH, $this->username, null, Codes::USERNAME . Codes::INVALID)
            ->setRules(ValidationRules::MIN_LENGTH, $this->username, 3, Codes::USERNAME . Codes::MIN_LENGTH)
            ->setRules(ValidationRules::MIN_LENGTH, $this->password, 5, Codes::PASSWORD . Codes::MIN_LENGTH)
            ->setRules(ValidationRules::MATCHES, $this->password, $this->confirmPassword, Codes::PASSWORD . Codes::NOT_MATCH)
            ->setRules(ValidationRules::EMAIL, $this->email, null, Codes::EMAIL . Codes::INVALID)
            ->validate();
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
} 