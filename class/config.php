<?php
class Dbconfig {
    protected $serverName;
    protected $userName;
    protected $passCode;
    protected $dbName;
    public function __construct() {
        $this->serverName = $_COOKIE['db_serwer'] ?? 'localhost';
        $this->userName = $_COOKIE['db_user'] ?? 'root';
        $this->passCode = $_COOKIE['db_pass'] ?? '';
        $this->dbName = $_COOKIE['db_name'] ?? 'pdoadmin';
    }
}