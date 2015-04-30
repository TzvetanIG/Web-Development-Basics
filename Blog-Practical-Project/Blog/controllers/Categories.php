<?php
namespace Controllers;


use Models\Repositories\Data;

class Categories extends BaseController
{
    public function grade() {
        $grade = $this->input->get(0, 'int');
        $categories = Data::categories()->getCategoryByGrade($grade);
        $data = array(
            'categories' => $categories,
            'grade' => $grade
        );

        $this->view->display('layouts.index', $data);

    }
}