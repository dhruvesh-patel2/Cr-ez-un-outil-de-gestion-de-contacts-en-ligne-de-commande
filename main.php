<?php
// --- Classe DBConnect ---
class DBConnect {
    public function getPDO(): PDO {
        return new PDO('mysql:host=localhost;dbname=carnet_adresses', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}

// --- Classe Contact ---
class Contact {
    private int $id;
    private string $name;
    private string $email;
    private string $phone_number;

    public function __construct(int $id, string $name, string $email, string $phone_number) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }

    public function __toString(): string {
        return "{$this->id} - {$this->name} - {$this->email} - {$this->phone_number}";
    }
}

// --- Classe ContactManager ---
class ContactManager {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM contact");
        return array_map(
            fn($row) => new Contact($row['id'], $row['name'], $row['email'], $row['phone_number']),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }
}

// fichier Command
require_once 'Command.php';

// --- Boucle CLI pour commandes ---
while (true) {
    $line = readline("Entrez votre commande : ");

    if ($line === "quit") {
        echo "Au revoir !\n";
        break;
    }

    if ($line === "list") {
        (new Command())->list();
    }
}
