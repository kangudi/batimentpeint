-- Migration : 0001_create_clients_table
-- À QUOI ÇA SERT : crée la table "clients", traduction directe du MPD (étape 4.3).
-- POURQUOI C'EST IMPORTANT : chaque changement de structure de base passe par
-- un fichier de migration numéroté et versionné dans Git. On ne modifie
-- JAMAIS une table à la main sur le serveur : on ne saurait plus reproduire
-- la base sur une autre machine ou revenir en arrière en cas d'erreur.

CREATE TABLE IF NOT EXISTS clients (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Un même e-mail ne doit pas pouvoir être utilisé deux fois (RG1 côté base).
    UNIQUE KEY uniq_clients_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
