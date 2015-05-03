<?php
namespace Controllers;


use Models\Problem;
use Models\Repositories\Data;

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
            'solution' => $this->input->post('solution')
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
                foreach ($this->problem->categories as $category) {
                    $categoryId = Data::categories()->add($category);
                    Data::categories()->addProblemToCategory($categoryId, $problemId);
                }
                $this->redirect($this->session->refererPage);
            } else {
                $errors = array('errors' => $this->problem->validator->getErrors());
                $this->addViewData($errors);
            }
        }

        $this->view->display('layouts.add-problem-form', $this->viewData);
    }

    public function category()
    {
        $category = $this->input->get(0, 'string', 'all');
        $grade = $this->input->get(1, 'int', 'all');
        $page = $this->viewData['page'];
        $isShowAll = $this->session->isAdmin;

        if ($category == 'all') {
            if ($grade == 'all') {
                $problems = Data::problems()->getAllProblems($page, $isShowAll);
            } else {
                $problems = Data::problems()->getProblemsByGrade($grade, $page, $isShowAll);
            }
        } else {
            if ($grade == 'all') {
                $problems = Data::problems()->getProblemsByCategory($category, $page, $isShowAll);
            } else {
                $problems = Data::problems()->getProblemsByGradeAndCategory($grade, $category, $page, $isShowAll);
            }
        }

        $this->addViewData(array('maxPage' => $this->getMaxPage($problems['maxCount'])));
        unset($problems['maxCount']);
        $this->addViewData(array('problems' => $problems));

        $this->view->display('layouts.problems-page', $this->viewData);
    }


    public function edit()
    {
        $problemId = $this->input->get(0, 'int');
        if (!$problemId || !$this->session->isAdmin) {
            $this->redirect('/');
        }

        if ($this->problem != null) {
            $this->problem->id = $problemId;
            Data::problems()->updateProblem($this->problem);
            Data::categories()->deleteCategoriesOfProblem($problemId);
            foreach ($this->problem->categories as $category) {
                $categoryId = Data::categories()->add($category);
                Data::categories()->addProblemToCategory($categoryId, $problemId);
            }

            $this->redirect('/');
        }

        $problem = Data::problems()->getProblemById($problemId);
        $data = array(
            'grade' => $problem['class'],
            'categories' => implode(', ', $problem['categories']),
            'condition' => $problem['condition'],
            'solution' => $problem['solution']
        );

        $this->view->display('layouts.edit-problem-form', $data);
    }


    public function delete()
    {
        $problemId = $this->input->get(0, 'int');
        if (!$problemId || !$this->session->isAdmin) {
            $this->redirect($this->session->refererPage);
        }

        if ($this->input->hasPost('delete') || $this->input->hasPost('cancel')) {

            if ($this->input->hasPost('delete')) {
                Data::problems()->delete($problemId);
            }

            $this->redirect($this->session->refererPage);
            $this->session->unsetSessionProperty('refererPage');
        }

        $data = array('id' => $problemId);
        $this->view->display('layouts.confirm-delete-form', $data);
    }
}