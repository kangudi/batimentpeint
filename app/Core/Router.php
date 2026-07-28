<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Router
 * ------
 * À QUOI ÇA SERT :
 * Regarde l'URL demandée et la méthode HTTP (GET, POST...), et appelle
 * la bonne méthode du bon contrôleur. Comprend aussi les URLs "propres"
 * avec des segments variables, comme /clients/12, sans "?id=12".
 *
 * POURQUOI C'EST IMPORTANT :
 * - Sans routeur, il faudrait un fichier .php différent pour chaque page
 *   (clients.php, commandes.php...), ce qui devient vite impossible à
 *   maintenir. Avec un routeur, il y a UN seul point d'entrée
 *   (public/index.php) et toutes les URLs sont définies à un seul endroit,
 *   lisible d'un coup d'œil.
 * - Les URLs "propres" (/client/commande, /clients/12) plutôt qu'avec des
 *   "?" (monsite/client?commande=livre) sont plus lisibles pour
 *   l'utilisateur, mieux référencées par les moteurs de recherche, et
 *   permettent de savoir directement, rien qu'en lisant l'URL, à quelle
 *   ressource on accède.
 *
 * COMMENT ÇA MARCHE :
 * Une route déclarée "/clients/{id}" est transformée en expression
 * régulière ("/clients/([^/]+)") qui capture ce que contient {id} et le
 * transmet en paramètre à ton contrôleur.
 */
final class Router
{
    /**
     * Chaque route est stockée avec : le motif original (pour lire le
     * code facilement), l'expression régulière (pour comparer à la vraie
     * URL) et l'action à exécuter.
     *
     * @var array<string, list<array{pattern: string, regex: string, action: callable}>>
     */
    private array $routes = [];

    public function get(string $uri, callable $action): void
    {
        $this->ajouterRoute('GET', $uri, $action);
    }

    public function post(string $uri, callable $action): void
    {
        $this->ajouterRoute('POST', $uri, $action);
    }

    private function ajouterRoute(string $methode, string $uri, callable $action): void
    {
        $this->routes[$methode][] = [
            'pattern' => $uri,
            'regex' => $this->transformerEnRegex($uri),
            'action' => $action,
        ];
    }

    /**
     * Transforme "/clients/{id}" en une expression régulière capable de
     * reconnaître "/clients/12" et d'en extraire "12".
     * Un segment {quelquechose} accepte tout sauf un nouveau "/".
     */
    private function transformerEnRegex(string $uri): string
    {
        $regex = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $uri);

        return '#^' . $regex . '$#';
    }

    public function dispatch(string $method, string $uri): void
    {
        // On retire les paramètres après le "?" et le "/" final en trop
        // (ex: /clients/12?debug=1 -> /clients/12 ; /clients/ -> /clients).
        $chemin = parse_url($uri, PHP_URL_PATH) ?? '/';
        if ($chemin !== '/' && str_ends_with($chemin, '/')) {
            $chemin = rtrim($chemin, '/');
        }

        foreach ($this->routes[$method] ?? [] as $route) {
            if (preg_match($route['regex'], $chemin, $correspondances)) {
                // On enlève la correspondance complète (index 0), il ne
                // reste que les valeurs des {segments}, dans l'ordre.
                array_shift($correspondances);

                // Les valeurs de segments sont passées telles quelles au
                // contrôleur : (fn(string $id) => $controleur->afficher($id)).
                ($route['action'])(...$correspondances);
                return;
            }
        }

        http_response_code(404);
        echo "Page introuvable (404).";
    }
}
