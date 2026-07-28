<?php

declare(strict_types=1);

namespace App\Clients\Infrastructure;

use App\Clients\Domain\Client;
use App\Clients\Domain\ClientRepositoryInterface;
use PDO;

/**
 * ClientRepository (Infrastructure)
 * -----------------------------------
 * À QUOI ÇA SERT :
 * Implémente VRAIMENT l'accès à MySQL pour les clients : c'est la seule
 * classe du module qui contient du SQL.
 *
 * POURQUOI C'EST IMPORTANT :
 * - Toutes les requêtes SQL du module "Clients" sont regroupées ICI et
 *   nulle part ailleurs. Si un client a un bug de requête, tu sais
 *   exactement où chercher.
 * - Requêtes préparées obligatoires (bindValue) : c'est ce qui empêche
 *   l'injection SQL, une faille de sécurité grave et pourtant facile
 *   à éviter.
 * - Cette classe "implements" l'interface définie dans Domain : c'est
 *   le contrat qu'elle doit respecter, rien de plus.
 */
final class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        private PDO $pdo,
    ) {
    }

    public function save(Client $client): Client
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO clients (nom, email) VALUES (:nom, :email)'
        );
        $stmt->bindValue(':nom', $client->nom());
        $stmt->bindValue(':email', $client->email());
        $stmt->execute();

        $id = (int) $this->pdo->lastInsertId();

        return new Client(id: $id, nom: $client->nom(), email: $client->email());
    }

    public function findById(int $id): ?Client
    {
        $stmt = $this->pdo->prepare('SELECT id, nom, email FROM clients WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $ligne = $stmt->fetch();

        if ($ligne === false) {
            return null;
        }

        return new Client(id: (int) $ligne['id'], nom: $ligne['nom'], email: $ligne['email']);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT id, nom, email FROM clients ORDER BY id DESC');

        $clients = [];
        foreach ($stmt->fetchAll() as $ligne) {
            $clients[] = new Client(id: (int) $ligne['id'], nom: $ligne['nom'], email: $ligne['email']);
        }

        return $clients;
    }
}
