<?php
/**
 * Created by PhpStorm.
 * User: Tzvetan
 * Date: 15-4-30
 * Time: 13:44
 */

namespace Models\Repositories;

use GFramework\App;
use GFramework\DB\SimpleDb;

class DataDb {
    /**
     * @var SimpleDb
     */
    protected  $db;
    protected $pageSize;

    public function __construct()
    {
        $this->db = new SimpleDb();
        $this->pageSize = App::getInstance()->getConfig()->app['pageSize'];
    }
} 