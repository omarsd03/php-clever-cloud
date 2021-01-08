<?php

    include ('db-config.php');

    class ConexionBD {

        private $server;
        private $database;
        private $port;
        private $user;
        private $password;
        private $dsnhost;
        private $options;
        private $connection;

        function __construct() {
            $this->server = _SERVER;
            $this->port = _PORT;
            $this->database = _DATABASE;
			$this->user = _USER;
			$this->password = _PASSWORD;
			$this->dsnhost = "mysql:host=$this->server;port=$this->port;dbname=$this->database";
			$this->connection = null;
			$this->options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];
        }

        public function conectaBD() {

            try {
                $this->connection = new PDO($this->dsnhost, $this->user, $this->password, $this->options);
                return $this->connection;
            } catch (Exception $e) {
                throw $e;
            }

        }

        public function closeBD() {
            $this->connection = null;
        }

        function __destruct() {
            $this->closeBD();
        }

    }

?>