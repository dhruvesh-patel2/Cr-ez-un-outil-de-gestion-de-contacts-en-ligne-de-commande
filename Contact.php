<?php

/**
 * Classe Contact - Entité représentant un contact
 * Cette classe ne contient aucune logique de base de données
 * Elle représente uniquement les données d'un contact
 */
class Contact {
    private int $id;
    private string $name;
    private string $email;
    private string $phone_number;

    /**
     * Constructeur de la classe Contact
     * @param int $id Identifiant unique du contact
     * @param string $name Nom du contact
     * @param string $email Email du contact
     * @param string $phone_number Numéro de téléphone du contact
     */
    public function __construct(int $id, string $name, string $email, string $phone_number) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }

    /**
     * Retourne une représentation textuelle du contact
     * @return string Informations du contact formatées
     */
    public function __toString(): string {
        return "{$this->id} - {$this->name} - {$this->email} - {$this->phone_number}";
    }

    // Getters pour accéder aux propriétés si nécessaire
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPhoneNumber(): string {
        return $this->phone_number;
    }
}