<?php

namespace Models\Repositories;

use GFramework\App;
use Models\Problem;

class ProblemsData extends DataDb
{
    /**
     * @param $problem
     * @return string Returned id of problem
     * @throws \Exception
     */
    public function addProblem($problem)
    {
        $userId = App::getInstance()->getSession()->userId;
        if (!isset($userId)) {
            throw new \Exception('User is not logged', 500);
        }

        $publishDate = date('Y-m-d');
        $this->db->prepare('INSERT INTO tasks (`class`, `condition`, `publish_date`, `user_id`) VALUES (?, ?, ?, ?)')
            ->execute(array($problem->grade, $problem->condition, $publishDate, $userId));

        return $this->db->getLastInsertId();
    }

    public function getProblemsByUser($userId)
    {
        $problems = $this->db->prepare('SELECT id, `condition`, class, publish_date
                FROM tasks WHERE user_id = ?
                ORDER BY publish_date DESC, id')
            ->execute(array($userId))
            ->fetchAllAssoc();

        $problems = $this->addCategoriesToProblems($problems);
        return $problems;
    }

    public function getProblemsByGrade($grade)
    {
        $problems = $this->db->prepare('SELECT id, `condition`, class, publish_date
                FROM tasks WHERE class = ?
                ORDER BY publish_date DESC, id')
            ->execute(array($grade))
            ->fetchAllAssoc();

        $problems = $this->addCategoriesToProblems($problems);
        return $problems;
    }

    private function addCategoriesToProblems($problems) {
        $problemsWithCategories = array();
        foreach($problems as $problem) {
            $categories = Data::categories()->getCategoriesOfProblem($problem['id']);
            $problem['categories'] = $categories;
            $problemsWithCategories[] = $problem;
        }

        return $problemsWithCategories;
    }
}