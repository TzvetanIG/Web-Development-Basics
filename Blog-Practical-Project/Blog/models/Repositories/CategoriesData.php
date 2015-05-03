<?php
namespace Models\Repositories;

class CategoriesData extends DataDb
{
    /**
     * @param $category
     * @return mixed|string Returned id of category
     */
    public function add($category)
    {
        $id = $this->getCategoryId($category);
        if ($id) {
            return $id;
        }

        $this->db->prepare('INSERT INTO categories (`name`) VALUES (?)')
            ->execute(array(mb_convert_case($category, MB_CASE_LOWER, "UTF-8")));

        return $this->db->getLastInsertId();
    }

    /**
     * @param $category
     * @return mixed Returned id of category
     */
    public function getCategoryId($category)
    {
        $id = $this->db->prepare('SELECT id FROM categories WHERE name = ?')
            ->execute(array(mb_convert_case($category, MB_CASE_LOWER, "UTF-8")))->fetchRowNum()[0];

        return $id;
    }

    public function addProblemToCategory($category_id, $problem_id)
    {
        $this->db->prepare('INSERT INTO tasks_categories (task_id, category_id) VALUES (?, ?)')
            ->execute(array($problem_id, $category_id));
    }

    public function all()
    {
        $result  = $this->db->prepare('SELECT name FROM categories ORDER BY name')
            ->execute()->fetchAllNum();
        $categories = array_map('self::getCategoryName',$result);

        return $categories;
    }

    private static function getCategoryName($arr){
        return $arr[0];
    }

    public function getCategoryByGrade($grade)
    {
        $result  = $this->db
            ->prepare('SELECT DISTINCT c.name FROM categories c
	                  JOIN tasks_categories tc ON tc.category_id = c.id
	                  JOIN tasks as t ON t.id = tc.task_id
                      WHERE t.class = ?
                      ORDER BY name')
            ->execute(array($grade))
            ->fetchAllNum();
        $categories = array_map('self::getCategoryName',$result);

        return $categories;
    }

    public function getCategoriesOfProblem($problemId)
    {
        $result  = $this->db
            ->prepare('SELECT c.name FROM categories c
	                  JOIN tasks_categories tc on tc.category_id = c.id
                      WHERE tc.task_id = ?
                      ORDER BY c.id;')
            ->execute(array($problemId))
            ->fetchAllNum();
        $categories = array_map('self::getCategoryName',$result);

        return $categories;
    }

    public function deleteCategoriesOfProblem($problemId) {
        $this->db
            ->prepare("DELETE FROM `tasks_categories` WHERE `task_id` = ?")
            ->execute(array($problemId));
    }
} 