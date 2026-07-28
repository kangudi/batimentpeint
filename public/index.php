<?php

declare(strict_types=1);

/**
 * public/index.php — Front Controller
 * -------------------------------------
 * À QUOI ÇA SERT :
 * C'est LE SEUL fichier PHP accessible directement depuis le navigateur.
 * Toutes les URLs du site passent par lui, qui les redirige vers le bon
 * contrôleur via le Router.
 *
 * POURQUOI C'EST IMPORTANT :
 * - Un seul point d'entrée = un seul endroit où gérer les erreurs, la
 *   sécurité, le chargement de la configuration. Impossible d'accéder
 *   par erreur à un fichier interne du projet (Domain, Infrastructure...)
 *   puisque seul ce dossier "public/" est exposé sur le serveur web.
 * - C'est ici, et seulement ici, qu'on "branche" les morceaux entre eux
 *   (Repository → Service → Contrôleur) : c'est ce qu'on appelle
 *   l'injection de dépendances manuelle.
 */

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Clients\Application\ClientService;
use App\Clients\Application\Validation\ClientValidator;
use App\Clients\Infrastructure\ClientRepository;
use App\Clients\Presentation\ClientController;
use App\Core\Database;
use App\Core\EnvLoader;
use App\Core\Router;

// 1. Charger la configuration (.env) avant tout le reste.
EnvLoader::load(dirname(__DIR__) . '/.env');

// 2. Construire les objets du module Clients, du bas vers le haut :
//    connexion PDO -> Repository -> Service -> Validator -> Contrôleur.
$pdo = Database::getConnection();
$clientRepository = new ClientRepository($pdo);
$clientService = new ClientService($clientRepository);
$clientValidator = new ClientValidator();
$clientController = new ClientController($clientService, $clientValidator);

// 3. Déclarer les routes : URL -> action à exécuter.
//    ATTENTION À L'ORDRE : le Router s'arrête à la PREMIÈRE route qui
//    correspond. "/clients/nouveau" doit donc être déclarée AVANT
//    "/clients/{id}", sinon "{id}" capturerait "nouveau" comme si
//    c'était un identifiant.
$router = new Router();
$router->get('/clients', fn() => $clientController->liste());
$router->get('/clients/nouveau', fn() => $clientController->formulaire());
$router->post('/clients', fn() => $clientController->creer());

// URL propre avec segment : /clients/12 (au lieu de /clients?id=12).
// La valeur "12" capturée par {id} est transmise en argument à l'action.
$router->get('/clients/{id}', fn(string $id) => $clientController->afficher($id));

// 4. Laisser le routeur traiter la vraie requête reçue.
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
