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
            'categories' => $this->input->post('categories', 'xss'),
            'condition' => trim($this->input->post('condition', 'xss')),
            'solution' => $this->input->post('solution', 'xss')
        );

        $this->addViewData($problem);

        if ($this->input->hasPost('submit')) {
            $this->problem = new Problem($problem);
        }
    }


    public function add()
    {
        $this->redirectWhenUserIsNotLogged('/user/login');
        $this->saveHistoryPath(2, 'Добави задача');
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
        $category = $this->input->get(0, 'xss|string', 'all');
        $grade = $this->input->get(1, 'int', 'all');
        $page = $this->viewData['page'];
        $isShowAll = $this->session->isAdmin;


        if ($category == 'all') {
            if ($grade == 'all') {
                $problems = Data::problems()->getAllProblems($page, $isShowAll);
            } else {
                $problems = Data::problems()->getProblemsByGrade($grade, $page, $isShowAll);
            }

            $this->saveHistoryPath(1, 'Всички категории');
        } else {
            if ($grade == 'all') {
                $problems = Data::problems()->getProblemsByCategory($category, $page, $isShowAll);
            } else {
                $problems = Data::problems()->getProblemsByGradeAndCategory($grade, $category, $page, $isShowAll);
            }

            $this->saveHistoryPath(1, $category);
        }


        $this->addViewData(array('maxPage' => $this->getMaxPage($problems['maxCount'])));
        unset($problems['maxCount']);
        $this->addViewData(array('problems' => $problems));

        $this->view->display('layouts.problems-page', $this->viewData);
    }


    public function edit()
    {
        $this->redirectWhenUserIsNotLogged('/user/login');
        $problemId = $this->getProblemId();
        $this->saveHistoryPath(2, 'Редактиране на задача ' . $problemId);

        if ($this->problem != null) {
            $this->problem->id = $problemId;
            Data::problems()->updateProblem($this->problem);
            Data::categories()->deleteCategoriesOfProblem($problemId);
            foreach ($this->problem->categories as $category) {
                $categoryId = Data::categories()->add($category);
                Data::categories()->addProblemToCategory($categoryId, $problemId);
            }

            $this->redirect($this->getHistoryPathByPosition(1));
        }

        $problem = Data::problems()->getProblemById($problemId);
        $data = array(
            'id' => $problemId,
            'grade' => $problem['class'],
            'categories' => implode(', ', $problem['categories']),
            'condition' => $problem['condition'],
            'solution' => $problem['solution']
        );

        $this->view->display('layouts.edit-problem-form', $data);
    }


    public function delete()
    {
        $this->redirectWhenUserIsNotLogged('/user/login');
        $problemId = $this->getProblemId();

        if ($this->input->hasPost('delete') || $this->input->hasPost('cancel')) {

            if ($this->input->hasPost('delete')) {
                Data::problems()->delete($problemId);
                Data::categories()->deleteEmptyCategories();
            }

            $this->redirect($this->getLastHistoryPath());
        }

        $data = array('id' => $problemId);
        $this->view->display('layouts.confirm-delete-form', $data);
    }


    public function solution()
    {
        $this->redirectWhenUserIsNotLogged('/user/login');

        $problemId = $this->input->get(0, 'int');
        $this->saveHistoryPath(3, 'Задача ' . $problemId);
        if (!$problemId) {
            $this->redirect($this->getLastHistoryPath());
        }

        $problem = Data::problems()->getProblemById($problemId);

        $data = array('0' => $problem);
        $data = array(
            'problems' => $data,
            'hide' => 1
        );

        $this->view->display('layouts.problem-with-solution', $data);
    }


    public function toggleVisibility()
    {
        $problemId = $this->input->get(0, 'int');
        if ($problemId && $this->session->isAdmin) {
            Data::problems()->toggleVisibility($problemId);
        } else {
            throw new \Exception("Invalid id or you not admin", 500);
        }
    }

    private function getProblemId()
    {
        $problemId = $this->input->get(0, 'int');
        if (!$problemId || !$this->session->isAdmin) {
            $this->redirect($this->getLastHistoryPath());
        }

        return $problemId;
    }
}