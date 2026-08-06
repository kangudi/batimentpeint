# PROJET.md — batimentpeint.com

> Ce fichier est la mémoire vive du projet. À mettre à jour à la fin de chaque session de travail.
> Dernière mise à jour : 06 Août 2026

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

## 2. Stack technique

- Langage / version : PHP 8.x
- Base de données : MySQL / [version]
- Front : Bootstrap / jQuery / [autres]
- Autres dépendances : [Composer packages, etc.]

---

## 3. Architecture décidée

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

## 4. Décisions techniques prises

| Date | Décision | Raison |
|---|---|---|
| [JJ/MM] | ex: Repository pattern pour l'accès BDD | Découpler la logique métier de la persistance |

---

## 5. État d'avancement

### ✅ Fait
- [élément terminé et testé]

### 🔄 En cours
- [élément en cours, avec le blocage éventuel]

### ⏳ À faire
- [prochaine étape prévue]

---

## 6. Points de vigilance / risques connus

- [ex: fonction X pas encore testée en charge]
- [ex: dépendance à vérifier avec la doc officielle avant usage]

---

## 7. Instructions pour Claude (à coller aussi dans les Custom Instructions du Projet)

> Avant toute proposition de code, rappelle en une ligne l'état actuel du projet selon ce fichier.
> Si une information manque ou n'est pas dans ce fichier, demande plutôt que de supposer.
> Ne jamais inventer une méthode, fonction ou syntaxe PHP sans certitude — vérifier via la doc officielle si besoin.
