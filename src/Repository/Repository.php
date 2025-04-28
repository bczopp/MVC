<?php
namespace Tornado\Repository;

use PDO;
use ReflectionClass;

abstract class Repository
{
    public function __construct(
        protected PDO $pdo
    ) {}

    /**
     * @return string
     */
    abstract protected function getEntityClass(): string;

    /**
     * @return string
     */
    abstract protected function getTableName(): string;

    /**
     * @return array|string
     */
    abstract protected function getSelectedAttributes(): array|string;


    /**
     * @return object[]
     * @throws \ReflectionException
     */
    public function findAll(): array
    {
        return array_map(
            fn($row) => $this->castEntity($this->getEntityClass(), $row),
            $this->find()->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    /**
     * @param array $where
     * @return object
     * @throws \ReflectionException
     */
    public function findOne(array $where = []): object
    {
        return $this->castEntity(
            $this->getEntityClass(),
            $this->find($where)->fetch(PDO::FETCH_ASSOC)
        );
    }

    /**
     * @param object $entity
     * @return void
     */
    public function delete(object $entity): void
    {
        $table = $this->getTableName();
        $this->pdo->exec("DELETE FROM $table WHERE id = {$entity->getId()}");
    }

    /**
     * @param object $entity
     * @return void
     */
    public function insertUpdate(object $entity): void
    {
        $vars = get_object_vars($entity);
        $cols = array_keys($vars);

        $table = $this->getTableName();
        $columns = implode(',',$cols);
        $values = array_map(fn($value) => is_string($value) ? $this->pdo->quote($value) : $value, $vars);
        $update = implode(',', array_map(fn($column) => "$column = VALUES($column)", $cols));

        $this->pdo->exec("INSERT INTO $table ($columns) VALUES ($values) ON DUPLICATE KEY UPDATE $update");
    }

    /**
     * @param string $class
     * @param array $row
     * @return object
     * @throws \ReflectionException
     */
    private function castEntity(string $class, array $row): object
    {
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $paramNames = array_map(
            fn($param) => $param->getName(),
            $constructor->getParameters()
        );
        $args = [];
        foreach($paramNames as $paramName) {
            if(!isset($row[$paramName])) {
                throw new \Exception("Parameter $paramName not found in $class",500);
            }
            $args[] = $row[$paramName];
        }

        return $reflection->newInstanceArgs($args);
    }

    /**
     * @param array $where
     * @return \PDOStatement
     */
    private function find(array $where = []): \PDOStatement
    {
        $select = $this->getSelectedAttributes();
        if(is_array($select)){
            $select = implode(',', $select);
        }
        $table = $this->getTableName();

        $sql = "SELECT $select FROM $table";
        if(!empty($where)){
            $where = implode(
                ' AND ',
                array_map(
                    fn($value, $index) => is_string($value) ? "$index LIKE {$this->pdo->quote($value)}" : "$index = $value",
                    $where,
                    array_keys($where)
                )
            );
            $sql .= ' WHERE ' . $where;
        }
        return $this->pdo->query($sql);
    }
}
