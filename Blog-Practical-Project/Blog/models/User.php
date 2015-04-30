<?php
namespace Models;

use GFramework\ValidationRules;
use Constants\Codes;

class User extends BaseModel
{
    public $id;
    public  $username;
    public $password;
    public $confirmPassword;
    public $email;

    public function __construct($user = array())
    {
        parent::__construct();

        if (is_array($user)) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->password = $user['password'];
            $this->confirmPassword = $user['confirmPassword'];
            $this->email = $user['email'];
        } else {
            //TODO
            throw new \Exception("Invalid user's data'");
        }
    }

    public function validateUserData()
    {
        return $this->validator
            ->setRules(ValidationRules::ALPHA_NUM_DASH, $this->username, null, Codes::USERNAME . Codes::INVALID)
            ->setRules(ValidationRules::MIN_LENGTH, $this->username, 3, Codes::USERNAME . Codes::MIN_LENGTH)
            ->setRules(ValidationRules::MIN_LENGTH, $this->password, 5, Codes::PASSWORD . Codes::MIN_LENGTH)
            ->setRules(ValidationRules::MATCHES, $this->password, $this->confirmPassword, Codes::PASSWORD . Codes::NOT_MATCH)
            ->setRules(ValidationRules::EMAIL, $this->email, null, Codes::EMAIL . Codes::INVALID)
            ->validate();
    }
} 