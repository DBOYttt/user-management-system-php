<?php
/**
 * Klasa Dbconfig zawiera informacje dotyczące konfiguracji bazy danych.
 */
class Dbconfig {
    /**
     * Nazwa serwera bazy danych.
     * @var string
     */
    protected $serverName;
    
    /**
     * Nazwa użytkownika bazy danych.
     * @var string
     */
    protected $userName;
    
    /**
     * Hasło dostępu do bazy danych.
     * @var string
     */
    protected $passCode;
    
    /**
     * Nazwa bazy danych.
     * @var string
     */
    protected $dbName;
    
    /**
     * Konstruktor klasy Dbconfig.
     * Ustawia wartości zmiennych na podstawie wartości z ciasteczek.
     * Jeśli ciasteczka nie istnieją, używane są domyślne wartości.
     */
    public function __construct() {
        $this->serverName = $_COOKIE['db_serwer'] ?? 'localhost';
        $this->userName = $_COOKIE['db_user'] ?? 'root';
        $this->passCode = $_COOKIE['db_pass'] ?? '';
        $this->dbName = $_COOKIE['db_name'] ?? 'pdoadmin';
    }
}