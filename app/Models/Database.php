<?php


namespace Models;

class Database extends DatabaseQuery
{
    private $tableName;
    private $primaryKey;
    private $className;
    private $constructorArgs;

    /**
     * __construct
     *
     * @param  mixed $tableName
     * @param  mixed $primaryKey
     * @param  mixed $className
     * @param  mixed $constructorArgs
     * @return void
     */
    public function __construct(string  $tableName, string $primaryKey, string $className = '\stdClass', array $constructorArgs = [])
    {
        $this->tableName = $tableName;
        $this->primaryKey = $primaryKey;
        $this->className = $className;
        $this->constructorArgs = $constructorArgs;
    }
    public function total($field = null, $value = null)
    {
        $query = 'SELECT COUNT(*) FROM `' . $this->tableName . '`';
        $parameters = [];
        if (!empty($field)) {
            $query .= ' WHERE `' . $field . '` = :value';
            $parameters = ['value' => $value];
        }
        $query = $this->query($query, $parameters);
        $row = $query->fetch();
        return $row[0];
    }
    /**
     * processDate
     *
     * @param  mixed $fields
     * @return array
     */
    private function processDate(array $fields): array
    {
        foreach ($fields as $key => $value) {
            if ($value instanceof \DateTime) {
                $fields[$key] = $value->format('Y-m-d');
            }
        }
        return $fields;
    }
    public function findAll($orderBy = null, $limit = null, $offset = null)
    {
        $query = 'SELECT * FROM `' . $this->tableName . '`';

        if ($orderBy != null) {
            $query .= ' ORDER BY ' . $orderBy;
        }
        if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }
        if ($offset != null) {
            $query .= ' OFFSET ' . $offset;
        }
        $result = $this->query($query);
        $result->setFetchMode(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
        return $result->fetchAll();
    }

    public function insert($fields)
    {

        $query = 'INSERT INTO `' . $this->tableName . '` (';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '`,';
        }

        $query = rtrim($query, ',');
        $query .= ') VALUES (';

        foreach ($fields as $key => $value) {
            $query .= ':' . $key . ',';
        }

        $query = rtrim($query, ',');
        $query .= ')';


        $this->query($query, $fields);

        return $this->pdo->lastInsertId();
    }

    public function update($fields)
    {
        $query = ' UPDATE `' . $this->tableName . '` SET ';
        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '` =:' . $key . ',';
        }
        $query = rtrim($query, ',');
        $query .= ' WHERE `' . $this->primaryKey . '` =:' . $this->primaryKey . '';


        //Set the :primaryKey variable
        $fields['primaryKey'] = $fields[$this->primaryKey];
        $fields = $this->processDate($fields);

        $this->query($query, $fields);
    }
    public function save($record)
    {
        $record = $this->processDate($record);
        $entity = new $this->className(...$this->constructorArgs);

        try {
            if ($record[$this->primaryKey] == '') {
                $record[$this->primaryKey] == null;
            }
            $insertId = $this->insert($record);
            $entity->{$this->primaryKey} = $insertId;
        } catch (\PDOException $e) {
            $this->update($record);
        }

        foreach ($record as $key => $value) {
            if (!empty($value)) {
                $entity->{$key} = $value;
            }
        }

        return $entity;
    }

    public function displayData($orderBy = null, $limit = null, $offset = null)
    {
        $sql = "SELECT *
                FROM $this->tableName";
        if ($orderBy !== null) {
            $sql .= ' ORDER BY ' . $orderBy;
        }
        if ($limit !== null) {
            $sql .= ' LIMIT ' . $limit;
        }
        if ($offset !== null) {
            $sql .= ' OFFSET ' . $offset;
        }

        $result = $this->query($sql);

        return  $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }
    public function find($column, $value, $orderBy = null, $limit = null, $offset = null)
    {
        $query = 'SELECT * FROM ' . $this->tableName . ' WHERE ' . $column . ' =:value ';

        $parameters = [
            'value' => $value
        ];
        if ($orderBy != null) {
            $query .= ' ORDER BY ' . $orderBy;
        }
        if ($limit != null) {
            $query .= ' LIMIT ' . $limit;
        }
        if ($offset != null) {
            $query .= ' OFFSET ' . $offset;
        }

        $result = $this->query($query, $parameters);
        return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }

    public function findByTwoColumns($column, $value, $column2, $value2)
    {
        $sql = 'SELECT * FROM `' . $this->tableName . '`
         WHERE `' . $column . '` =:value AND `' . $column2 . '` = :value2';
        $parameters = [
            'value' => $value,
            'value2' => $value2
        ];
        $result = $this->query($sql, $parameters);
        return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
    }

    public function findById($value)
    {
        $query = 'SELECT * FROM `' . $this->tableName . '` WHERE `' . $this->primaryKey . '` = :value ';
        $parameters = [':value' => $value];
        $query = $this->query($query, $parameters);
        return $query->fetchObject($this->className, $this->constructorArgs);
    }

    public function removeData(array $data)
    {
        $parameters = [$this->primaryKey => $data];
        $sql = "DELETE FROM `" . $this->tableName . "` WHERE `" . $this->primaryKey . "` = :" . $this->primaryKey . '';
        $this->query($sql, $parameters[$this->primaryKey]);
    }

    public function deleteWhere($column, $value)
    {
        $query = $query = 'DELETE FROM `' . $this->tableName . '` WHERE `' . $column . '` = :value';
        $parameters = ['value' => $value];
        $query = $this->query($query, $parameters);
    }

    public function deleteWhereTwoColumns($column, $value, $column2, $value2)
    {
        $query = $query = 'DELETE FROM `' . $this->tableName . '` WHERE `' . $column . '` = :value AND `' . $column2 . '` = :value2';
        $parameters = [
            'value' => $value,
            'value2' => $value2
        ];
        $query = $this->query($query, $parameters);
    }
}
