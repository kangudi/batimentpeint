<?php

declare(strict_types=1);

namespace App\Users\Domain;

use DateTimeImmutable;
use InvalidArgumentException;

/**
 * Entité métier Utilisateur.
 *
 * Correspond à la table UTILISATEUR (MLD/MPD, Étape 4).
 * Un compte Professionnel est une association distincte associée à un Utilisateur
 * (cardinalité 1 -- 0..1), pas un héritage de cette classe — décision actée en
 * Étape 5.1 et confirmée par le MLD/MPD. Voir la classe Professionnel (à venir).
 *
 * Couche Domain : aucune dépendance à MySQL, à PDO ni à une bibliothèque externe.
 */
final class Utilisateur
{
    // Valeurs autorisées pour typeUtilisateur (colonne ENUM en base)
    public const TYPE_PARTICULIER = 'particulier';
    public const TYPE_PROFESSIONNEL = 'professionnel';
    public const TYPE_ADMINISTRATEUR = 'administrateur';

    private const TYPES_VALIDES = [
        self::TYPE_PARTICULIER,
        self::TYPE_PROFESSIONNEL,
        self::TYPE_ADMINISTRATEUR,
    ];

    // Valeurs autorisées pour statutCompte (colonne ENUM en base)
    public const STATUT_ACTIF = 'actif';
    public const STATUT_SUSPENDU = 'suspendu';

    private const STATUTS_VALIDES = [
        self::STATUT_ACTIF,
        self::STATUT_SUSPENDU,
    ];

    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $motDePasse;
    private ?string $telephone;
    private string $typeUtilisateur;
    private DateTimeImmutable $dateInscription;
    private string $statutCompte;

    /**
     * @param int|null $id null pour un utilisateur pas encore persisté
     * @param string $motDePasse mot de passe déjà haché (jamais de mot de passe en clair au niveau Domain)
     */
    public function __construct(
        ?int $id,
        string $nom,
        string $prenom,
        string $email,
        string $motDePasse,
        ?string $telephone,
        string $typeUtilisateur,
        DateTimeImmutable $dateInscription,
        string $statutCompte = self::STATUT_ACTIF
    ) {
        $this->id = $id;
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setEmail($email);
        $this->setMotDePasse($motDePasse);
        $this->telephone = $telephone;
        $this->setTypeUtilisateur($typeUtilisateur);
        $this->dateInscription = $dateInscription;
        $this->setStatutCompte($statutCompte);
    }

    // --- Validation métier (setters privés, appelés depuis le constructeur ou les comportements) ---

    private function setNom(string $nom): void
    {
        if (trim($nom) === '') {
            throw new InvalidArgumentException('Le nom ne peut pas être vide.');
        }
        $this->nom = trim($nom);
    }

    private function setPrenom(string $prenom): void
    {
        if (trim($prenom) === '') {
            throw new InvalidArgumentException('Le prénom ne peut pas être vide.');
        }
        $this->prenom = trim($prenom);
    }

    private function setEmail(string $email): void
    {
        $email = trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException(sprintf('Adresse e-mail invalide : "%s".', $email));
        }
        $this->email = strtolower($email);
    }

    private function setMotDePasse(string $motDePasseHache): void
    {
        if (trim($motDePasseHache) === '') {
            throw new InvalidArgumentException('Le mot de passe (haché) ne peut pas être vide.');
        }
        // Le hachage (password_hash) est réalisé en amont, dans la couche Application.
        $this->motDePasse = $motDePasseHache;
    }

    private function setTypeUtilisateur(string $type): void
    {
        if (!in_array($type, self::TYPES_VALIDES, true)) {
            throw new InvalidArgumentException(sprintf(
                'Type utilisateur invalide : "%s". Valeurs autorisées : %s.',
                $type,
                implode(', ', self::TYPES_VALIDES)
            ));
        }
        $this->typeUtilisateur = $type;
    }

    private function setStatutCompte(string $statut): void
    {
        if (!in_array($statut, self::STATUTS_VALIDES, true)) {
            throw new InvalidArgumentException(sprintf(
                'Statut de compte invalide : "%s". Valeurs autorisées : %s.',
                $statut,
                implode(', ', self::STATUTS_VALIDES)
            ));
        }
        $this->statutCompte = $statut;
    }

    // --- Comportements métier ---

    public function estActif(): bool
    {
        return $this->statutCompte === self::STATUT_ACTIF;
    }

    public function suspendre(): void
    {
        $this->statutCompte = self::STATUT_SUSPENDU;
    }

    public function reactiver(): void
    {
        $this->statutCompte = self::STATUT_ACTIF;
    }

    public function estParticulier(): bool
    {
        return $this->typeUtilisateur === self::TYPE_PARTICULIER;
    }

    public function estProfessionnel(): bool
    {
        return $this->typeUtilisateur === self::TYPE_PROFESSIONNEL;
    }

    public function estAdministrateur(): bool
    {
        return $this->typeUtilisateur === self::TYPE_ADMINISTRATEUR;
    }

    public function nomComplet(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    public function changerMotDePasse(string $nouveauMotDePasseHache): void
    {
        $this->setMotDePasse($nouveauMotDePasseHache);
    }

    public function changerTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    // --- Accesseurs ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getTypeUtilisateur(): string
    {
        return $this->typeUtilisateur;
    }

    public function getDateInscription(): DateTimeImmutable
    {
        return $this->dateInscription;
    }

    public function getStatutCompte(): string
    {
        return $this->statutCompte;
    }
}
