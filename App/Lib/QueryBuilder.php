<?php
    class QueryBuilder{

        private $action;
        private $fields = array();
        private $table;
        private $conditions = array();
        private $groupBy;
        private $having;
        private $orderBy;
        private $limit;
        private $offset;
        private $insertKeys = array();
        private $insertValues = array();
        private $set = array();

        public function select(){
            $this->action = "select";
            $this->fields = empty(func_get_args()) ? array('*') : func_get_args();
            return $this;
        }

        public function update($table){
            $this->action = "update";
            $this->table = $table;
            return $this;
        }

        public function insertInto($table){
            $this->action = "insert";
            $this->table = $table;
            return $this;
        }

        public function delete($table){
            $this->action = "delete";
            $this->table = $table;
            return $this;
        }

        public function truncate($table){
            $this->action = "delete";
            $this->table = $table;
            return $this;
        }

        public function from($table){
            $this->table = $table;
            return $this;
        }

        public function where($condition){
            $this->conditions[] = $condition;
            return $this;
        }

        public function groupBy($field){
            $this->groupBy = $field;
            return $this;
        }

        public function having($condition){
            $this->having = $condition;
            return $this;
        }

        public function orderBy($field){
            $this->orderBy = $field;
            return $this;
        }

        public function limit($limit){
            $this->limit = $limit;
            return $this;
        }

        public function offset($offset){
            $this->offset = $offset;
            return $this;
        }

        public function insert($key, $value = null){
            if(is_null($value)){
                $this->insertValues[] = is_numeric($key) ? $key : "'" . $key . "'";
            }else{
                $this->insertKeys[] = $key;
                $this->insertValues[] = is_numeric($key) ? $value : "'" . $value . "'";
            }
            return $this;
        }

        public function set($set){
            $this->set[] = $set;
            return $this;
        }

        public function __toString(){
            $method = 'build' . ucfirst($this->action);
            return $this->$method();
        }

        private function buildSelect(){
            $query = 'SELECT ' .
            implode(',', $this->fields) . ' ' .
            'FROM ' . $this->table;
            if(!empty($this->conditions)){
                $query .= ' WHERE ' . implode(',', $this->conditions);
            }
            if(!empty($this->groupBy)){
                $query .= ' GROUP BY ' . $this->groupBy;
            }
            if(!empty($this->having)){
                $query .= ' HAVING ' . $this->having;
            }
            if(!empty($this->orderBy)){
                $query .= ' ORDER BY ' . $this->orderBy;
            }
            if(!empty($this->limit)){
                $query .= ' LIMIT ' . $this->limit;
            }
            if(!empty($this->limit)){
                $query .= ' OFFSET ' . $this->offset;
            }
            return $query;
        }

        private function buildInsert(){
            $query = 'INSERT INTO ' .  $this->table;
            if(!empty($this->insertKeys)){
                $query .= ' (' . implode(',', $this->insertKeys) . ')';
            }
            $query .= ' VALUES ' .
            ' (' . implode(',', $this->insertValues) . ')';
            return $query;
        }

        private function buildUpdate(){
            $query = 'UPDATE ' . $this->table . ' ' .
            'SET ' . implode(',', $this->set);
            if(!empty($this->conditions)){
                $query .= ' WHERE ' . implode(',', $this->conditions);
            }
            return $query;
        }

        private function buildDelete(){
            $query = 'DELETE FROM ' . $this->table;
            if(!empty($this->conditions)){
                $query .= ' WHERE ' . implode(',', $this->conditions);
            }
            return $query;
        }

        private function buildTruncate(){
            $query = 'TRUNCATE TABLE ' . $this->table;
            return $query;
        }

    }
