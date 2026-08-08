# PROJET.md — batimentpeint.com

> Ce fichier est la mémoire vive du projet. À mettre à jour à la fin de chaque session de travail.
> Dernière mise à jour : 07 Août 2026

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

**Visiteur (non connecté)**
- Le visiteur peut consulter le catalogue informatif des produits de peinture.
- Le visiteur peut utiliser le calculateur de devis (estimation quantité/coût) sans être connecté.
- Le visiteur peut consulter les fiches des professionnels (profil, avis, note moyenne).
- Le visiteur peut créer un compte (particulier ou professionnel).

**Particulier / porteur de projet (connecté)**
- Le particulier peut créer et gérer son profil.
- Le particulier peut enregistrer/sauvegarder une estimation de devis.
- Le particulier peut rechercher des professionnels (par zone, spécialité, note).
- Le particulier peut envoyer une demande de mise en relation à un professionnel.
- Le particulier peut laisser un avis et une note sur un professionnel après une prestation.
- Le particulier peut consulter l'historique de ses demandes de mise en relation.

**Professionnel (connecté)**
- Le professionnel peut créer et gérer son profil (spécialités, zone d'intervention, portfolio).
- Le professionnel peut recevoir et consulter les demandes de mise en relation.
- Le professionnel peut accepter ou refuser une demande de mise en relation.
- Le professionnel peut consulter les avis et notes reçus.
- Le professionnel doit être vérifié/validé par l'administrateur avant d'apparaître publiquement.

**Administrateur**
- L'administrateur peut valider ou rejeter l'inscription d'un professionnel.
- L'administrateur peut gérer le catalogue de produits (ajout, modification, suppression).
- L'administrateur peut modérer les avis (supprimer un avis abusif).
- L'administrateur peut consulter les statistiques de mise en relation (pour le suivi commercial/commissions).
- L'administrateur peut gérer les comptes utilisateurs (suspendre, supprimer).

### 2.2 — Règles de gestion

- **RG1** — Un particulier ne peut envoyer une demande de mise en relation que s'il est connecté.
- **RG2** — Un professionnel ne peut apparaître dans les résultats de recherche que si son compte a été validé par l'administrateur.
- **RG3** — Un particulier ne peut laisser un avis sur un professionnel que si une mise en relation a réellement eu lieu avec ce professionnel.
- **RG4** — Un professionnel ne peut pas répondre à ses propres avis en tant que particulier (pas d'auto-évaluation).
- **RG5** — Aucune transaction financière n'est gérée par la plateforme (conforme au périmètre — les paiements se font hors site).
- **RG6** — Le calculateur de devis produit une estimation indicative, non contractuelle.
- **RG7** — Un compte professionnel doit renseigner, pour être activé : au minimum une zone d'intervention à Kinshasa, ses spécialités (types de prestations proposées), et un minimum de 5 preuves vérifiables de prestations déjà réalisées (photos, références chantiers, ou équivalent).
- **RG8** — Un avis, une fois publié, ne peut être modifié par son auteur, seulement supprimé par l'administrateur en cas d'abus.

---

## 3. Stack technique

- Langage / version : PHP 8.x
- Base de données : MySQL / [version]
- Front : Bootstrap / jQuery / [autres]
- Autres dépendances : [Composer packages, etc.]

---

## 4. Architecture décidée

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

## 5. Décisions techniques prises

| Date | Décision | Raison |
|---|---|---|
| [JJ/MM] | ex: Repository pattern pour l'accès BDD | Découpler la logique métier de la persistance |

---

## 6. État d'avancement

### ✅ Fait
- Étape 0 — Initialisation projet (starter-kit, tickets.md)
- Étape 1 — Vision et périmètre du projet
- Étape 2 — Liste des fonctionnalités (2.1) et règles de gestion RG1-RG8 (2.2)

### 🔄 En cours
- [élément en cours, avec le blocage éventuel]

### ⏳ À faire
- Étape 3 — Découpage en blocs/modules

---

## 7. Points de vigilance / risques connus

- [ex: fonction X pas encore testée en charge]
- [ex: dépendance à vérifier avec la doc officielle avant usage]

---

## 8. Instructions pour Claude (à coller aussi dans les Custom Instructions du Projet)

> Avant toute proposition de code, rappelle en une ligne l'état actuel du projet selon ce fichier.
> Si une information manque ou n'est pas dans ce fichier, demande plutôt que de supposer.
> Ne jamais inventer une méthode, fonction ou syntaxe PHP sans certitude — vérifier via la doc officielle si besoin.
