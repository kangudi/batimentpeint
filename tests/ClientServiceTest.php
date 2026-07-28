<?php

declare(strict_types=1);

namespace Tests;

use App\Clients\Application\ClientService;
use App\Clients\Domain\Client;
use App\Clients\Domain\ClientRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * ClientServiceTest
 * -------------------
 * À QUOI ÇA SERT :
 * Vérifie que ClientService fait bien son travail, SANS vraie base MySQL.
 *
 * POURQUOI C'EST IMPORTANT :
 * Grâce à l'interface ClientRepositoryInterface (voir ADR 0001), on peut
 * fabriquer ici un "faux" repository en mémoire, juste pour le test.
 * Le test est donc rapide (pas de vraie base à interroger) et fiable
 * (il ne dépend d'aucune donnée déjà présente en base).
 */
final class ClientServiceTest extends TestCase
{
    public function test_creer_client_renvoie_un_client_valide(): void
    {
        $fauxRepository = new class implements ClientRepositoryInterface {
            public function save(Client $client): Client
            {
                // On simule l'attribution d'un identifiant, comme le ferait MySQL.
                return new Client(id: 1, nom: $client->nom(), email: $client->email());
            }

            public function findById(int $id): ?Client
            {
                return null;
            }

            public function findAll(): array
            {
                return [];
            }
        };

        $service = new ClientService($fauxRepository);

        $client = $service->creerClient('Awa Traoré', 'awa@example.com');

        $this->assertSame(1, $client->id());
        $this->assertSame('Awa Traoré', $client->nom());
    }

    public function test_creer_client_avec_email_invalide_leve_une_exception(): void
    {
        $fauxRepository = new class implements ClientRepositoryInterface {
            public function save(Client $client): Client { return $client; }
            public function findById(int $id): ?Client { return null; }
            public function findAll(): array { return []; }
        };

        $service = new ClientService($fauxRepository);

        $this->expectException(\InvalidArgumentException::class);

        $service->creerClient('Awa Traoré', 'pas-un-email');
    }
}
