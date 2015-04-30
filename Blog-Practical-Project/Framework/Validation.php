<?php
namespace GFramework;

class Validation
{
    private $rules = array();
    private $errors;

    public function setRules($rule, $value, $params = null, $name = null) {
        $this->rules[] = array('value' => $value, 'rule' => $rule, 'params' => $params, 'name' => $name);
        return $this;
    }

    public  function validate() {
        $this->errors  = array();
        if(count($this->rules) > 0){
           foreach($this->rules as $v) {
               if(!$this->$v['rule']($v['value'], $v['params'])){
                   if($v['name']){
                       $this->errors[] = $v['name'];
                   } else {
                       $this->errors[] = $v['rule'];
                   }
               }
           }
        }

        return (bool) !count($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function __call($a, $b) {
        throw new \Exception('Invalid validation rule', 500);
    }

    public static function required($val) {
        if (is_array($val)) {
            return !empty($val);
        } else {
            return $val != '';
        }
    }

    public static function matches($val1, $val2) {
        return $val1 == $val2;
    }

    public static function matchesStrict($val1, $val2) {
        return $val1 === $val2;
    }

    public static function different($val1, $val2) {
        return $val1 != $val2;
    }

    public static function differentStrict($val1, $val2) {
        return $val1 !== $val2;
    }

    public static function minLength($val1, $val2) {
        return (mb_strlen($val1) >= $val2);
    }

    public static function maxLength($val1, $val2) {
        return (mb_strlen($val1) <= $val2);
    }

    public static function exactLength($val1, $val2) {
        return (mb_strlen($val1) == $val2);
    }

    public static function isGreater($val1, $val2) {
        return ($val1 > $val2);
    }

    public static function isLower($val1, $val2) {
        return ($val1 < $val2);
    }

    public static function isAlpha($val1) {
        return (bool) preg_match('/^([a-z])+$/i', $val1);
    }

    public static function isAlphaAndNum($val1) {
        return (bool) preg_match('/^([a-z0-9])+$/i', $val1);
    }

    public static function isAlphaAndNumAndDash($val1) {
        return (bool) preg_match('/^([-a-z0-9_-])+$/i', $val1);
    }

    public static function isNumeric($val1) {
        return is_numeric($val1);
    }

    public static function isEmail($val1) {
        return filter_var($val1, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function emails($val1) {
        if (is_array($val1)) {
            foreach ($val1 as $v) {
                if (!self::isEmail($val1)) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public static function isUrl($val1) {
        return filter_var($val1, FILTER_VALIDATE_URL) !== false;
    }

    public static function isIp($val1) {
        return filter_var($val1, FILTER_VALIDATE_IP) !== false;
    }

    public static function regexp($val1, $val2) {
        return (bool) preg_match($val2, $val1);
    }

    public static function custom($val1, $val2) {
        if ($val2 instanceof \Closure) {
            return (boolean) call_user_func($val2, $val1);
        } else {
            throw new \Exception('Invalid validation function', 500);
        }
    }
} 