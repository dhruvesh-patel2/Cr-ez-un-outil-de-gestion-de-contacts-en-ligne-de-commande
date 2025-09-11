<?php

/**
 * Classe ContactManager - Gestionnaire des contacts
 * Contient toutes les opérations CRUD (Create, Read, Update, Delete) pour les contacts
 * Cette classe fait le lien entre les objets Contact et la base de données
 */
class ContactManager {
    private PDO $pdo;

    /**
     * Constructeur du ContactManager
     * @param PDO $pdo Instance de connexion à la base de données
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère tous les contacts de la base de données
     * @return Contact[] Tableau d'objets Contact
     */
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM contact ORDER BY name");
        return array_map(
            fn($row) => new Contact($row['id'], $row['name'], $row['email'], $row['phone_number']),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    /**
     * Récupère un contact spécifique par son ID
     * @param int $id Identifiant du contact
     * @return Contact|null Objet Contact ou null si non trouvé
     */
    public function findById(int $id): ?Contact {
        $stmt = $this->pdo->prepare("SELECT * FROM contact WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new Contact($row['id'], $row['name'], $row['email'], $row['phone_number']) : null;
    }

    /**
     * Crée un nouveau contact dans la base de données
     * @param string $name Nom du contact
     * @param string $email Email du contact
     * @param string $phone Numéro de téléphone du contact
     * @return bool True si la création a réussi
     */
    public function create(string $name, string $email, string $phone): bool {
        $stmt = $this->pdo->prepare("INSERT INTO contact (name, email, phone_number) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $phone]);
    }

    /**
     * Supprime un contact de la base de données par son ID
     * @param int $id Identifiant du contact à supprimer
     * @return bool True si la suppression a réussi
     */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM contact WHERE id = ?");
        return $stmt->execute([$id]);
    }
}