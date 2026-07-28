<?php

declare(strict_types=1);

namespace App\Clients\Application;

use App\Clients\Domain\Client;
use App\Clients\Domain\ClientRepositoryInterface;

/**
 * ClientService (Application)
 * ----------------------------
 * À QUOI ÇA SERT :
 * Réalise les actions demandées par l'utilisateur : "créer un client",
 * "lister les clients". C'est la traduction directe de tes cas d'usage
 * (étape 2 de la méthode : "L'utilisateur peut créer un compte").
 *
 * POURQUOI C'EST IMPORTANT :
 * - C'est ICI, et nulle part ailleurs, que doit se trouver la logique
 *   métier qui orchestre plusieurs étapes (ex : créer un client PUIS
 *   lui envoyer un e-mail de bienvenue).
 * - Le contrôleur (Presentation) ne doit JAMAIS contenir cette logique :
 *   il se contente d'appeler le service. Ça permet de réutiliser le
 *   même service depuis une page web, une API, ou une commande en ligne
 *   de commande, sans dupliquer le code.
 * - Le service ne connaît que l'INTERFACE du repository, jamais MySQL
 *   directement (voir ClientRepositoryInterface).
 */
final class ClientService
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {
    }

    public function creerClient(string $nom, string $email): Client
    {
        // La validation des règles (RG1, RG2) est déjà faite dans le
        // constructeur de Client (Domain) : le service ne la refait pas,
        // il fait confiance à l'objet Domain.
        $client = new Client(id: null, nom: $nom, email: $email);

        return $this->clientRepository->save($client);
    }

    /** @return Client[] */
    public function listerClients(): array
    {
        return $this->clientRepository->findAll();
    }

    public function trouverParId(int $id): ?Client
    {
        return $this->clientRepository->findById($id);
    }
}
