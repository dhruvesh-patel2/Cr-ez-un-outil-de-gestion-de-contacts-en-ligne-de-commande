<?php

/**
 * Classe DBConnect - Gestion de la connexion à la base de données
 * Utilise le pattern Singleton pour garantir une seule instance PDO
 */
class DBConnect {
    private static ?PDO $instance = null;

    /**
     * Retourne l'instance PDO (Singleton pattern)
     * @return PDO Instance de connexion à la base de données
     */
    public function getPDO(): PDO {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            self::$instance = new PDO($dsn, DB_USER, DB_PASS, DB_OPTIONS);
        }
        return self::$instance;
    }
}