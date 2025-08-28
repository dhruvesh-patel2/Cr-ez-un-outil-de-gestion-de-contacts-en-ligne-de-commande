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
 // Récupère un contact par ID
    public function findById(int $id): ?Contact {
        $stmt = $this->pdo->prepare("SELECT * FROM contact WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Contact($row['id'], $row['name'], $row['email'], $row['phone_number']) : null;
    }
  // Crée un nouveau contact
    public function create(string $name, string $email, string $phone): void {
        $stmt = $this->pdo->prepare("INSERT INTO contact (name, email, phone_number) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $phone]);
    }
// Supprime un contact par ID
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM contact WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// --- Inclusion des commandes ---
require_once 'Command.php';

    // Lecture de la commande
while (true) {
    $line = readline("Entrez votre commande : ");
    // Quitter le programme
    if ($line === "quit") {
        echo "Au revoir !\n";
        break;
    }
     // Commande list
    if ($line === "list") {
        (new Command())->list();
    } elseif (preg_match('/^detail (\d+)$/', $line, $matches)) {
        (new Command())->detail((int)$matches[1]);
    } elseif (preg_match('/^create (.+),(.+),(.+)$/', $line, $matches)) {
        (new Command())->create(trim($matches[1]), trim($matches[2]), trim($matches[3]));
    } elseif (preg_match('/^delete (\d+)$/', $line, $matches)) {
        (new Command())->delete((int)$matches[1]);
    } else {
        echo "Commande inconnue.\n";
    }
}
