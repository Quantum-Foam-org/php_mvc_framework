<?php

class db extends PDO {

    private $fetch_types = array(
        'assoc'
    );
    private static $dbh = null;
    
    public function __construct($dsn, $user, $pass) {
        parent::__construct($dsn, $user, $pass);
    }
    
    public static function obj() {
        if (!self::$dbh) {
            try {
                self::$dbh = new db(DB_DSN, DB_USER_NAME, DB_USER_PASS);
            } catch (PDOException $e) {
                echo 'Connection failed: '.$e->getMessage();
            }
            self::$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        
        return self::$dbh;
    }
/*
    public function __call($name, $args) {
        $type = str_replace('fetch_cache_', '', $name);
        
        logger::obj()->write('Arguments to '.__CLASS__.'::__call');
        logger::obj()->write($args);
            
        if (strpos($name, 'fetch_cache') === 0 && in_array($type, $this->fetch_types)) {
            $key_value_field = array((isset($args[2]) ? $args[2] : null), (isset($args[3]) ? $args[3] : null));
            $result = $this->fetch_cache($args[0], $args[1], $key_value_field, 'assoc');
        } else {
            logger::obj()->write('No method found: ' . $name, -1);
            $result = FALSE;
        }

        return $result;
    }

    private function fetch_cache($sql, $key_cache, $key_value_field, $type) {
        if (extension_loaded('apc')) {
            $result_set = apc_fetch($key_cache, $fetch_result);
        } else {
            $fetch_result = FALSE;
        }
        
        if (!$fetch_result and ($sth = $this->query($sql))) {
            $rows = $sth->fetchAll();
            $result_set = $this->{'key_'.$type}($rows, $key_value_field[0], $key_value_field[1]);
            unset($rows);
            if (extension_loaded('apc')) {
                apc_store($key_cache, $result_set, config::$apc_cache);
            }
        } else if (!$fetch_result) {
            logger::obj()->write('Unable to fetch_cache query: ' . $sql, 0);
        }

        return $result_set;
    }
*/
    public function fetch_assoc($sql, $key_field, $value_field = null, array $params = array()) {
        $result_set = FALSE;
        
        logger::obj()->write('fetch_assoc');
        logger::obj()->write('params');
        logger::obj()->write(array($sql, $key_field, $value_field));
        logger::obj()->write('fetch_assoc');
        if (($sth = $this->run_query($sql, $params))) {
            if (($rows = $sth->fetchAll())) {
                $result_set = $this->key_assoc($rows, $key_field, $value_field);
                unset($rows);
            }
        }
        return $result_set;
    }
    
    public function fetch_all_one($sql, $field, array $params = array()) {
        $result_set = FALSE;
        if (($sth = $this->run_query($sql, $params))) {
            if (($rows = $sth->fetchAll())) {
                $result_set = array();
                foreach ($rows as $row) {
                    $result_set[] = $row[$field];
                }
                unset($rows, $row);
            }
        }
        return $result_set;
    }
    
    public function fetch_all($sql, array $params = array()) {
        $result_set = FALSE;
        if (($sth = $this->run_query($sql, $params))) {
            $result_set = $sth->fetchAll();
        }
        return $result_set;
    }
    
    public function get_one($sql, array $params = array()) {
        $sth = $this->run_query($sql, $params);
        $row = $sth->fetch();
        return $row;
    }

    public function get_val($sql, array $params = array()) {
        if (($row = $this->get_one($sql, $params))) {
            $row =  array_pop($row);
        } 
        
        return $row;
    }
    
    private function & key_assoc(array & $rows, $key_field, $value_field = null) {
        $fields = array();
        
        foreach ($rows as $row) {
            if ($value_field === null) {
                $fields[$row[$key_field]] = $row;
            } else {
                $fields[$row[$key_field]] = $row[$value_field];
            }
        }
        return $fields;
    }
    
    public function insert($table, $values) {
        $fields = '';
        $quest = '';
        foreach ($values as $key => $value) {
            $fields .= $key.',';
            $quest .= '?,';
        }
        $fields = substr($fields, 0, -1);
        $quest = substr($quest, 0, -1);
        
        $stmt = $this->prepare('INSERT INTO '.$table.' ('.$fields.') VALUES('.$quest.')');
        if ($stmt->exec($values)) {
            $result = $this->lastInsertId();
        } else {
            $result = FALSE;
        }
        
        return $result;
    }
    
    private function run_query($sql, array $params = array()) {
        if (!empty($params)) {
            $sth = $this->prepare($sql);
            $sth->execute($params);
        } else {
            $sth = $this->query($sql);
        }
        
        return $sth;
    }
}