<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/CardsRepository.php';

class DashboardController extends AppController {
    
    private $cardsRepository;

    public function __construct() {
        $this->cardsRepository = new CardsRepository();
    }

    public function search() {
        // 1. Walidacja metody - tylko POST
        if (!$this->isPost()) {
            http_response_code(405);
            // Poprawka: json_encode to funkcja, musi mieć nawiasy i argumenty (lub być pusta, ale lepiej nic nie zwracać przy błędzie 405 lub zwrócić komunikat błędu)
            return; 
        }

        // 2. Pobranie nagłówka Content-Type
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        // 3. Obsługa formatu JSON
        if ($contentType === "application/json") {
            // Pobranie surowych danych z wejścia
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            // Ustawienie nagłówka odpowiedzi
            header('Content-type: application/json');
            http_response_code(200);

            // Wywołanie repozytorium i zwrócenie wyniku
            // Upewniamy się, że klucz 'search' istnieje w przesłanym JSONie
            $searchString = $decoded['search'] ?? ''; 
            
            echo json_encode($this->cardsRepository->getCardsByTitle($searchString));
        }
        return;
    }
    public function dashboard() {
        // tutaj logika logowania(sprawdzanie uzytkownika, zabezpieczenie inputu itd.)

        $cards = [
            [
                'id' => 1,
                'title' => 'Ace of Spades',
                'subtitle' => 'Legendary card',
                'imageUrlPath' => 'https://deckofcardsapi.com/static/img/AS.png',
                'href' => '/cards/ace-of-spades'
            ],
            [
                'id' => 2,
                'title' => 'Queen of Hearts',
                'subtitle' => 'Classic romance',
                'imageUrlPath' => 'https://deckofcardsapi.com/static/img/QH.png',
                'href' => '/cards/queen-of-hearts'
            ],
            [
                'id' => 3,
                'title' => 'King of Clubs',
                'subtitle' => 'Royal strength',
                'imageUrlPath' => 'https://deckofcardsapi.com/static/img/KC.png',
                'href' => '/cards/king-of-clubs'
            ],
            [
                'id' => 4,
                'title' => 'Jack of Diamonds',
                'subtitle' => 'Sly and sharp',
                'imageUrlPath' => 'https://deckofcardsapi.com/static/img/JD.png',
                'href' => '/cards/jack-of-diamonds'
            ],
            [
                'id' => 5,
                'title' => 'Ten of Hearts',
                'subtitle' => 'Lucky draw',
                'imageUrlPath' => 'https://deckofcardsapi.com/static/img/0H.png',
                'href' => '/cards/ten-of-hearts'
            ],
    ];

    $userRepository = new UserRepository();
    $users = $userRepository->getUsers();
    var_dump($users);

    return $this->render("dashboard", ['cards' => $cards]);
    }
    

}