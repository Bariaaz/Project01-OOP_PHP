<?php
    class DBConnection{

        private $server;
        private $username;
        private $password;
        private $dbname;

        public function __construct($server, $username, $pass, $dbname){
            $this->server=$server;
            $this->username=$username;
            $this->password=$pass;
            $this->dbname=$dbname;
        }

        public function getServer(){
            return $this->server;
        }

        public function getMySQLConnection(){
            $connection= mysqli_connect($this->server,$this->username,$this->password,$this->dbname);
            if (!$connection) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            //echo "Success: A proper connection to MySQL was made! your database is great." . PHP_EOL;
            //echo "Host information: " . mysqli_get_host_info($connection) . PHP_EOL; 
            
            return $connection;
        }

        public function getUsername(){
            return $this->username;
        }

        public function getPassword(){
            return $this->password;
        }

        public function getDbname(){
            return $this->dbname;
        }
    }


?>