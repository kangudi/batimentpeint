<?php

declare(strict_types=1);

namespace App\Core;

/**
 * View
 * ----
 * À QUOI ÇA SERT :
 * Affiche une page en deux temps : d'abord le contenu propre à la page
 * (ex : la liste des clients), puis ce contenu est injecté au milieu
 * du layout commun (header + footer), pour donner une page complète.
 *
 * POURQUOI C'EST IMPORTANT :
 * - Sans ça, il faudrait recopier le header (menu, liens CSS) et le
 *   footer (scripts JS) en haut et en bas de CHAQUE page du site. Le
 *   jour où tu changes un lien dans le menu, il faudrait le changer
 *   partout. Avec un layout commun, tu le changes à un seul endroit
 *   (app/Shared/views/partials/header.php) et toutes les pages du site
 *   sont mises à jour d'un coup.
 * - Le contrôleur (Presentation) reste "mince" : il ne fait qu'appeler
 *   View::renderAvecLayout(), il ne contient jamais de HTML lui-même.
 */
final class View
{
    /**
     * Exécute un fichier de vue PHP et récupère ce qu'il affiche, sans
     * l'envoyer tout de suite au navigateur (grâce à ob_start/ob_get_clean).
     *
     * @param array<string, mixed> $donnees Variables rendues disponibles dans la vue.
     */
    public static function render(string $cheminVue, array $donnees = []): string
    {
        // extract() transforme ['nom' => 'Awa'] en une variable $nom
        // directement utilisable dans le fichier de vue inclus ci-dessous.
        extract($donnees);

        ob_start();
        require $cheminVue;

        return ob_get_clean();
    }

    /**
     * Rend une vue PUIS l'injecte dans le layout commun (header + footer),
     * et envoie directement le résultat au navigateur.
     *
     * @param array<string, mixed> $donnees
     */
    public static function renderAvecLayout(string $cheminVue, array $donnees = [], string $titre = ''): void
    {
        // 1. On rend d'abord le contenu propre à la page...
        $contenu = self::render($cheminVue, $donnees);

        // 2. ...puis on l'injecte dans le layout, qui attend une variable
        //    $contenu et une variable $titre (voir layout.php).
        $cheminLayout = dirname(__DIR__) . '/Shared/views/layout.php';
        require $cheminLayout;
    }
}
