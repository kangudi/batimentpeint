<?php

declare(strict_types=1);

namespace App\Users\Domain;

use DateTimeImmutable;
use InvalidArgumentException;
use LogicException;

/**
 * Entité métier Professionnel.
 *
 * Correspond à la table PROFESSIONNEL (MLD/MPD, Étape 4).
 * Modélisée en association avec Utilisateur (cardinalité 1 -- 0..1),
 * pas en héritage — décision actée en Étape 5.1 et confirmée par le MLD/MPD
 * (table séparée avec #id_utilisateur en clé étrangère unique).
 *
 * Couche Domain : aucune dépendance à MySQL, à PDO ni à une bibliothèque externe.
 * Le nombre de preuves (RG7) est fourni en paramètre par la couche Application,
 * qui l'obtient via le repository Preuve — cette classe ne connaît pas la persistance.
 */
final class Professionnel
{
    // Valeurs autorisées pour statutValidation (colonne ENUM en base)
    public const STATUT_EN_ATTENTE = 'en_attente';
    public const STATUT_VALIDE = 'valide';
    public const STATUT_REJETE = 'rejete';

    private const STATUTS_VALIDES = [
        self::STATUT_EN_ATTENTE,
        self::STATUT_VALIDE,
        self::STATUT_REJETE,
    ];

    // RG7 : minimum de preuves vérifiables exigé pour l'activation d'un compte professionnel.
    public const MIN_PREUVES_REQUISES = 5;

    private ?int $id;
    private int $idUtilisateur;
    private string $zoneIntervention;
    private string $specialites;
    private string $statutValidation;
    private ?DateTimeImmutable $dateValidation;
    private ?int $idAdminValidateur;

    /**
     * @param int|null $id null pour un professionnel pas encore persisté
     * @param int $idUtilisateur identifiant de l'Utilisateur associé (obligatoire)
     */
    public function __construct(
        ?int $id,
        int $idUtilisateur,
        string $zoneIntervention,
        string $specialites,
        string $statutValidation = self::STATUT_EN_ATTENTE,
        ?DateTimeImmutable $dateValidation = null,
        ?int $idAdminValidateur = null
    ) {
        $this->id = $id;

        if ($idUtilisateur <= 0) {
            throw new InvalidArgumentException('L\'identifiant utilisateur associé est obligatoire.');
        }
        $this->idUtilisateur = $idUtilisateur;

        $this->setZoneIntervention($zoneIntervention);
        $this->setSpecialites($specialites);
        $this->setStatutValidation($statutValidation);
        $this->dateValidation = $dateValidation;
        $this->idAdminValidateur = $idAdminValidateur;
    }

    // --- Validation métier (setters privés) ---

    private function setZoneIntervention(string $zoneIntervention): void
    {
        if (trim($zoneIntervention) === '') {
            throw new InvalidArgumentException('La zone d\'intervention ne peut pas être vide.');
        }
        $this->zoneIntervention = trim($zoneIntervention);
    }

    private function setSpecialites(string $specialites): void
    {
        if (trim($specialites) === '') {
            throw new InvalidArgumentException('Les spécialités ne peuvent pas être vides.');
        }
        $this->specialites = trim($specialites);
    }

    private function setStatutValidation(string $statut): void
    {
        if (!in_array($statut, self::STATUTS_VALIDES, true)) {
            throw new InvalidArgumentException(sprintf(
                'Statut de validation invalide : "%s". Valeurs autorisées : %s.',
                $statut,
                implode(', ', self::STATUTS_VALIDES)
            ));
        }
        $this->statutValidation = $statut;
    }

    // --- Comportements métier ---

    /**
     * RG2 — Un professionnel ne peut apparaître dans les résultats de recherche
     * que si son compte a été validé par l'administrateur.
     */
    public function estValide(): bool
    {
        return $this->statutValidation === self::STATUT_VALIDE;
    }

    /**
     * RG7 — Un compte professionnel doit renseigner, pour être activé : au minimum
     * une zone d'intervention, ses spécialités (déjà garanties non vides par le
     * constructeur), et un minimum de MIN_PREUVES_REQUISES preuves vérifiables.
     *
     * @param int $nombrePreuves nombre de preuves déjà enregistrées pour ce professionnel
     */
    public function peutEtreActive(int $nombrePreuves): bool
    {
        return trim($this->zoneIntervention) !== ''
            && trim($this->specialites) !== ''
            && $nombrePreuves >= self::MIN_PREUVES_REQUISES;
    }

    /**
     * Valide le compte professionnel. L'appelant (couche Application) doit avoir
     * vérifié peutEtreActive() au préalable (RG7) avant d'invoquer cette méthode.
     */
    public function valider(int $idAdminValidateur, DateTimeImmutable $dateValidation): void
    {
        if ($this->statutValidation === self::STATUT_VALIDE) {
            throw new LogicException('Ce professionnel est déjà validé.');
        }

        if ($idAdminValidateur <= 0) {
            throw new InvalidArgumentException('L\'identifiant de l\'administrateur validateur est invalide.');
        }

        $this->statutValidation = self::STATUT_VALIDE;
        $this->dateValidation = $dateValidation;
        $this->idAdminValidateur = $idAdminValidateur;
    }

    /**
     * Rejette la demande de validation du compte professionnel.
     */
    public function rejeter(): void
    {
        $this->statutValidation = self::STATUT_REJETE;
        $this->dateValidation = null;
        $this->idAdminValidateur = null;
    }

    public function changerZoneIntervention(string $zoneIntervention): void
    {
        $this->setZoneIntervention($zoneIntervention);
    }

    public function changerSpecialites(string $specialites): void
    {
        $this->setSpecialites($specialites);
    }

    // --- Accesseurs ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    public function getZoneIntervention(): string
    {
        return $this->zoneIntervention;
    }

    public function getSpecialites(): string
    {
        return $this->specialites;
    }

    public function getStatutValidation(): string
    {
        return $this->statutValidation;
    }

    public function getDateValidation(): ?DateTimeImmutable
    {
        return $this->dateValidation;
    }

    public function getIdAdminValidateur(): ?int
    {
        return $this->idAdminValidateur;
    }
}
