<?php

declare(strict_types=1);

namespace App\Clients\Presentation;

use App\Clients\Application\ClientService;
use App\Clients\Application\Validation\ClientValidator;
use App\Core\View;

/**
 * ClientController (Presentation)
 * ---------------------------------
 * À QUOI ÇA SERT :
 * Reçoit la demande de l'utilisateur (via le routeur), fait vérifier le
 * FORMAT des données par le Validator, appelle le Service pour faire le
 * travail, puis affiche le résultat via une vue injectée dans le layout
 * commun (voir app/Shared/views/layout.php).
 *
 * POURQUOI C'EST IMPORTANT :
 * - Un contrôleur doit rester "mince" (peu de lignes) : réception →
 *   validation de format → appel du service → affichage. AUCUNE règle
 *   métier ne doit être écrite ici, et AUCUN HTML ne doit être écrit ici
 *   non plus : le HTML vit dans views/, jamais dans le contrôleur.
 * - Le contrôleur ne fait QU'appeler le Validator : il ne sait pas
 *   comment la validation est faite en détail (voir ClientValidator.php).
 * - View::renderAvecLayout() se charge d'injecter le contenu de la vue
 *   (ex: la liste des clients) au milieu du header et du footer communs.
 */
final class ClientController
{
    public function __construct(
        private ClientService $clientService,
        private ClientValidator $clientValidator,
    ) {
    }

    public function liste(): void
    {
        $clients = $this->clientService->listerClients();

        View::renderAvecLayout(
            cheminVue: __DIR__ . '/views/liste.php',
            donnees: ['clients' => $clients],
            titre: 'Liste des clients',
        );
    }

    /**
     * Exemple d'URL propre : /clients/12 (au lieu de /clients?id=12).
     * L'id "12" est extrait de l'URL par le Router (voir Router.php) et
     * transmis ici directement comme argument de méthode.
     */
    public function afficher(string $id): void
    {
        $client = $this->clientService->trouverParId((int) $id);

        if ($client === null) {
            http_response_code(404);
            View::renderAvecLayout(
                cheminVue: dirname(__DIR__, 2) . '/Shared/views/erreur404.php',
                donnees: ['message' => 'Ce client n\'existe pas.'],
                titre: 'Client introuvable',
            );
            return;
        }

        View::renderAvecLayout(
            cheminVue: __DIR__ . '/views/afficher.php',
            donnees: ['client' => $client],
            titre: 'Fiche client',
        );
    }

    public function formulaire(): void
    {
        View::renderAvecLayout(
            cheminVue: __DIR__ . '/views/formulaire.php',
            donnees: ['erreurs' => []],
            titre: 'Nouveau client',
        );
    }

    public function creer(): void
    {
        $nom = $_POST['nom'] ?? '';
        $email = $_POST['email'] ?? '';

        // 1. Validation de FORMAT (via la dépendance Composer). Si le
        //    format est déjà incorrect, inutile d'aller plus loin.
        $erreursFormat = $this->clientValidator->valider(['nom' => $nom, 'email' => $email]);

        if ($erreursFormat !== []) {
            View::renderAvecLayout(
                cheminVue: __DIR__ . '/views/formulaire.php',
                donnees: ['erreurs' => $erreursFormat],
                titre: 'Nouveau client',
            );
            return;
        }

        // 2. Le format est correct : on passe au Service, qui lui-même
        //    s'appuie sur Domain/Client.php pour les règles métier
        //    (ex: e-mail déjà utilisé). Les deux validations sont
        //    complémentaires, voir ClientValidator.php pour le détail.
        try {
            $this->clientService->creerClient($nom, $email);

            // Après une création réussie, on redirige vers la liste plutôt
            // que d'afficher une simple page de confirmation : ça évite
            // qu'un rechargement de page (F5) recrée le client une 2e fois.
            header('Location: /clients');
            return;
        } catch (\InvalidArgumentException $e) {
            View::renderAvecLayout(
                cheminVue: __DIR__ . '/views/formulaire.php',
                donnees: ['erreurs' => [$e->getMessage()]],
                titre: 'Nouveau client',
            );
        }
    }
}
