# PROJET.md — batimentpeint.com

> Ce fichier est la mémoire vive du projet. À mettre à jour à la fin de chaque session de travail.
> Dernière mise à jour : 12 Août 2026

---

## 1. Objectif du projet

**Vision (Étape 1.1 — MCSIA)** :

batimentpeint.com est une plateforme web de référence à Kinshasa dédiée à la rénovation et à la peinture des bâtiments. Elle centralise l'information technique (choix des produits, calcul des quantités nécessaires) et met en relation les particuliers ou porteurs de projet (nouvelle construction ou rénovation) avec des professionnels qualifiés de la peinture en bâtiment.

**Utilisateurs cibles :**
- Les particuliers et professionnels ayant un besoin de rénovation ou de prestation de peinture (neuf ou existant) ;
- Les prestataires professionnels de peinture bâtiment, qui proposent leurs services sur la plateforme ;
- L'administrateur du site, qui supervise l'ensemble.

**Problème résolu :** aujourd'hui, une personne qui veut rénover ou peindre un bâtiment à Kinshasa ne sait souvent ni quel produit choisir, ni quelle quantité acheter, ni comment trouver un prestataire fiable et qualifié. La plateforme répond à ces trois points en un seul endroit : information produit, estimation de quantité/coût, et mise en relation avec un professionnel vérifié.

**Modèle économique :** commission prélevée sur les marchés conclus grâce à la mise en relation via la plateforme.

**But métier** : Le projet "batimentpeint.com" est une plateforme web dédiée à la rénovation et à la peinture des bâtiments, principalement pour le marché de Kinshasa, qui aide les particuliers à choisir les peintures et à estimer le coût de leurs travaux. Elle met en relation les clients avec des professionnels et des fournisseurs de peinture grâce à un catalogue, un calculateur de devis et un suivi commercial. Son objectif est de générer des revenus par des commissions sur les prestations et les ventes réalisées via la plateforme.

**Périmètre (Étape 1.2 — MCSIA)** :

*Ce que le logiciel FERA :*
- Informer l'utilisateur sur les produits de peinture bâtiment adaptés à son projet ;
- Estimer les quantités et le coût des travaux (calculateur de devis) ;
- Mettre en relation les particuliers/porteurs de projet avec des professionnels qualifiés de la peinture ;
- Mettre en relation les utilisateurs avec des fournisseurs de peinture (catalogue informatif) ;
- Permettre aux clients de laisser un avis/notation sur les professionnels, dès la première version ;
- Publier des articles et astuces éditoriaux (conseils peinture/rénovation) à visée SEO, pour attirer du trafic organique en amont du besoin ;
- Fonctionner uniquement en tant que site web (pas d'application mobile prévue à ce stade).

*Ce que le logiciel NE FERA PAS (pour cette version) :*
- Aucun paiement en ligne sur la plateforme — les transactions se font directement entre le client et le professionnel/fournisseur, en dehors du site ;
- Aucune vente directe de produits de peinture par la plateforme elle-même (pas de commande/livraison gérée en interne) ;
- Aucune application mobile (site web uniquement) ;
- Aucune activité hors du secteur peinture bâtiment, ni hors de Kinshasa.

Domaine de peinture bâtiment à Kinshasa principalement / Pas en dehors du Congo Kinshasa, pas d'autre domaine que la peinture

---

## 2. Fonctionnalités et règles de gestion (Étape 2 — MCSIA)

### 2.1 — Fonctionnalités (par type d'utilisateur)

**Transverse (tous utilisateurs, y compris visiteur)**
- Tout utilisateur peut contacter l'administrateur via un lien direct WhatsApp ou e-mail (mailto), affiché en pied de page ou sur une page "Contact". Aucune donnée n'est enregistrée par la plateforme pour ce canal.

**Visiteur (non connecté)**
- Le visiteur peut consulter le catalogue informatif des produits de peinture.
- Le visiteur peut utiliser le calculateur de devis (estimation quantité/coût) sans être connecté.
- Le visiteur peut consulter les fiches des professionnels (profil, avis, note moyenne).
- Le visiteur peut créer un compte (particulier ou professionnel).
- Le visiteur peut consulter les articles/astuces publiés sur le blog (module Contenu), filtrables par catégorie.
- Le visiteur peut laisser un commentaire sur un article, en renseignant un nom et un e-mail.

**Particulier / porteur de projet (connecté)**
- Le particulier peut créer et gérer son profil.
- Le particulier peut enregistrer/sauvegarder une estimation de devis (détail ligne par ligne des produits/quantités).
- Le particulier peut rechercher des professionnels (par zone, spécialité, note).
- Le particulier peut envoyer une demande de mise en relation à un professionnel.
- Le particulier peut laisser un avis et une note sur un professionnel après une prestation.
- Le particulier peut consulter l'historique de ses demandes de mise en relation.
- Le particulier peut laisser un commentaire sur un article, en étant identifié via son compte.

**Professionnel (connecté)**
- Le professionnel peut créer et gérer son profil (spécialités en texte libre, zone(s) d'intervention en texte libre, portfolio).
- Le professionnel peut recevoir et consulter les demandes de mise en relation.
- Le professionnel peut accepter ou refuser une demande de mise en relation.
- Le professionnel peut consulter les avis et notes reçus.
- Le professionnel doit être vérifié/validé par l'administrateur avant d'apparaître publiquement.

**Administrateur**
- L'administrateur peut valider ou rejeter l'inscription d'un professionnel (traçabilité : admin validateur et date de validation conservés).
- L'administrateur peut gérer le catalogue de produits (ajout, modification, suppression), incluant les champs SEO (slug, meta-titre, meta-description, image + texte alternatif, mots-clés).
- L'administrateur peut gérer les catégories de produits (entité dédiée, pour des pages de catégorie SEO).
- L'administrateur peut modérer les avis (supprimer un avis abusif).
- L'administrateur peut consulter les statistiques de mise en relation (pour le suivi commercial/commissions).
- L'administrateur peut gérer les comptes utilisateurs (suspendre, supprimer).
- L'administrateur peut créer, modifier, publier/dépublier et supprimer un article (module Contenu), avec champs SEO dédiés.
- L'administrateur peut catégoriser un article via une taxonomie propre au module Contenu.
- L'administrateur peut lier un article à un ou plusieurs produits du catalogue (maillage interne SEO).
- L'administrateur peut modérer les commentaires laissés sur les articles.

### 2.2 — Règles de gestion

- **RG1** — Un particulier ne peut envoyer une demande de mise en relation que s'il est connecté.
- **RG2** — Un professionnel ne peut apparaître dans les résultats de recherche que si son compte a été validé par l'administrateur.
- **RG3** — Un particulier ne peut laisser un avis sur un professionnel que si une mise en relation a réellement eu lieu avec ce professionnel.
- **RG4** — Un professionnel ne peut pas répondre à ses propres avis en tant que particulier (pas d'auto-évaluation).
- **RG5** — Aucune transaction financière n'est gérée par la plateforme (conforme au périmètre — les paiements se font hors site).
- **RG6** — Le calculateur de devis produit une estimation indicative, non contractuelle.
- **RG7** — Un compte professionnel doit renseigner, pour être activé : au minimum une zone d'intervention à Kinshasa, ses spécialités (types de prestations proposées), et un minimum de 5 preuves vérifiables de prestations déjà réalisées (photos, références chantiers, ou équivalent).
- **RG8** — Un avis, une fois publié, ne peut être modifié par son auteur, seulement supprimé par l'administrateur en cas d'abus.
- **RG9** — Un article n'est visible publiquement que si son statut est "publié".
- **RG10** — Seul l'administrateur peut créer et publier un article (en v1).
- **RG11** — Un commentaire peut être laissé par un visiteur non connecté (nom/e-mail requis) ou par un particulier connecté.
- **RG12** — L'administrateur peut modérer un commentaire (le supprimer en cas d'abus), sur le même principe que pour les avis (RG8).

---

## 3. Découpage en blocs / modules (Étape 3 — MCSIA)

En regroupant les fonctionnalités de la section 2.1 par cohérence métier, le projet est découpé en **7 modules** :

**1. Module `Utilisateurs`**
Gestion des comptes (particulier, professionnel, administrateur), authentification, profils. Inclut la validation d'un compte professionnel par l'administrateur (RG7 : zone d'intervention, spécialités, 5 preuves vérifiables), avec traçabilité de l'admin validateur. Inclut également l'affichage du canal de contact direct vers l'administrateur (WhatsApp/e-mail).

**2. Module `Catalogue`**
Fiches informatives des produits de peinture bâtiment, organisées par catégories dédiées, consultables par tout visiteur. Fiches enrichies de champs SEO (slug, meta-titre, meta-description, image + alt, mots-clés, dates de publication/mise à jour, statut). Gestion (ajout/modification/suppression) réservée à l'administrateur.

**3. Module `Devis`**
Le calculateur d'estimation (quantité/coût), accessible sans connexion, avec possibilité de sauvegarde détaillée ligne par ligne (produits + quantités) pour un particulier connecté. Estimation non contractuelle (RG6).

**4. Module `MiseEnRelation`**
Recherche de professionnels (zone, spécialité, note), envoi de demandes par un particulier, réception/acceptation/refus côté professionnel, historique des demandes. Ne concerne que des professionnels validés (RG2).

**5. Module `Avis`**
Dépôt d'un avis/note par un particulier après une mise en relation effective (RG3), consultation par le professionnel, modération par l'administrateur (RG8).

**6. Module `Statistiques`**
Reporting et suivi commercial pour l'administrateur (nombre de mises en relation, taux de conversion, activité par professionnel, etc.), utilisé pour le pilotage du modèle de commission. S'appuie sur les données du module `MiseEnRelation`, mais reste isolé comme module autonome pour permettre une évolution indépendante (ex. tableaux de bord, exports).

**7. Module `Contenu`** *(ajouté le 12/08/2026)*
Gestion éditoriale d'articles et astuces (ex. "comment traiter l'humidité sur un mur") à visée SEO, avec taxonomie propre (catégories d'articles), champs SEO dédiés, et système de commentaires modérés (visiteurs et particuliers). Lié au module `Catalogue` via un maillage interne (article ↔ produit) pour renforcer le référencement. Rédaction réservée à l'administrateur en v1 (RG10).

---

## 4. Stack technique

- Langage / version : PHP 8.x
- Base de données : MySQL / [version]
- Front : Bootstrap / jQuery / [autres]
- Autres dépendances : [Composer packages, etc.]

---

## 5. Architecture décidée

**Structure des dossiers** :
```
/src
  /Domain
  /Application
  /Infrastructure
/public
/tests
...
```

**Classes / modules principaux** :
| Classe / Module | Rôle | Statut |
|---|---|---|
| ex: `UserRepository` | Accès aux données utilisateurs | ✅ Fait |
| ex: `InvoiceService` | Logique de facturation | 🔄 En cours |

**Conventions de nommage** : [PascalCase pour les classes, snake_case pour les tables, etc.]

---

## 6. Décisions techniques prises

| Date | Décision | Raison |
|---|---|---|
| [JJ/MM] | ex: Repository pattern pour l'accès BDD | Découpler la logique métier de la persistance |
| 12/08 | Devis stocké en détail ligne par ligne (entité `LigneDevis`) | Permet un historique précis produit/quantité, réutilisable pour les stats |
| 12/08 | Zone d'intervention et spécialités du professionnel en texte libre (pas de référentiel fermé) | Simplicité v1, flexibilité du discours des professionnels |
| 12/08 | Catégorie de produit en entité dédiée (`Categorie`) | Pages de catégorie SEO, fil d'Ariane, URLs propres |
| 12/08 | Ajout du module `Contenu` (articles/astuces) en scope additionnel | Levier d'acquisition de trafic organique (SEO) en amont du besoin |
| 12/08 | Taxonomie d'articles distincte de la taxonomie produit | Les rubriques éditoriales ne recoupent pas nécessairement les catégories catalogue |
| 12/08 | Commentaires ouverts aux visiteurs non connectés (nom/e-mail) | Maximiser l'engagement et le contenu généré, cohérent avec un objectif SEO |

---

## 7. État d'avancement

### ✅ Fait
- Étape 0 — Initialisation projet (starter-kit, tickets.md)
- Étape 1 — Vision et périmètre du projet
- Étape 2 — Liste des fonctionnalités (2.1, incluant le contact admin transverse et le module Contenu) et règles de gestion RG1-RG12 (2.2)
- Étape 3 — Découpage en 7 blocs/modules (Utilisateurs, Catalogue, Devis, MiseEnRelation, Avis, Statistiques, Contenu)
- Étape 4.1 — MCD validé : 12 entités (`Utilisateur`, `Professionnel`, `Preuve`, `Categorie`, `Produit`, `Devis`, `LigneDevis`, `DemandeMiseEnRelation`, `Avis`, `CategorieArticle`, `Article`, `Commentaire`)

### 🔄 En cours
- Étape 4.2 — MLD (transformation du MCD en tableaux/colonnes)

### ⏳ À faire
- Étape 4.2 — MLD
- Étape 4.3 — MPD
- Étape 4.4 — Script MySQL de création des tables

---

## 8. Points de vigilance / risques connus

- [ex: fonction X pas encore testée en charge]
- [ex: dépendance à vérifier avec la doc officielle avant usage]
- RG7 (minimum 5 preuves) est une règle métier non modélisable par une cardinalité MCD stricte : à faire respecter au niveau applicatif (Étape 7).
- Les commentaires de visiteurs non connectés (RG11) nécessitent une vigilance anti-spam à prévoir en Étape 7 (captcha, rate-limiting, ou modération a priori à trancher plus tard).

---

## 9. Instructions pour Claude (à coller aussi dans les Custom Instructions du Projet)

> Avant toute proposition de code, rappelle en une ligne l'état actuel du projet selon ce fichier.
> Si une information manque ou n'est pas dans ce fichier, demande plutôt que de supposer.
> Ne jamais inventer une méthode, fonction ou syntaxe PHP sans certitude — vérifier via la doc officielle si besoin.
