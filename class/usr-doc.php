<?php
/**
 * Klasa użytkownika
 */
class User extends Dbconfig {

    /**
     * Nazwa hosta
     * @var string
     */
    protected $hostName;

    /**
     * Nazwa użytkownika
     * @var string
     */
    protected $userName;

    /**
     * Hasło
     * @var string
     */
    protected $password;

    /**
     * Nazwa bazy danych
     * @var string
     */
    protected $dbName;

    /**
     * Nazwa tabeli użytkowników
     * @var string
     */
    private $userTable = 'user';

    /**
     * Połączenie z bazą danych
     * @var mysqli
     */
    private $dbConnect = false;

    /**
     * Konstruktor klasy
     */
    public function __construct(){
        // ...
    }

    /**
     * Pobiera dane z bazy danych
     * 
     * @param string $sqlQuery zapytanie SQL
     * @return array dane z bazy danych
     */
    private function getData($sqlQuery) {
        // ...
    }

    /**
     * Pobiera liczbę wierszy z bazy danych
     * 
     * @param string $sqlQuery zapytanie SQL
     * @return int liczba wierszy
     */
    private function getNumRows($sqlQuery) {
        // ...
    }

    /**
     * Sprawdza status logowania użytkownika
     */
    public function loginStatus (){
        // ...
    }

    /**
     * Logowanie użytkownika
     * 
     * @return string komunikat o błędzie
     */
    public function login(){		
        // ...
    }

    /**
     * Rejestracja użytkownika
     * 
     * @return string komunikat o błędzie
     */
    public function register(){		
        // ...
    }

    /**
     * Pobiera szczegóły użytkownika
     * 
     * @return array szczegóły użytkownika
     */
    public function userDetails () {
        // ...
    }

    /**
     * Edycja konta użytkownika
     * 
     * @return string komunikat o błędzie
     */
    public function editAccount () {
        // ...
    }

    /**
     * Logowanie administratora
     * 
     * @return string komunikat o błędzie
     */
    public function adminLogin(){		
        // ...
    }

    /**
     * Sprawdza status logowania administratora
     */
    public function adminLoginStatus (){
        // ...
    }

    /**
     * Pobiera liczbę użytkowników
     * 
     * @param string $status status użytkownika
     * @return int liczba użytkowników
     */
    public function totalUsers ($status) {
        // ...
    }

    /**
     * Pobiera szczegóły administratora
     * 
     * @return array szczegóły administratora
     */
    public function adminDetails () {
        // ...
    }

    /**
     * Zapisuje hasło administratora
     * 
     * @return string komunikat o błędzie
     */
    public function saveAdminPassword(){
        // ...
    }

    /**
     * Pobiera listę użytkowników
     */
    public function getUserList(){		
        // ...
    }

    /**
     * Wysyła wiadomość
     * 
     * @param string $message treść wiadomości
     */
    public function sendMessage($message) {
        // ...
    }

    /**
     * Pobiera wiadomości z czatu
     * 
     * @return array wiadomości z czatu
     */
    public function getChatMessages() {
        // ...
    }

    /**
     * Usuwa użytkownika
     */
    public function deleteUser(){
        // ...
    }

    /**
     * Pobiera użytkownika
     */
    public function getUser(){
        // ...
    }

    /**
     * Edycja użytkownika
     */
    public function updateUser() {
        // ...
    }
}