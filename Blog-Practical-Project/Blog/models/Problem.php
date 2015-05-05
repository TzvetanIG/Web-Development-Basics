<?php
namespace Models;

use GFramework\ValidationRules;
use Constants\Codes;

class Problem extends BaseModel
{
    public $id;
    public  $grade;
    public  $categories = array();
    public  $condition;
    public $solution;

    public function __construct($problem) {
        parent::__construct();

        if (is_array($problem)) {
            $this->grade = $problem['grade'];
            $this->categories = array_map(trim, array_filter(explode(',', $problem['categories'])));
            $this->condition = $problem['condition'];
            if(isset($problem['solution'])){
                $this->solution = $problem['solution'];
            }
        } else {
            throw new \Exception("Invalid problem's data'");
        }

    }

    public function validateProblemData()
    {
        return $this->validator
            ->setRules(ValidationRules::GREATER, $this->grade, 3, Codes::GRADE . Codes::REQUIRED)
            ->setRules(ValidationRules::GREATER, count($this->categories), 0, Codes::CATEGORIES . Codes::REQUIRED)
            ->setRules(ValidationRules::MIN_LENGTH, $this->condition, 1, Codes::CONDITION . Codes::REQUIRED)
            ->validate();
    }
} 