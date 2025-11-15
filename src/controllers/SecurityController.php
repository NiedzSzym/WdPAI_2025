<?php

require_once 'AppController.php';


class SecurityController extends AppController {

    public function login() {
        // TODO get data from database
        if (!$this->isPost()){
            return $this->render("login");
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password']??'';
        var_dump($_POST);
        //TODO pobierany z formularza email, hasło sprawdzymy czy taki user istnieje w db jeśli nie istnieje to zwracamy, odpowiednie komunikaty jeśli istnieje to przekeirujemy go na dashboard
        //  $this->render("login", ["name"=> "Adrian"]);
        return $this->render("dashboard");
    }

    public function register() {

         if (!$this->isPost()){
            return $this->render("register");
        }
         return $this->render("login", ["message" => "Zarejestrowano uytkownika ".$email]);
        // TODO pobranie z formularza email i hasła
        // TODO insert do bazy danych
        // TODO zwrocenie informajci o pomyslnym zarejstrowaniu
    }
}