<?php
namespace Controllers;


use Models\Problem;
use Models\Repositories\Data;
use Models\Repositories\ProblemsData;

class Problems extends BaseController
{
    private $problem = null;

    public function __construct()
    {
        parent::__construct();

        $problem = array(
            'grade' => $this->input->post('grade', 'int'),
            'categories' => $this->input->post('categories'),
            'condition' => trim($this->input->post('condition')),
        );

        $this->addViewData($problem);

        if ($this->input->hasPost('submit')) {
            $this->problem = new Problem($problem);
        }
    }

    public function add()
    {
        $this->redirectWhenUserIsNotLogged('/');
        if ($this->problem != null) {
            if ($this->problem->validateProblemData()) {
                $problemId = Data::problems()->addProblem($this->problem);
                foreach($this->problem->categories as $category) {
                    $categoryId = Data::categories()->add($category);
                    Data::categories()->addProblemToCategory($categoryId, $problemId);
                }

                //TODO Re
                $this->redirect($_SERVER['HTTP_REFERER']);
             } else {
                $errors  =  array('errors' => $this->problem->validator->getErrors());
                $this->addViewData($errors);
            }
        }

        $this->view->display('layouts.add-problem-form', $this->viewData);
    }


} 