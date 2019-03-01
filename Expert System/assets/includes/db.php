<?php
    final class db extends PDO {
        public function __construct() {
            $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_SCHEMA;

            try {
                parent::__construct($dsn, DB_USR, DB_PWD, array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_FOUND_ROWS => true
                ));
            } catch (PDOException $ex) {
                Throw $ex;
            }
        }
    }