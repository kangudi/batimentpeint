<?php

declare(strict_types=1);

namespace App\Users\Domain;

use DateTimeImmutable;
use InvalidArgumentException;

/**
 * Entité métier Preuve.
 *
 * Correspond à la table PREUVE (MLD/MPD, Étape 4) : preuve vérifiable d'une
 * prestation déjà réalisée par un professionnel (photo, référence chantier...),
 * utilisée pour satisfaire la RG7 (minimum 5 preuves requises pour l'activation
 * d'un compte professionnel — voir Professionnel::peutEtreActive()).
 *
 * type_preuve est une colonne VARCHAR(50) libre en base (pas un ENUM) : aucune
 * liste fermée de valeurs n'est imposée au niveau Domain.
 *
 * Couche Domain : aucune dépendance à MySQL, à PDO ni à une bibliothèque externe.
 */
final class Preuve
{
    private ?int $id;
    private int $idProfessionnel;
    private string $typePreuve;
    private string $cheminFichier;
    private DateTimeImmutable $dateAjout;

    /**
     * @param int|null $id null pour une preuve pas encore persistée
     */
    public function __construct(
        ?int $id,
        int $idProfessionnel,
        string $typePreuve,
        string $cheminFichier,
        DateTimeImmutable $dateAjout
    ) {
        $this->id = $id;

        if ($idProfessionnel <= 0) {
            throw new InvalidArgumentException('L\'identifiant du professionnel associé est obligatoire.');
        }
        $this->idProfessionnel = $idProfessionnel;

        $this->setTypePreuve($typePreuve);
        $this->setCheminFichier($cheminFichier);
        $this->dateAjout = $dateAjout;
    }

    // --- Validation métier (setters privés) ---

    private function setTypePreuve(string $typePreuve): void
    {
        if (trim($typePreuve) === '') {
            throw new InvalidArgumentException('Le type de preuve ne peut pas être vide.');
        }
        $this->typePreuve = trim($typePreuve);
    }

    private function setCheminFichier(string $cheminFichier): void
    {
        if (trim($cheminFichier) === '') {
            throw new InvalidArgumentException('Le chemin du fichier ne peut pas être vide.');
        }
        $this->cheminFichier = trim($cheminFichier);
    }

    // --- Accesseurs ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProfessionnel(): int
    {
        return $this->idProfessionnel;
    }

    public function getTypePreuve(): string
    {
        return $this->typePreuve;
    }

    public function getCheminFichier(): string
    {
        return $this->cheminFichier;
    }

    public function getDateAjout(): DateTimeImmutable
    {
        return $this->dateAjout;
    }
}
