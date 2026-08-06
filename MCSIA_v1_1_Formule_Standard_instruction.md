# MCSIA v1.1 — Formule Standard
### La même recette, dans le même ordre, sur chaque projet

**Règle simple : tu suis les étapes 0 à 11 dans l'ordre, à chaque projet, sans en sauter une.**
Peu importe la taille du projet (petit ou gros), tu fais toujours ces 12 étapes. Ce qui change, c'est juste le temps que tu passes sur chacune — pas l'ordre, pas la liste.

Chaque étape te dit :
- **Ce que tu fais** (en mots simples)
- **Ce que tu dois avoir en main à la fin** (le "livrable" — le résultat concret)

---

## Étape 0 — Avant de commencer à coder (5 minutes, obligatoire)

0.1. Ouvrir ton starter-kit (le squelette de projet que tu réutilises à chaque fois — dossiers, connexion à la base, etc.). Ne jamais repartir d'une page vide.

0.2. Créer une liste de tâches (des "tickets") — une tâche = une petite action claire, du genre "créer la table clients" ou "écrire le formulaire de connexion".

0.3. **Règle d'or :** une session de travail = tu prends UNE tâche dans ta liste, tu la fais, tu la coches. Tu ne réfléchis jamais à "tout le projet" en même temps. Ça, c'est ce qui te fait perdre le fil.

---

## Étape 1 — Comprendre le projet (Vision)

1.1. Écrire en quelques phrases : *à quoi sert ce logiciel ? qui va l'utiliser ? qu'est-ce que ça résout comme problème ?*

1.2. Écrire les limites du projet : *qu'est-ce que le logiciel va faire, et qu'est-ce qu'il ne fera PAS* (pour ne pas t'éparpiller).

**Résultat à la fin :** un texte d'une demi-page maximum. Pas plus.

---

## Étape 2 — Lister ce que le logiciel doit faire

2.1. Écrire une liste de phrases simples du type : "L'utilisateur peut créer un compte", "L'administrateur peut voir la liste des commandes".

2.2. Écrire les règles importantes à respecter. Exemple : "Un client ne peut pas commander sans être connecté". Tu les numérotes (RG1, RG2, RG3...) pour pouvoir les retrouver plus tard.

**Résultat à la fin :** une liste de fonctionnalités + une liste de règles numérotées.

---

## Étape 3 — Découper le projet en blocs (modules)

3.1. Regarder ta liste de l'étape 2 et regrouper les fonctionnalités qui vont ensemble. Exemple : tout ce qui concerne les clients = bloc "Clients". Tout ce qui concerne les commandes = bloc "Commandes".

3.2. Ces blocs deviendront plus tard des dossiers dans ton code (étape 6).

**Résultat à la fin :** une liste de 2 à 5 blocs (modules) avec un nom simple pour chacun.

---

## Étape 4 — Dessiner les données (Merise)

4.1. **MCD** : dessiner sur papier ou dans un outil les "choses" que ton logiciel doit mémoriser (Client, Commande, Produit...) et comment elles sont liées entre elles (un Client passe plusieurs Commandes).

4.2. **MLD** : transformer ce dessin en tableaux, avec les colonnes de chaque tableau.

4.3. **MPD** : écrire le vrai code MySQL qui crée ces tableaux (les vraies tables avec leurs types de colonnes).

4.4. Ajouter tout de suite : les clés (identifiants uniques), les liens entre tables (clés étrangères), et les colonnes qui ne doivent jamais être vides.

**Résultat à la fin :** un fichier `.sql` que tu peux exécuter pour créer ta base de données.

---

## Étape 5 — Dessiner comment ça marche (UML)

5.1. **Obligatoire :** dessiner le "diagramme de classes" — la liste des classes PHP que tu vas créer, avec leurs informations (attributs) et leurs actions (méthodes). C'est le plan direct de ton code.

5.2. **Si plusieurs types d'utilisateurs** (client, admin...) : dessiner le "diagramme de cas d'utilisation" — qui a le droit de faire quoi.

5.3. **Seulement si une action est compliquée** (paiement, envoi d'email automatique...) : dessiner un "diagramme de séquence" — l'ordre exact des étapes.

**Résultat à la fin :** au minimum, un diagramme de classes clair et complet.

---

## Étape 6 — Organiser les dossiers de ton projet

6.1. Créer un dossier par bloc/module (défini à l'étape 3). Exemple :
```
app/
  Clients/
  Commandes/
  Core/       (ce qui sert à tout le projet : connexion DB, routeur)
  Shared/     (les morceaux de code réutilisables : upload, pagination...)
```

6.2. Dans chaque dossier de module, séparer toujours les mêmes 4 sous-dossiers :
```
Clients/
  Domain/          (les règles métier pures, sans base de données)
  Application/     (les services : ce qui fait le travail)
  Infrastructure/  (l'accès à MySQL)
  Presentation/     (les contrôleurs et les pages)
```

6.3. Si une décision technique importante est prise (ex : "pourquoi j'utilise telle méthode plutôt qu'une autre"), écrire une phrase dans un fichier `decisions.md`. Ça prend 2 minutes et ça t'évite de te reposer la même question dans 3 mois.

**Résultat à la fin :** l'arborescence de dossiers vide mais prête, avant d'écrire le moindre code métier.

---

## Étape 7 — Écrire le code PHP (module par module)

7.1. Prendre UN module à la fois (jamais tous en même temps).

7.2. À l'intérieur du module, toujours dans cet ordre :
   1. Écrire la classe métier (Domain) — l'objet et ses règles.
   2. Écrire le service (Application) — ce qui utilise l'objet pour faire une action.
   3. Écrire le repository (Infrastructure) — ce qui va chercher/sauvegarde en base MySQL.
   4. Écrire le contrôleur (Presentation) — ce qui reçoit la demande de l'utilisateur et appelle le service.

7.3. Règles à respecter à chaque fichier que tu écris :
   - Toujours utiliser des requêtes préparées pour parler à MySQL (jamais de texte collé directement dans une requête → ça évite le piratage par injection SQL).
   - Toujours vérifier/nettoyer ce que l'utilisateur envoie (formulaires).
   - Une classe = une seule responsabilité claire.

7.4. Écrire un petit test pour vérifier que ton service fait bien ce qu'il doit faire, tout de suite après l'avoir écrit — pas à la fin du projet.

**Résultat à la fin d'un module :** le module fonctionne tout seul, testé, avant de passer au suivant.

---

## Étape 8 — Habiller l'interface (Bootstrap + jQuery)

8.1. Utiliser Bootstrap pour la mise en page (grille, boutons, formulaires, tableaux) — tu n'inventes pas de CSS à chaque fois.

8.2. Utiliser jQuery uniquement pour les interactions (envoyer un formulaire sans recharger la page, afficher un message de succès/erreur).

8.3. Tu peux faire cette étape en même temps que l'étape 7, une fois que le contrôleur du module existe — inutile d'attendre la fin de tout le projet.

**Résultat à la fin :** des pages qui s'affichent bien et réagissent aux actions de l'utilisateur.

---

## Étape 9 — Tester

9.1. Vérifier que chaque fonctionnalité de la liste de l'étape 2 fonctionne vraiment, une par une.

9.2. Essayer volontairement de "casser" le logiciel (champ vide, mauvaise valeur, utilisateur non connecté) pour vérifier que ça ne plante pas.

**Résultat à la fin :** une liste cochée des fonctionnalités qui marchent, et les bugs trouvés corrigés.

---

## Étape 10 — Mettre en ligne (déploiement)

10.1. Sauvegarder ton code (Git) avant de mettre en ligne.

10.2. Créer la base de données sur le serveur en exécutant ton fichier `.sql` (étape 4.3) — jamais en créant les tables à la main sur le serveur.

10.3. Copier le code sur le serveur, vérifier que tout s'affiche et fonctionne (test rapide des fonctionnalités principales).

**Résultat à la fin :** le projet est accessible et utilisable en ligne.

---

## Étape 11 — Suivre et améliorer

11.1. Noter les bugs signalés après la mise en ligne dans une liste.

11.2. Pour chaque nouvelle demande (évolution), tu recommences un mini-cycle : retour à l'étape 2 (juste pour cette demande), puis 4 → 5 → 6 → 7 si besoin, uniquement sur le module concerné. Jamais tout le projet.

11.3. À la fin du projet, prendre 15 minutes : qu'est-ce que je peux garder pour le prochain projet ? (un bout de code, un composant Bootstrap, une leçon apprise) → tu l'ajoutes à ton starter-kit (étape 0.1).

---

## Carte mémo — à garder sous les yeux

```
0. Préparer (starter-kit + liste de tâches)
1. Comprendre le projet
2. Lister les fonctionnalités + règles
3. Découper en blocs (modules)
4. Dessiner les données (MCD → MLD → MPD → MySQL)
5. Dessiner le fonctionnement (diagramme de classes minimum)
6. Organiser les dossiers du code
7. Écrire le code, module par module
8. Habiller (Bootstrap + jQuery)
9. Tester
10. Mettre en ligne
11. Suivre et améliorer
```

**La seule règle à ne jamais casser : tu ne sautes pas d'étape, et tu avances toujours UN module et UNE tâche à la fois.**

# Annexe A — Workflow de validation et gestion Git (Complément à MCSIA)

> Cette annexe complète la méthode MCSIA sans modifier les étapes 0 à 11. Toutes les règles ci-dessous s'appliquent pendant l'exécution des étapes existantes.

## A.1 Validation obligatoire avant toute progression

À la fin de chaque tâche ou sous-étape réalisée, interrompre le développement et présenter systématiquement :

* un résumé des travaux réalisés ;
* la liste des fichiers créés ;
* la liste des fichiers modifiés ;
* les impacts éventuels sur les autres modules ;
* les tests à effectuer ou déjà réalisés.

Une fois ce récapitulatif présenté, attendre obligatoirement une validation explicite de l'utilisateur avant de poursuivre.

Les validations acceptées sont par exemple :

* OK
* Valider
* Continuer
* Étape validée

Aucune nouvelle tâche, aucun nouveau développement et aucune modification supplémentaire ne doivent être réalisés tant que cette validation n'a pas été donnée.

---

## A.2 Gestion Git obligatoire

Après chaque validation de l'utilisateur, proposer les commandes Git adaptées à l'état réel du projet.

Ne jamais proposer des commandes inutiles.

Selon le contexte, proposer uniquement les commandes pertinentes :

* création d'une branche ;
* consultation de l'état du dépôt (`git status`) ;
* ajout des fichiers (`git add`) ;
* création du commit ;
* synchronisation avec le dépôt distant (`git fetch`, `git pull`, `git push`) ;
* fusion de branche (`merge`) lorsque la fonctionnalité est terminée.

Les messages de commit doivent suivre la convention **Conventional Commits**, par exemple :

* `feat:`
* `fix:`
* `refactor:`
* `docs:`
* `style:`
* `test:`
* `perf:`
* `chore:`

Chaque message doit être précis, concis et représenter exactement les modifications réalisées.

---

## A.3 Une fonctionnalité = une branche Git

Toute nouvelle fonctionnalité, évolution ou amélioration doit être développée dans une branche Git dédiée.

Ne jamais développer directement sur `main` ou `develop`.

Avant de commencer une nouvelle fonctionnalité, proposer systématiquement un nom de branche conforme aux conventions Git Flow.

Exemples :

* `feature/auth-login`
* `feature/export-pdf`
* `feature/dashboard`
* `feature/api-users`
* `fix/login-error`
* `fix/pdf-generation`
* `refactor/user-service`

Le nom proposé doit être cohérent avec la fonctionnalité demandée.

---

## A.4 Fin d'une fonctionnalité

Lorsqu'une fonctionnalité est entièrement développée et validée :

1. proposer les commandes Git permettant de finaliser le travail ;
2. proposer la fusion vers la branche cible appropriée (`develop` ou `main`) selon le contexte du projet ;
3. proposer le nettoyage éventuel de la branche devenue inutile.

---

## A.5 Règle permanente

Pendant toute la durée du projet :

* ne jamais enchaîner plusieurs tâches sans validation ;
* ne jamais passer à une autre fonctionnalité sans clôturer la précédente ;
* toujours proposer les actions Git adaptées avant de poursuivre ;
* toujours créer une nouvelle branche pour toute nouvelle fonctionnalité ou évolution.

Cette annexe complète la méthode MCSIA et ne remplace aucune des étapes 0 à 11.

