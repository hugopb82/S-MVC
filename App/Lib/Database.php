<?php
    namespace Database;

    use \PDO;

    class Database implements DatabaseInterface{

        private $type;
        private $host;
        private $dbname;
        private $user;
        private $pass;

        private $pdo;

        public function __construct($type = 'mysql', $host = 'localhost', $dbname = 'test', $user = 'root', $pass = 'root'){
            $this->type = $type;
            $this->host = $host;
            $this->dbname = $dbname;
            $this->user = $user;
            $this->pass = $pass;
        }

        private function get(){
            if($this->pdo == null){
                $this->pdo = new PDO($this->type . ':host=' . $this->host . ';dbname=' . $this->dbname, $this->user, $this->pass);
                $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return $this->pdo;
        }

        public function query($statement, $fetch = PDO::FETCH_ASSOC, $one = false){
            $sql = $this->get()->query($statement);

            $sql->setFetchMode($fetch);

            if($one == true){
				$data = $sql->fetch();
			}else{
				$data = $sql->fetchAll();
			}

            return $data;
        }

        public function exec($statement, $params, $fetch = PDO::FETCH_ASSOC, $one = false){
            $sql = $this->get()->prepare($statement);
			$sql->execute($params);

            if(strpos($statement, 'SELECT') === 0){
                $sql->setFetchMode($fetch);

                if($one == true){
    			    $data = $sql->fetch();
    			}else{
    				$data = $sql->fetchAll();
    			}

    			return $data;
			}
        }

    }
