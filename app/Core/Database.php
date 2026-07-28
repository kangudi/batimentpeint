<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * Database
 * --------
 * À QUOI ÇA SERT :
 * Fournit UNE seule connexion PDO à MySQL, réutilisée partout dans le projet.
 *
 * POURQUOI C'EST IMPORTANT :
 * - On ne veut pas ouvrir une nouvelle connexion à chaque requête SQL (lent,
 *   gaspille les ressources du serveur).
 * - PDO avec des requêtes préparées est la seule façon sûre de parler à
 *   MySQL : ça empêche les injections SQL (une des failles de sécurité
 *   les plus courantes et les plus dangereuses).
 * - Cette classe est LA SEULE de tout le projet à savoir comment se
 *   connecter à MySQL. Si un jour on change de base de données ou
 *   d'hébergeur, on modifie un seul fichier.
 */
final class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
            $port = $_ENV['DB_PORT'] ?? '3306';
            $dbName = $_ENV['DB_NAME'] ?? '';
            $user = $_ENV['DB_USER'] ?? 'root';
            $password = $_ENV['DB_PASSWORD'] ?? '';

            $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4";

            try {
                self::$instance = new PDO($dsn, $user, $password, [
                    // Une erreur SQL doit lever une exception, jamais rester silencieuse.
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Les résultats sont retournés en tableaux associatifs (['nom' => 'Dupont']).
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // Empêche PDO d'émuler les requêtes préparées : elles sont
                    // vraiment envoyées préparées à MySQL, ce qui est plus sûr.
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                // On ne montre jamais le détail technique à l'utilisateur final,
                // mais on le garde pour le développeur (log).
                throw new \RuntimeException('Connexion à la base de données impossible.', 0, $e);
            }
        }

        return self::$instance;
    }
}
