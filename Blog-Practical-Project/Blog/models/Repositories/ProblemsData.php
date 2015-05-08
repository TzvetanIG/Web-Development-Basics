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

        $publishDate = date('Y-m-d G:i:s');
        $this->db->prepare('INSERT INTO tasks (`class`, `condition`, `publish_date`, `user_id`) VALUES (?, ?, ?, ?)')
            ->execute(array($problem->grade, $problem->condition, $publishDate, $userId));

        return $this->db->getLastInsertId();
    }


    public function getProblemsByUser($userId, $page)
    {
        $problems = $this->db->prepare('SELECT id, `condition`, class, publish_date, solution
                FROM tasks WHERE user_id = ?
                ORDER BY publish_date DESC, id
                LIMIT ?, ?')
            ->execute(array($userId, $this->firstElementOfPage($page), $this->pageSize))
            ->fetchAllAssoc();

        $problems = $this->addCategoriesToProblems($problems);
        $problems['maxCount'] = $this->problemsByUserCount($userId);
        return $problems;
    }


    public function getAllProblems($page, $isShowAll = false)
    {
        if ($isShowAll) {
            $supplement = '';
        } else {
            $supplement = 'WHERE is_visible = 1';
        }

        $statement = $this->db->prepare("SELECT id, `condition`, class, publish_date, is_visible, solution
                FROM tasks
                $supplement
                ORDER BY publish_date DESC, id DESC
                LIMIT ?, ?");

        $statement = $statement->execute(array($this->firstElementOfPage($page), $this->pageSize));

        $problems = $statement->fetchAllAssoc();
        $problems = $this->addCategoriesToProblems($problems);
        $problems['maxCount'] = $this->problemsCount($supplement);
        return $problems;
    }

    public function getProblemsByGrade($grade, $page, $isShowAll = false)
    {
        if ($isShowAll) {
            $supplement = '';
        } else {
            $supplement = 'AND is_visible = 1';
        }

        $statement = $this->db->prepare("SELECT id, `condition`, class, publish_date, is_visible, solution
                FROM tasks WHERE class = ? $supplement
                ORDER BY publish_date DESC, id DESC
                LIMIT ?, ?");

        $statement = $statement->execute(array($grade, $this->firstElementOfPage($page), $this->pageSize));

        $problems = $statement->fetchAllAssoc();
        $problems = $this->addCategoriesToProblems($problems);
        $problems['maxCount'] = $this->problemsByGradeCount($grade, $supplement);
        return $problems;
    }


    public function getProblemsByCategory($category, $page, $isShowAll = true)
    {
        if ($isShowAll) {
            $supplement = '';
        } else {
            $supplement = 'AND is_visible = 1';
        }

        $problems = $this->db->prepare("SELECT t.id, t.`condition`, t.class, t.publish_date, is_visible, solution
                FROM tasks t
	              JOIN tasks_categories tc on tc.task_id = t.id
	              JOIN categories c ON c.id = tc.category_id
                WHERE c.name LIKE ? $supplement
                ORDER BY publish_date DESC, id DESC
                LIMIT ?, ?")
            ->execute(array('%'.$category.'%', $this->firstElementOfPage($page), $this->pageSize))
            ->fetchAllAssoc();

        $problems = $this->addCategoriesToProblems($problems);
        $problems['maxCount'] = $this->problemsByCategoryCount($category, $supplement);
        return $problems;
    }


    public function getProblemsByGradeAndCategory($grade, $category, $page, $isShowAll = false)
    {
        if ($isShowAll) {
            $supplement = '';
        } else {
            $supplement = 'AND is_visible = 1';
        }

        $statement = $this->db->prepare("SELECT t.id, t.`condition`, t.class, t.publish_date , is_visible, solution
                FROM tasks t
	              JOIN tasks_categories tc on tc.task_id = t.id
	              JOIN categories c ON c.id = tc.category_id
                WHERE c.name = ? AND t.class = ? $supplement
                ORDER BY publish_date DESC, id DESC
                LIMIT ?, ?");

        $statement = $statement->execute(array($category, $grade, $this->firstElementOfPage($page), $this->pageSize));

        $problems = $statement->fetchAllAssoc();
        $problems = $this->addCategoriesToProblems($problems);
        $problems['maxCount'] = $this->problemsByGradeAndCategoryCount($grade, $category, $supplement);
        return $problems;
    }


    public function getProblemById($id)
    {
        $problems = $this->db
            ->prepare("SELECT id, `condition`, class, publish_date, solution
                        FROM tasks
                        WHERE id = ?")
            ->execute(array($id))
            ->fetchAllAssoc();

        $problems = $this->addCategoriesToProblems($problems);
        return $problems[0];
    }


    public function problemsCount($supplement)
    {
        $count = $this->db->prepare("SELECT count(*) FROM tasks $supplement")
            ->execute()
            ->fetchRowNum()[0];

        return $count;
    }


    public function problemsByGradeCount($grade, $supplement)
    {
        $count = $this->db->prepare("SELECT count(*)
                FROM tasks WHERE class = ? $supplement")
            ->execute(array($grade))
            ->fetchRowNum()[0];

        return $count;
    }


    public function problemsByCategoryCount($category, $supplement)
    {
        $count = $this->db->prepare("SELECT count(*) FROM tasks t
	              JOIN tasks_categories tc on tc.task_id = t.id
	              JOIN categories c ON c.id = tc.category_id
                WHERE c.name = ? $supplement")
            ->execute(array($category))
            ->fetchRowNum()[0];

        return $count;
    }


    public function problemsByGradeAndCategoryCount($grade, $category, $supplement)
    {
        $count = $this->db->prepare("SELECT count(*) FROM tasks t
	              JOIN tasks_categories tc on tc.task_id = t.id
	              JOIN categories c ON c.id = tc.category_id
                WHERE c.name = ? AND t.class = ? $supplement")
            ->execute(array($category, $grade))
            ->fetchRowNum()[0];

        return $count;
    }


    public function problemsByUserCount($userId)
    {
        $count = $this->db->prepare('SELECT count(*)
                FROM tasks WHERE user_id = ?')
            ->execute(array($userId))
            ->fetchRowNum()[0];

        return $count;
    }


    /**
     * @param Problem $problem
     */
    public function updateProblem($problem)
    {
        $this->db->prepare("UPDATE tasks
               SET solution = ?, `condition` = ?, class = ?
               WHERE id = ?")
            ->execute(array($problem->solution, $problem->condition, $problem->grade, $problem->id));

        //
    }


    public function delete($problemId)
    {
        $this->db->prepare("DELETE FROM tasks WHERE id = ?")
            ->execute(array($problemId));
    }

    public function toggleVisibility($problemId)
    {
        $visibility = (bool)$this->db->prepare("SELECT is_visible FROM tasks WHERE id = ?")
            ->execute(array($problemId))
            ->fetchRowNum()[0];
        $visibility = (int)!$visibility;

        $this->db->prepare("UPDATE tasks
                SET is_visible = ?
                WHERE id = ?")
            ->execute(array($visibility, $problemId));
    }

    private function addCategoriesToProblems($problems)
    {
        $problemsWithCategories = array();
        foreach ($problems as $problem) {
            $categories = Data::categories()->getCategoriesOfProblem($problem['id']);
            $problem['categories'] = $categories;
            $problemsWithCategories[] = $problem;
        }

        return $problemsWithCategories;
    }

    private function firstElementOfPage($page)
    {
        return $this->pageSize * ($page - 1);
    }

}