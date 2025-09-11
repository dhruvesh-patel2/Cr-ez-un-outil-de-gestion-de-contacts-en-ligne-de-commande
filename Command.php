<?php

/**
 * Classe Command - Gestion des commandes utilisateur
 * Cette classe traite les différentes commandes saisies par l'utilisateur
 * et fait appel au ContactManager pour les opérations sur la base de données
 */
class Command {

    /**
     * Commande LIST : affiche tous les contacts
     */
    public function list(): void {
        $manager = new ContactManager((new DBConnect())->getPDO());
        $contacts = $manager->findAll();
        
        if (empty($contacts)) {
            echo "Aucun contact trouvé.\n";
            return;
        }

        echo "Liste des contacts :\n";
        echo "==================\n";
        // Affiche les contacts
        foreach ($contacts as $contact) {
            echo $contact . "\n";
        }
    }

    /**
     * Commande DETAIL : affiche un contact précis par son ID
     * @param int $id Identifiant du contact à afficher
     */
    public function detail(int $id): void {
        $manager = new ContactManager((new DBConnect())->getPDO());
        $contact = $manager->findById($id);

        if ($contact) {
            echo "Détail du contact :\n";
            echo "==================\n";
            echo $contact . "\n";
        } else {
            echo "Aucun contact trouvé avec l'id $id\n";
        }
    }

    /**
     * Commande CREATE : crée un nouveau contact
     * @param string $name Nom du contact
     * @param string $email Email du contact
     * @param string $phone Numéro de téléphone du contact
     */
    public function create(string $name, string $email, string $phone): void {
        // Validation basique des données
        if (empty($name) || empty($email) || empty($phone)) {
            echo "Erreur : Tous les champs sont obligatoires (nom, email, téléphone)\n";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Erreur : L'adresse email n'est pas valide\n";
            return;
        }

        $manager = new ContactManager((new DBConnect())->getPDO());
        
        if ($manager->create($name, $email, $phone)) {
            echo "Contact créé avec succès !\n";
        } else {
            echo "Erreur lors de la création du contact\n";
        }
    }

    /**
     * Commande DELETE : supprime un contact par son ID
     * @param int $id Identifiant du contact à supprimer
     */
    public function delete(int $id): void {
        $manager = new ContactManager((new DBConnect())->getPDO());
        
        // Vérifier que le contact existe avant de le supprimer
        $contact = $manager->findById($id);
        if (!$contact) {
            echo "Aucun contact trouvé avec l'id $id\n";
            return;
        }

        if ($manager->delete($id)) {
            echo "Contact avec id $id supprimé avec succès.\n";
        } else {
            echo "Erreur lors de la suppression du contact\n";
        }
    }
}