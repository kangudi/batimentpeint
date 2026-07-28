<?php

declare(strict_types=1);

namespace App\Core;

/**
 * EnvLoader
 * ---------
 * À QUOI ÇA SERT :
 * Lit le fichier .env et rend ses valeurs disponibles via getenv()/$_ENV.
 *
 * POURQUOI C'EST IMPORTANT :
 * Aucune information sensible (mot de passe base de données, clé secrète...)
 * ne doit jamais être écrite en dur dans le code PHP. On la met dans .env
 * (qui n'est jamais envoyé sur Git, voir .gitignore) et on la lit ici.
 * Ça permet aussi d'avoir une config différente en local, en recette et en
 * production, sans jamais toucher au code.
 */
final class EnvLoader
{
    public static function load(string $envFilePath): void
    {
        if (!file_exists($envFilePath)) {
            // En développement, on préfère un message clair à une erreur silencieuse.
            throw new \RuntimeException("Fichier .env introuvable : {$envFilePath}. Copie .env.example en .env.");
        }

        $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // On ignore les commentaires et les lignes vides.
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
            $key = trim($key);
            $value = trim($value);

            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }
}
