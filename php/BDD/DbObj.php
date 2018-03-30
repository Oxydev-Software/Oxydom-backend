<?php

class DbObj extends PDO {

    public function __construct($dsn, $user, $pass){
       parent::__construct($dsn, $user, $pass);
    }

    public function getStatement($sql, array $params = array(), $execute = true){
        $stmt = $this->prepare($sql);
        if ($execute){
            $stmt->execute($params);
        }
        return $stmt;
    }

    public function getAssoc($sql, array $params = array()){
        return $this->getStatement($sql, $params)->fetch(self::FETCH_ASSOC);
    }

    public function getAssocs($sql, array $params = array()){
        return $this->getStatement($sql, $params)->fetchAll(self::FETCH_ASSOC);
    }

    public function getColumn($sql, array $params = array()){
        return $this->getStatement($sql, $params)->fetch(self::FETCH_COLUMN);
    }

    public function getColumns($sql, array $params = array()){
        return $this->getStatement($sql, $params)->fetchAll(self::FETCH_COLUMN);
    }

    public function quoteImplode(array $values, $glue = ', '){
        $values = array_map(array($this, 'quote'), $values);
        return implode($glue, $values);
    }
}