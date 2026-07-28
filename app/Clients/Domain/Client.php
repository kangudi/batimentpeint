<?php

declare(strict_types=1);

namespace App\Clients\Domain;

/**
 * Client (Domain)
 * ---------------
 * À QUOI ÇA SERT :
 * Représente UN client dans la vraie vie : ses informations et les règles
 * qui lui sont propres (ex : un e-mail doit être valide).
 *
 * POURQUOI C'EST IMPORTANT — C'EST LA CLASSE LA PLUS IMPORTANTE DU MODULE :
 * - Elle ne connaît RIEN de MySQL, ni de PDO, ni de HTML. Si demain tu
 *   changes de base de données ou d'interface, cette classe ne bouge pas.
 * - Elle contient les règles de gestion du cahier des charges (RG1, RG2...).
 *   C'est ici, et nulle part ailleurs, qu'on doit chercher "quelles sont
 *   les règles sur un client ?".
 * - C'est la traduction directe de ton diagramme de classes UML (étape 5
 *   de la méthode) : chaque attribut et chaque méthode ici doit se
 *   retrouver sur ton diagramme, et inversement.
 */
final class Client
{
    public function __construct(
        private ?int $id,
        private string $nom,
        private string $email,
    ) {
        // RG1 : un client doit avoir un e-mail valide.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("L'e-mail « {$email} » n'est pas valide.");
        }

        // RG2 : le nom ne doit pas être vide.
        if (trim($nom) === '') {
            throw new \InvalidArgumentException('Le nom du client ne peut pas être vide.');
        }
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function nom(): string
    {
        return $this->nom;
    }

    public function email(): string
    {
        return $this->email;
    }
}
