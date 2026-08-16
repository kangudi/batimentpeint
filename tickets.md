# TICKETS.md — batimentpeint.com

> Liste de tâches du projet, organisée par module.
> Une tâche = une action claire et petite (ex: "créer la table clients").
> Règle d'or MCSIA : une session de travail = une tâche prise, faite, cochée.
> À mettre à jour à chaque session (ajout, cochage, suppression).

---

## Légende des statuts

- `[ ]` À faire
- `[~]` En cours
- `[x]` Fait / testé
- `[!]` Bloqué (préciser le blocage en commentaire)

## Légende des priorités

- 🔴 Priorité haute (bloquant pour la suite)
- 🟠 Priorité moyenne
- 🟢 Priorité basse (peut attendre)

---

## Module : Core / Infrastructure

- [x] 🔴 Vérifier la config du starter-kit (connexion DB, routeur)
- [ ] 🔴 Créer le fichier `.env` / config locale
- [ ] 🟠 Mettre en place le squelette de dossiers (étape 6 MCSIA)

---

## Module : Modélisation des données (Étape 4 — MERISE)

- [x] 🔴 4.1 — MCD validé : 12 entités (`Utilisateur`, `Professionnel`, `Preuve`, `Categorie`, `Produit`, `Devis`, `LigneDevis`, `DemandeMiseEnRelation`, `Avis`, `CategorieArticle`, `Article`, `Commentaire`)
- [x] 🔴 4.2 — MLD validé : 13 tables (12 entités + table de liaison `ARTICLE_PRODUIT`)
- [x] 🔴 4.3 — MPD validé : typage MySQL, clés, contraintes (`ENUM`, `CHECK`, `DEFAULT`)
- [x] 🔴 4.4 — Script `schema.sql` généré, testé fonctionnellement (création, insertions, rejets de cas invalides, cascades) — **Étape 4 clôturée**

---

## Module : UML (Étape 5 — à démarrer)

- [ ] 🔴 5.1 — Diagramme de classes PHP (obligatoire, plan direct du code)
- [ ] 🟠 5.2 — Diagramme de cas d'utilisation (particulier / professionnel / administrateur)
- [ ] 🟢 5.3 — Diagramme(s) de séquence (uniquement pour les actions complexes, ex. validation d'un professionnel)

---

## Module : Utilisateurs

- [ ] 🔴 Créer la table `utilisateur`
- [ ] 🔴 Créer la table `professionnel` (extension, FK `id_admin_validateur`)
- [ ] 🔴 Créer la table `preuve`
- [ ] 🔴 Implémenter l'inscription / connexion (particulier, professionnel)
- [ ] 🔴 Formulaire de profil professionnel (RG7 : zone d'intervention, spécialités, 5 preuves minimum)
- [ ] 🔴 Validation d'un compte professionnel par l'administrateur (RG2), avec traçabilité admin/date
- [ ] 🟠 Gestion des comptes utilisateurs par l'admin (suspendre, supprimer)
- [ ] 🟢 Lien de contact direct WhatsApp / e-mail (transverse, pied de page)

---

## Module : Catalogue

- [ ] 🔴 Créer la table `categorie`
- [ ] 🔴 Créer la table `produit` (champs SEO : slug, meta_titre, meta_description, image + alt, mots_cles)
- [ ] 🔴 CRUD produit côté administrateur
- [ ] 🟠 Page catalogue publique (liste + filtre par catégorie)
- [ ] 🟠 Page fiche produit (SEO friendly, slug)
- [ ] 🟠 Page catégorie dédiée (SEO)

---

## Module : Devis

- [ ] 🔴 Créer la table `devis`
- [ ] 🔴 Créer la table `ligne_devis`
- [ ] 🔴 Calculateur d'estimation (quantité/coût), accessible sans connexion
- [ ] 🟠 Sauvegarde du devis en détail ligne par ligne (particulier connecté)
- [ ] 🟢 Mention "estimation indicative, non contractuelle" (RG6)

---

## Module : MiseEnRelation

- [ ] 🔴 Créer la table `demande_mise_en_relation`
- [ ] 🔴 Recherche de professionnels (zone, spécialité, note) — uniquement professionnels validés (RG2)
- [ ] 🔴 Envoi d'une demande de mise en relation (RG1 : particulier connecté uniquement)
- [ ] 🔴 Réception / acceptation / refus côté professionnel
- [ ] 🟠 Historique des demandes pour le particulier

---

## Module : Avis

- [ ] 🔴 Créer la table `avis`
- [ ] 🔴 Formulaire de dépôt d'avis (RG3 : lié à une demande de mise en relation effective)
- [ ] 🟠 Affichage des avis et de la note moyenne sur le profil professionnel
- [ ] 🟠 Modération des avis par l'administrateur (RG8 : suppression uniquement, pas de modification)

---

## Module : Statistiques

- [ ] 🟠 Tableau de bord : nombre de mises en relation, taux de conversion
- [ ] 🟠 Activité par professionnel
- [ ] 🟢 Exports (format à définir)

---

## Module : Contenu (articles / astuces SEO)

- [ ] 🔴 Créer la table `categorie_article`
- [ ] 🔴 Créer la table `article` (champs SEO : slug, meta_titre, meta_description, image + alt, mots_cles)
- [ ] 🔴 Créer la table `commentaire`
- [ ] 🔴 CRUD article côté administrateur (RG10)
- [ ] 🟠 Page liste des articles + filtre par catégorie (visiteur)
- [ ] 🟠 Page article + affichage des commentaires
- [ ] 🟠 Formulaire de commentaire (RG11 : visiteur nom/e-mail, ou particulier connecté)
- [ ] 🟠 Modération des commentaires par l'administrateur (RG12)
- [ ] 🟠 Liaison article ↔ produit (maillage interne SEO)
- [ ] 🟢 Anti-spam sur les commentaires visiteurs (captcha ou rate-limiting — cf. point de vigilance PROJET.md §8)

---

## Module : Habillage / Interface (Bootstrap + jQuery)

- [ ] 🟠 Intégrer Bootstrap dans le layout de base
- [ ] 🟢 [interaction jQuery spécifique]

---

## Tests

- [x] 🔴 Tester le script `schema.sql` : création des 13 tables sans erreur (15/08)
- [x] 🔴 Tester les contraintes du script SQL : `CHECK` sur `AVIS.note`, `UNIQUE` sur `AVIS.id_demande` (RG3), `UNIQUE` email, FK invalide rejetée, cascade `DEVIS` → `LIGNE_DEVIS` (15/08)
- [ ] 🟠 Tester chaque fonctionnalité de la liste étape 2 (une par une) — à faire une fois le code applicatif écrit
- [ ] 🟠 Tester les cas limites (champ vide, valeur invalide, non connecté) — à faire une fois le code applicatif écrit

---

## Bugs signalés après mise en ligne

- [ ] [description du bug] — signalé le [date]

---

## Notes de session

> Espace libre pour noter un blocage, une question à vérifier dans la doc officielle,
> ou une décision à reporter dans `decisions.md`.

- [12/08] : MCD (Étape 4.1) validé — 12 entités, 7 modules (ajout du module `Contenu` en cours de session pour un levier SEO éditorial). `PROJET.md` mis à jour et fusionné sur `develop` via `feature/mcd-modelisation-donnees`. Tâches des 7 modules détaillées ci-dessus, à affiner au fil de l'avancement (Étape 5+).
- [14/08] : MLD (Étape 4.2) validé — 13 tables, association `Article ↔ Produit` transformée en table de liaison `ARTICLE_PRODUIT`.
- [15/08] : MPD (Étape 4.3) validé — typage MySQL complet. Script `schema.sql` (Étape 4.4) généré puis **testé fonctionnellement** en environnement MariaDB local : création des tables, insertion d'un scénario réaliste, rejet vérifié des cas invalides, cascade de suppression confirmée. **Étape 4 (modélisation des données) entièrement clôturée.** Prochaine étape : 5 (UML — diagramme de classes).
