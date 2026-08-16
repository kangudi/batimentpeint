-- ============================================================
-- batimentpeint.com — Script de création de la base de données
-- Étape 4.4 (MCSIA) — Généré à partir du MPD validé le 14/08/2026
-- MySQL 8.x — Moteur InnoDB, charset utf8mb4
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- Creation de la base de données
-- ------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS batimentpeint CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE batimentpeint;


-- ------------------------------------------------------------
-- Module Utilisateurs
-- ------------------------------------------------------------

CREATE TABLE UTILISATEUR (
    id_utilisateur      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom                  VARCHAR(100)  NOT NULL,
    prenom               VARCHAR(100)  NOT NULL,
    email                VARCHAR(190)  NOT NULL,
    mot_de_passe         VARCHAR(255)  NOT NULL,
    telephone            VARCHAR(20)   NULL,
    type_utilisateur     ENUM('particulier','professionnel','administrateur') NOT NULL,
    date_inscription     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut_compte        ENUM('actif','suspendu') NOT NULL DEFAULT 'actif',
    UNIQUE KEY uq_utilisateur_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE PROFESSIONNEL (
    id_professionnel     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur       INT UNSIGNED  NOT NULL,
    zone_intervention    VARCHAR(255)  NOT NULL,
    specialites          TEXT          NOT NULL,
    statut_validation    ENUM('en_attente','valide','rejete') NOT NULL DEFAULT 'en_attente',
    date_validation       DATETIME      NULL,
    id_admin_validateur  INT UNSIGNED  NULL,
    UNIQUE KEY uq_professionnel_utilisateur (id_utilisateur),
    CONSTRAINT fk_professionnel_utilisateur
        FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR(id_utilisateur)
        ON DELETE CASCADE,
    CONSTRAINT fk_professionnel_admin_validateur
        FOREIGN KEY (id_admin_validateur) REFERENCES UTILISATEUR(id_utilisateur)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE PREUVE (
    id_preuve            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_professionnel     INT UNSIGNED  NOT NULL,
    type_preuve          VARCHAR(50)   NOT NULL,
    chemin_fichier       VARCHAR(255)  NOT NULL,
    date_ajout           DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_preuve_professionnel
        FOREIGN KEY (id_professionnel) REFERENCES PROFESSIONNEL(id_professionnel)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Module Catalogue
-- ------------------------------------------------------------

CREATE TABLE CATEGORIE (
    id_categorie         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom                  VARCHAR(100)  NOT NULL,
    slug                 VARCHAR(150)  NOT NULL,
    description          TEXT          NULL,
    meta_titre           VARCHAR(160)  NULL,
    meta_description     VARCHAR(320)  NULL,
    image_categorie      VARCHAR(255)  NULL,
    UNIQUE KEY uq_categorie_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE PRODUIT (
    id_produit           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_categorie         INT UNSIGNED  NOT NULL,
    nom                  VARCHAR(150)  NOT NULL,
    slug                 VARCHAR(180)  NOT NULL,
    description_courte   VARCHAR(300)  NULL,
    description_longue   TEXT          NULL,
    marque               VARCHAR(100)  NULL,
    unite                VARCHAR(30)   NULL,
    rendement            DECIMAL(6,2)  NULL,
    prix_indicatif       DECIMAL(10,2) NULL,
    image_principale     VARCHAR(255)  NULL,
    texte_alt_image      VARCHAR(150)  NULL,
    meta_titre           VARCHAR(160)  NULL,
    meta_description     VARCHAR(320)  NULL,
    mots_cles            VARCHAR(255)  NULL,
    date_publication     DATETIME      NULL,
    date_maj             DATETIME      NULL,
    statut_publication   ENUM('brouillon','publie') NOT NULL DEFAULT 'brouillon',
    UNIQUE KEY uq_produit_slug (slug),
    CONSTRAINT fk_produit_categorie
        FOREIGN KEY (id_categorie) REFERENCES CATEGORIE(id_categorie)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Module Devis
-- ------------------------------------------------------------

CREATE TABLE DEVIS (
    id_devis             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur       INT UNSIGNED  NOT NULL,
    date_creation        DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    surface_totale       DECIMAL(8,2)  NULL,
    cout_total_estime    DECIMAL(12,2) NULL,
    statut               ENUM('brouillon','finalise') NOT NULL DEFAULT 'brouillon',
    CONSTRAINT fk_devis_utilisateur
        FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR(id_utilisateur)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE LIGNE_DEVIS (
    id_ligne_devis       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_devis             INT UNSIGNED  NOT NULL,
    id_produit           INT UNSIGNED  NOT NULL,
    quantite             DECIMAL(8,2)  NOT NULL,
    surface_associee     DECIMAL(8,2)  NULL,
    cout_ligne           DECIMAL(10,2) NULL,
    CONSTRAINT fk_lignedevis_devis
        FOREIGN KEY (id_devis) REFERENCES DEVIS(id_devis)
        ON DELETE CASCADE,
    CONSTRAINT fk_lignedevis_produit
        FOREIGN KEY (id_produit) REFERENCES PRODUIT(id_produit)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Module MiseEnRelation
-- ------------------------------------------------------------

CREATE TABLE DEMANDE_MISE_EN_RELATION (
    id_demande           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur       INT UNSIGNED  NOT NULL,
    id_professionnel     INT UNSIGNED  NOT NULL,
    date_demande         DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut               ENUM('en_attente','acceptee','refusee') NOT NULL DEFAULT 'en_attente',
    message              TEXT          NULL,
    CONSTRAINT fk_demande_utilisateur
        FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR(id_utilisateur)
        ON DELETE CASCADE,
    CONSTRAINT fk_demande_professionnel
        FOREIGN KEY (id_professionnel) REFERENCES PROFESSIONNEL(id_professionnel)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Module Avis
-- ------------------------------------------------------------

CREATE TABLE AVIS (
    id_avis              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_demande           INT UNSIGNED  NOT NULL,
    note                 TINYINT UNSIGNED NOT NULL,
    commentaire          TEXT          NULL,
    date_avis            DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut_moderation    ENUM('visible','masque') NOT NULL DEFAULT 'visible',
    UNIQUE KEY uq_avis_demande (id_demande),
    CONSTRAINT fk_avis_demande
        FOREIGN KEY (id_demande) REFERENCES DEMANDE_MISE_EN_RELATION(id_demande)
        ON DELETE CASCADE,
    CONSTRAINT chk_avis_note CHECK (note BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Module Contenu
-- ------------------------------------------------------------

CREATE TABLE CATEGORIE_ARTICLE (
    id_categorie_article INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom                  VARCHAR(100)  NOT NULL,
    slug                 VARCHAR(150)  NOT NULL,
    description          TEXT          NULL,
    meta_titre           VARCHAR(160)  NULL,
    meta_description     VARCHAR(320)  NULL,
    UNIQUE KEY uq_categoriearticle_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ARTICLE (
    id_article           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur       INT UNSIGNED  NOT NULL,
    id_categorie_article INT UNSIGNED  NOT NULL,
    titre                VARCHAR(200)  NOT NULL,
    slug                 VARCHAR(220)  NOT NULL,
    extrait              VARCHAR(300)  NULL,
    contenu              LONGTEXT      NOT NULL,
    image_principale     VARCHAR(255)  NULL,
    texte_alt_image      VARCHAR(150)  NULL,
    meta_titre           VARCHAR(160)  NULL,
    meta_description     VARCHAR(320)  NULL,
    mots_cles            VARCHAR(255)  NULL,
    date_publication     DATETIME      NULL,
    date_maj             DATETIME      NULL,
    statut_publication   ENUM('brouillon','publie') NOT NULL DEFAULT 'brouillon',
    UNIQUE KEY uq_article_slug (slug),
    CONSTRAINT fk_article_utilisateur
        FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR(id_utilisateur)
        ON DELETE RESTRICT,
    CONSTRAINT fk_article_categoriearticle
        FOREIGN KEY (id_categorie_article) REFERENCES CATEGORIE_ARTICLE(id_categorie_article)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE COMMENTAIRE (
    id_commentaire       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_article           INT UNSIGNED  NOT NULL,
    id_utilisateur       INT UNSIGNED  NULL,
    nom_auteur           VARCHAR(100)  NULL,
    email_auteur         VARCHAR(190)  NULL,
    contenu              TEXT          NOT NULL,
    date_commentaire     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut_moderation    ENUM('visible','masque') NOT NULL DEFAULT 'visible',
    CONSTRAINT fk_commentaire_article
        FOREIGN KEY (id_article) REFERENCES ARTICLE(id_article)
        ON DELETE CASCADE,
    CONSTRAINT fk_commentaire_utilisateur
        FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR(id_utilisateur)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ARTICLE_PRODUIT (
    id_article           INT UNSIGNED  NOT NULL,
    id_produit           INT UNSIGNED  NOT NULL,
    PRIMARY KEY (id_article, id_produit),
    CONSTRAINT fk_articleproduit_article
        FOREIGN KEY (id_article) REFERENCES ARTICLE(id_article)
        ON DELETE CASCADE,
    CONSTRAINT fk_articleproduit_produit
        FOREIGN KEY (id_produit) REFERENCES PRODUIT(id_produit)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
