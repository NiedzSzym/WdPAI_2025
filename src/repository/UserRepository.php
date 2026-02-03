<?php

require_once 'Repository.php';

class UserRepository extends Repository
{
    // Pobieranie wszystkich użytkowników
    public function getUsers(): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users
        ');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    // Pobieranie jednego użytkownika po emailu (np. do logowania)
    public function getUserByEmail(string $email) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Zwraca false jeśli nie znajdzie, więc zamieniamy na null dla bezpieczeństwa
        return $user ?: null;
    }

    public function createUser(
        string $email,
        string $hashedPassword,
        string $firstname,
        string $lastname,
        string $bio = ''
    ) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, password, firstname, lastname, bio) 
            VALUES (?, ?, ?, ?, ?)
        ');


        $stmt->execute([
            $email,
            $hashedPassword,
            $firstname,
            $lastname,
            $bio
        ]);
    }
}