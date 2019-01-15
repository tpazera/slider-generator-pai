<?php

require_once 'User.php';
require_once __DIR__.'/../Database.php';

class UserMapper
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getUser(
        string $email
    ):User {
        try {
            $stmt = $this->database->connect()->prepare('SELECT * FROM users WHERE email = :email;');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return new User($user['id'], $user['name'], $user['surname'], $user['email'], $user['password'], $user['id_role']);
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function addUser(
        string $name, string $surname, string $email, string $password
    ) {
        try {
            $stmt = $this->database->connect()->prepare('INSERT INTO users (email, password, name, surname, id_role) VALUES (:email, :password, :name, :surname, 2);');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return 'User registered!';
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function getUsers(
    ): array
    {
        try {
            $stmt = $this->database->connect()->prepare('SELECT id, name, surname, email, password, role FROM pai.users LEFT JOIN pai.roles ON users.id_role = roles.id_role;');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $arrUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $arrUsers;
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function changeRole(
        int $id_user, int $id_role
    ):bool {
        try {
            //UPDATE TEXT's SETTINGS
            $stmt = $this->database->connect()->prepare('UPDATE users SET id_role = :id_role WHERE id = :id_user;');
            $stmt->bindParam(':id_role', $id_role, PDO::PARAM_STR);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }
}