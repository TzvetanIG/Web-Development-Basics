<?php
namespace GFramework\DB;

use GFramework\App;

class SimpleDb
{
    protected $connection = 'default';
    private $db = null;
    /**
     * @var \PDOStatement
     */
    private $statement = null;
    private $params = array();
    private $sql;

    public function __construct($connection = null)
    {
        if ($connection instanceof \PDO) {
            $this->db = $connection;
        } else if ($connection != null) {
            $this->db = App::getInstance()->getDbConnection($connection);
            $this->connection = $connection;
        } else {
            $this->db = App::getInstance()->getDbConnection($this->connection);
        }

        $this->db->setAttribute( \PDO::ATTR_EMULATE_PREPARES, false );
    }

    /**
     * @param $sql
     * @param array $params
     * @param array $pdoOptions
     * @return $this
     */
    public function prepare($sql, $params = array(), $pdoOptions = array())
    {
        $this->statement = $this->db->prepare($sql, $pdoOptions);
        $this->params = $params;
        $this->sql = $sql;

        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function execute($params= array())
    {
        if($params){
            $this->params = $params;
        }

        $this->statement->execute($this->params);
        return $this;
    }

    /**
     * @param $param
     * @param $value
     * @param $pdoType
     * @return $this
     */
    public function bindValue($param, $value, $pdoType)
    {
        $this->statement->bindValue($param, $value, $pdoType);
        return $this;
    }

    public function fetchAllAssoc()
    {
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchRowAssoc(){
        return $this->statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAllNum() {
        return $this->statement->fetchAll(\PDO::FETCH_NUM);
    }

    public function fetchRowNum() {
        return $this->statement->fetch(\PDO::FETCH_NUM);
    }

    public function fetchAllObj() {
        return $this->statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function fetchRowObj() {
        return $this->statement->fetch(\PDO::FETCH_OBJ);
    }

    public function fetchAllClass($class) {
        return $this->statement->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function fetchRowClass($class) {
        return $this->statement->fetch(\PDO::FETCH_CLASS, $class);
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function getAffectRows() {
        return $this->statement->rowCount();
    }

    public function getStatement() {
        return $this->statement;
    }
}


