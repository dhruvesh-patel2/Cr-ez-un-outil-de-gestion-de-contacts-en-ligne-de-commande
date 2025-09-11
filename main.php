<?php
/**
 * Point d'entrée principal de l'application de gestion de contacts
 * Gère la boucle de lecture des commandes utilisateur
 */

// Inclusion de tous les fichiers nécessaires
require_once 'config.php';
require_once 'Contact.php';
require_once 'DBConnect.php';
require_once 'ContactManager.php';
require_once 'Command.php';

// Boucle principale de lecture des commandes
while (true) {
    $line = readline("Entrez votre commande : ");
    
    // Quitter le programme
    if ($line === "quit") {
        echo "Au revoir !\n";
        break;
    }
    
    // Commande list : affiche tous les contacts
    if ($line === "list") {
        (new Command())->list();
    } 
    // Commande detail : affiche un contact spécifique par son ID
    elseif (preg_match('/^detail (\d+)$/', $line, $matches)) {
        (new Command())->detail((int)$matches[1]);
    } 
    // Commande create : crée un nouveau contact (format: create nom,email,telephone)
    elseif (preg_match('/^create (.+),(.+),(.+)$/', $line, $matches)) {
        (new Command())->create(trim($matches[1]), trim($matches[2]), trim($matches[3]));
    } 
    // Commande delete : supprime un contact par son ID
    elseif (preg_match('/^delete (\d+)$/', $line, $matches)) {
        (new Command())->delete((int)$matches[1]);
    } 
    // Commande non reconnue
    else {
        echo "Commande inconnue.\n";
        echo "Commandes disponibles :\n";
        echo "- list : afficher tous les contacts\n";
        echo "- detail [id] : afficher un contact spécifique\n";
        echo "- create [nom],[email],[telephone] : créer un nouveau contact\n";
        echo "- delete [id] : supprimer un contact\n";
        echo "- quit : quitter le programme\n";
    }
}