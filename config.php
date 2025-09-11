<?php
/**
 * Fichier de configuration de l'application
 * Contient les paramètres de connexion à la base de données
 */

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'carnet_adresses');
define('DB_USER', 'root');
define('DB_PASS', '');

// Options PDO par défaut
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);