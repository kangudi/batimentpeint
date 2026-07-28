<?php

declare(strict_types=1);

namespace App\Clients\Domain;

/**
 * ClientRepositoryInterface
 * --------------------------
 * À QUOI ÇA SERT :
 * Décrit CE QU'ON PEUT FAIRE avec les clients en base (sauvegarder, retrouver,
 * lister), sans dire COMMENT c'est fait techniquement.
 *
 * POURQUOI C'EST IMPORTANT :
 * Le Service (Application) parle à cette interface, jamais directement à
 * MySQL. Ça veut dire :
 * - Tu peux tester ton Service sans base de données réelle (avec un faux
 *   repository "en mémoire").
 * - Si un jour tu changes MySQL pour autre chose, tu ne touches qu'à
 *   Infrastructure/ClientRepository.php, jamais au Service.
 * C'est l'application concrète du principe SOLID "Dependency Inversion" :
 * on dépend d'un contrat, pas d'une implémentation.
 */
interface ClientRepositoryInterface
{
    public function save(Client $client): Client;

    public function findById(int $id): ?Client;

    /** @return Client[] */
    public function findAll(): array;
}
