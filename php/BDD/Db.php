<?php

class Db {

    const INSERT_MODE_INSERT_INTO = 'insert into';
    const INSERT_MODE_REPLACE     = 'replace';

    /**
     * @var DbObj
     */
    protected static $db;
    protected static $fncs = array('NOW()', 'CURDATE()');


    public static function setInstance(DbObj $db){
        self::$db = $db;
    }

    public static function getInstance(){
        return self::$db;
    }

    public static function getAssoc($sql, array $params = array()){
        return self::$db->getAssoc($sql, $params);
    }

    public static function getAssocs($sql, array $params = array()){
        return self::$db->getAssocs($sql, $params);
    }

    public static function getColumn($sql, array $params = array()){
        return self::$db->getColumn($sql, $params);
    }

    public static function getColumns($sql, array $params = array()){
        return self::$db->getColumns($sql, $params);
    }

    public static function getTblAssoc($tbl, array $fields, array $where = array()){
        $sql = 'SELECT '. implode(', ', $fields) .' FROM '. $tbl . self::getWhereStr($where) .' LIMIT 1';
        return self::$db->getAssoc($sql);
    }

    public static function getTblAssocs($tbl, array $fields, array $where = array(), $sort = ''){
        $sql = 'SELECT '. implode(', ', $fields) .' FROM '. $tbl . self::getWhereStr($where) . self::getOrderByStr($sort);
        return self::$db->getAssoc($sql);
    }

    public static function getTblColumn($tbl, $field, array $where = array()){
        $sql = 'SELECT '. $field .' FROM '. $tbl . self::getWhereStr($where) .' LIMIT 1';
        return self::$db->getColumn($sql);
    }

    public static function getTblColumns($tbl, $field, array $where = array(), $sort = ''){
        $sql = 'SELECT '. $field .' FROM '. $tbl . self::getWhereStr($where) . self::getOrderByStr($sort);
        return self::$db->getColumns($sql);
    }

    protected static function _doInsert($insert_mode, $tbl, array $values){
        $cols = $vals = $params = array();
        foreach ($values as $k => $v){
            $cols[] = '`'. $k .'`';
            if (in_array($v, self::$fncs)){ // Une fonction
                $vals[] = $v;
            } else {
                $vals[] = ':'.$k;
                $params[$k] = $v;
            }
        }
        $sql = ($insert_mode == self::INSERT_MODE_REPLACE ? 'REPLACE ' : 'INSERT INTO') . $tbl .' ('. implode(', ', $cols) .') VALUES ('. implode(', ', $vals) .')';
        $stmt = self::$db->getStatement($sql, $params);
        return self::lastInsertId();
    }

    public static function insert($tbl, array $values){
        return self::_doInsert(self::INSERT_MODE_INSERT_INTO, $tbl, $values);
    }

    public static function replace($tbl, array $values){
        return self::_doInsert(self::INSERT_MODE_REPLACE, $tbl, $values);
    }

    public static function update($tbl, array $values, array $where = array(), $limit = null){
        $prepare_set = function($k, $v){
            return '`'.$k.'` = '. self::quoteExceptFncs($v);
        };
        $set = array_map($prepare_set, array_keys($values), array_values($values));
        $sql = 'UPDATE '. $tbl .' SET '. implode(', ', $set) . self::getWhereStr($where) . self::getLimitStr($limit);
        $stmt = self::$db->getStatement($sql);
        return self::lastInsertId();
    }

    public static function delete($tbl, array $where = array(), $limit = null){
        $sql = 'DELETE FROM '. $tbl . self::getWhereStr($where) . self::getLimitStr($limit);
        return self::$db->getStatement($sql);
    }

    public static function deleteId($tbl, $id_colname, $id_value){
        return self::delete($tbl, array($id_colname => $id_value));
    }

    public static function getOrderByStr($sort){
        return (null !== $sort && trim($sort) != '') ? ' ORDER BY '.$sort : '';
    }

    public static function getLimitStr($limit){
        return (null !== $limit) ? ' LIMIT '.$limit : '';
    }

    public static function getWhereStr($where){
        $where_str = '';
        if (is_array($where)){
            $where_str = self::whereArrayToStr($where);
        } else if (is_string($where)){
            $where_str = trim($where);
        }

        return ($where_str != '') ? ' WHERE '.$where_str : '';
    }

    public static function whereArrayToStr(array $where, $operator = ' AND '){
        $ws = array();
        if (count($where) > 0){
            foreach ($where as $k => $v){
                if (is_array($v)){
                    $ws[] = '`'.$k.'` IN ('. self::quoteImplode($v) .')';
                }
                else if (is_numeric($k)){
                    if (trim($v) != ''){
                        $ws[] = trim($v);
                    }
                }
                else if (is_scalar($v)){
                    $ws[] = '`'.$k.'` = '. self::quoteExceptFncs($v);
                }
            }
        }
        if (count($ws) > 0){
            return '('. implode($operator, $ws) .')';
        }
        return '';
    }

    public static function quoteExceptFncs($str){
        if (in_array($str, self::$fncs)){
            return $str;
        }
        return self::$db->quote($str);
    }

    public static function quote($str){
        return self::$db->quote($str);
    }

    public static function quoteImplode(array $values){
        return self::$db->quoteImplode($values);
    }

    public static function lastInsertId(){
        return self::$db->lastInsertId();
    }


}