<?php
namespace Controllers;


use Models\Repositories\Data;

class Categories extends BaseController
{
    // "/categories/grade/{$grade}"
    public function grade() {
        $grade = $this->input->get(0, 'int');
        $this->saveHistoryPath(0, $grade . ' клас');
        $categories = Data::categories()->getCategoryByGrade($grade);
        $data = array(
            'categories' => $categories,
            'grade' => $grade
        );

        $this->view->display('layouts.index', $data);
    }
}