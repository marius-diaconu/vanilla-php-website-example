<?php
    class Database {
        static $connection = null;
        // set database connection
        static function setConnection() {
            try {
                return new PDO("mysql:host=localhost;dbname={$_ENV['DB_DATABASE']}", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => true
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        // get singleton database connection
        static function getConnection() {
            if (!Database::$connection) {
                Database::$connection = Database::setConnection();
                return Database::$connection;
            } else {
                return Database::$connection;
            }
        }
        // count database records
        static function count($query) {
            try {
                $sql = Database::getConnection()->query($query);
                $result = $sql->fetchColumn();
                return $result;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        // fetch single record from database
        static function first($query) {
            try {
                $sql = Database::getConnection()->query($query);
                $result = $sql->fetchObject();
                return $result;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        // fetch all records from database
        static function get($query) {
            try {
                $sql = Database::getConnection()->query($query);
                $sql->setFetchMode(PDO::FETCH_OBJ);
                $result = $sql->fetchAll();
                return $result;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        // insert record into database
        static function insert($query) {
            try {
                $sql = Database::getConnection()->query($query);
                return Database::getConnection()->lastInsertId();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        // update record from database
        static function update($query) {
            try {
                $sql = Database::getConnection()->query($query);
                $result = $sql->rowCount();
                return $result;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        // delete record from database
        static function delete($query) {
            try {
                $sql = Database::getConnection()->query($query);
                $result = $sql->rowCount();
                return $result;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    } # end of Database class
?>