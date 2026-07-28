# Starter PHP POO — Squelette de projet réutilisable

Ce squelette correspond à l'**étape 6** de ta formule standard MCSIA v1.1.
Tu le clones au début de CHAQUE nouveau projet, tu ne repars jamais d'une
page vide. Le module **Clients** ici présent est un exemple complet et
fonctionnel à copier-coller pour créer tes prochains modules (Commandes,
Produits, etc.).

---

## 1. Vue d'ensemble de l'arborescence

```
starter-php-poo/
├── app/
│   ├── Clients/              ← un module = un dossier (voir étape 3 de la méthode)
│   │   ├── Domain/
│   │   ├── Application/
│   │   ├── Infrastructure/
│   │   └── Presentation/
│   │       └── views/          ← pages HTML propres à ce module
│   ├── Core/                 ← outils utilisés par TOUT le projet
│   │   └── View.php            ← moteur de rendu (vue + layout)
│   └── Shared/                ← composants réutilisés par PLUSIEURS modules
│       └── views/
│           ├── layout.php      ← assemble header + contenu + footer
│           └── partials/
│               ├── header.php
│               └── footer.php
├── config/
├── database/
│   └── migrations/            ← historique des changements de la base
├── decisions/                 ← tes ADR (décisions techniques expliquées)
├── public/
│   ├── index.php               ← SEUL fichier accessible depuis le navigateur
│   ├── .htaccess                ← redirige tout vers index.php
│   └── assets/                 ← CSS/JS du projet (app.css, app.js)
├── tests/
├── .env.example
├── .gitignore
├── .htaccess                  ← utile si l'hébergeur pointe sur la racine
├── composer.json
└── README.md
```

---

## 2. Pourquoi chaque élément existe — explication détaillée

### 2.1. Le dossier `app/` — le cœur du projet
2.1.1. C'est ici que vit TOUT ton code métier. Rien de ce dossier n'est
   directement accessible depuis un navigateur (contrairement à `public/`) :
   c'est une protection de sécurité en soi.

### 2.2. Un module (ex : `Clients/`) — un bloc métier isolé
2.2.1. Chaque module correspond à un des blocs que tu as définis à
   l'étape 3 de ta méthode (Clients, Commandes...).
2.2.2. Isoler les modules évite qu'une modification sur "Commandes" casse
   accidentellement quelque chose dans "Clients". Plus le projet grossit,
   plus cette isolation te fait gagner du temps.

### 2.3. Les 4 sous-dossiers d'un module — le sens du flux
Le flux d'une action va toujours dans le même sens :
**Presentation → Application → Domain, avec Infrastructure qui vient
nourrir Application quand il faut lire/écrire en base.**

2.3.1. **`Domain/`** — les objets métier purs (`Client.php`) et leurs
   contrats (`ClientRepositoryInterface.php`). Aucune ligne de SQL, aucun
   `$_POST`, aucun HTML ici. C'est la traduction directe de ton diagramme
   de classes UML (étape 5). **Si tu ne devais garder qu'un seul dossier
   comme "vérité" du projet, ce serait celui-là.**

2.3.2. **`Application/`** — les services (`ClientService.php`) qui
   réalisent tes cas d'usage ("créer un client"). C'est la traduction
   directe de ta liste de fonctionnalités (étape 2). Un service peut
   utiliser plusieurs objets Domain pour accomplir une action complète.

2.3.3. **`Infrastructure/`** — l'implémentation concrète de l'accès aux
   données (`ClientRepository.php`), avec le vrai SQL et PDO dedans.
   C'est la SEULE couche du module qui "sait" que tu utilises MySQL.

2.3.4. **`Presentation/`** — les contrôleurs (`ClientController.php`) qui
   reçoivent la requête web et affichent la réponse. Volontairement
   "minces" : aucune règle métier ici, seulement de la circulation
   d'information.

### 2.4. `app/Core/` — les outils communs à tout le projet
2.4.1. **`Database.php`** — une seule connexion PDO, réutilisée
   partout, avec les requêtes préparées obligatoires (protection contre
   l'injection SQL, l'une des failles de sécurité les plus dangereuses
   et les plus fréquentes).
2.4.2. **`EnvLoader.php`** — lit le fichier `.env`. Permet de ne jamais
   écrire de mot de passe ou d'information sensible en dur dans le code.
2.4.3. **`Router.php`** — dirige chaque URL vers le bon contrôleur, et
   comprend les URL "propres" avec segments (`/clients/{id}`), pas
   seulement les URL fixes. Sans lui, il faudrait un fichier `.php` par
   page, impossible à maintenir sur un projet qui grossit.

#### 2.4.3.bis. URLs propres (`/clients/12`) plutôt que paramètres (`?id=12`)
   Une route se déclare avec des accolades pour la partie variable :
   ```php
   $router->get('/clients/{id}', fn(string $id) => $clientController->afficher($id));
   ```
   Le Router transforme `{id}` en expression régulière, capture ce qu'il
   y a dans l'URL réelle (`12`), et le transmet directement en argument
   à ta fonction. **Pourquoi c'est important :** une URL comme
   `/clients/12` est plus lisible, plus courte à partager, mieux comprise
   par les moteurs de recherche, et montre clairement la ressource
   accédée — contrairement à `/clients?id=12`, qui mélange l'URL avec
   des détails techniques.

### 2.5. `app/Shared/` — pour ne jamais te répéter
2.5.1. Dès qu'un bout de code (pagination, upload de fichier, envoi
   d'e-mail...) sert à deux modules ou plus, il migre ici.
2.5.2. C'est ce dossier que tu enrichis à la fin de chaque projet
   (étape 11.3 de ta méthode) : c'est lui qui fait gagner du temps sur
   le projet suivant.
2.5.3. **`Shared/views/layout.php` + `Shared/views/partials/header.php`
   et `footer.php`** — le squelette HTML commun à TOUTES les pages du
   site (menu, liens Bootstrap/jQuery, pied de page). Voir section 2.11
   ci-dessous pour le détail complet du système de vues.

### 2.6. `app/Core/View.php` — le moteur de rendu des pages
2.6.1. **`View.php`** — capture le HTML produit par une vue (ex :
   `liste.php`), puis l'injecte au milieu du layout commun. C'est lui qui
   fait le lien entre "le contenu d'une page" et "l'habillage commun du
   site". Voir section 2.11.

### 2.7. `database/migrations/` — l'historique de ta base de données
2.7.1. Chaque changement de structure de base (nouvelle table, nouvelle
   colonne) est écrit dans un fichier `.sql` numéroté, jamais fait "à la
   main" directement sur le serveur.
2.7.2. Avantage concret : tu peux recréer ta base de données à
   l'identique sur n'importe quelle machine, juste en rejouant les
   fichiers dans l'ordre.

### 2.8. `decisions/` — tes ADR
2.8.1. Un fichier = une décision technique importante + pourquoi elle a
   été prise. Ça prend 5 minutes à écrire.
2.8.2. Ça t'évite, seul en solo, de te reposer la même question dans
   3 mois en ayant oublié pourquoi tu avais fait tel choix.

### 2.9. `public/` — la seule porte d'entrée
2.9.1. **`index.php`** est le SEUL fichier PHP appelé directement par le
   navigateur. C'est lui qui "branche" ensemble Repository → Service →
   Contrôleur, puis qui laisse le Router s'occuper du reste.
2.9.2. **`assets/`** contient tes fichiers Bootstrap (CSS) et jQuery
   (JS) — étape 8 de ta méthode. Rien d'autre que `public/` ne doit être
   configuré comme accessible sur ton serveur web : c'est ce qui protège
   tout le reste du code (`app/`, `.env`, `database/`...) d'un accès
   direct par une simple URL.
2.9.3. **`public/.htaccess`** — redirige TOUTES les URLs (sauf les vrais
   fichiers comme `assets/style.css`) vers `index.php`, sans que ça se
   voie dans l'adresse. C'est ce fichier qui rend possibles les URLs
   propres du type `/clients/12` avec Apache : sans lui, Apache chercherait
   un vrai fichier "clients/12" sur le disque et répondrait 404 avant
   même que ton code PHP ait une chance de répondre.
2.9.4. **`.htaccess` à la racine du projet** — utile seulement si ton
   hébergeur pointe ton nom de domaine sur la racine du projet (là où se
   trouvent `app/`, `.env`, `composer.json`...) plutôt que sur `public/`.
   Il redirige automatiquement vers `public/`, pour éviter qu'un visiteur
   puisse accéder directement à des fichiers sensibles. **La meilleure
   solution reste, quand ton hébergeur le permet, de configurer `public/`
   directement comme dossier racine du site** — dans ce cas, ce fichier
   ne sert à rien et peut être supprimé.

### 2.10. `tests/` — la preuve que ton code fait ce qu'il doit faire
2.10.1. Grâce à `ClientRepositoryInterface`, tu peux tester
   `ClientService` avec un faux repository "en mémoire", sans jamais
   toucher à une vraie base de données : le test est rapide et fiable.
2.10.2. Écris un test juste après avoir écrit un service (étape 7.4 de la
   méthode), pas à la fin du projet — sinon tu ne le fais jamais.

### 2.11. Le système de vues et le layout commun (nouveau)

2.11.1. **Le principe :** chaque page = un layout commun (toujours le
   même) + un contenu propre à cette page (différent à chaque fois).
   ```
   header.php (menu, <head>)
        +
   contenu de LA page (ex: liste.php)
        +
   footer.php (scripts, pied de page)
   ```

2.11.2. **Où se trouve quoi :**
   - `app/Shared/views/layout.php` — assemble les 3 morceaux ci-dessus.
     C'est le SEUL fichier qui connaît l'ordre header → contenu → footer.
   - `app/Shared/views/partials/header.php` et `footer.php` — communs à
     TOUT le site, tous modules confondus.
   - `app/Clients/Presentation/views/*.php` — propres au module Clients
     (`liste.php`, `afficher.php`, `formulaire.php`). Chaque module aura
     son propre dossier `views/` avec ses propres pages.

2.11.3. **Pourquoi séparer les deux (Shared vs module) :**
   Si le menu ou le pied de page doit changer, tu modifies UN SEUL
   fichier (`Shared/views/partials/header.php`) et toutes les pages de
   tous les modules sont à jour. Si l'affichage de la liste des clients
   doit changer, tu modifies UNIQUEMENT `Clients/Presentation/views/liste.php`
   sans risquer de casser une autre page.

2.11.4. **Comment un contrôleur affiche une page (le mécanisme complet) :**
   ```php
   // Dans ClientController :
   View::renderAvecLayout(
       cheminVue: __DIR__ . '/views/liste.php',
       donnees: ['clients' => $clients],
       titre: 'Liste des clients',
   );
   ```
   `View::render()` exécute `liste.php` et récupère le HTML qu'il produit
   (sans l'envoyer tout de suite au navigateur). Ce HTML est stocké dans
   une variable `$contenu`. Ensuite, `layout.php` est exécuté : il inclut
   `header.php`, affiche `$contenu` (donc le tableau des clients apparaît
   pile entre le menu et le pied de page), puis inclut `footer.php`.

2.11.5. **Pourquoi le contrôleur ne fait jamais `echo` de HTML lui-même :**
   Si le HTML était écrit dans `ClientController.php`, il serait
   impossible de le réutiliser pour un autre format de sortie (une API
   JSON, par exemple), et un designer ne pourrait pas modifier
   l'affichage sans toucher à la logique métier. Séparer vue et
   contrôleur, c'est ce qui permet à chacun de changer sans casser
   l'autre.

2.11.6. **Pour créer un nouveau module avec ses propres vues :**
   crée un dossier `views/` à l'intérieur de son dossier `Presentation/`
   (ex : `Commandes/Presentation/views/`), avec les pages propres à ce
   module. Le layout commun (`Shared/`) n'a besoin d'aucune modification :
   il s'applique automatiquement à toutes les pages de tous les modules.

### 2.12. La validation des données (nouveau)

2.12.1. **Deux validations différentes, à ne pas confondre :**
   - **Validation de FORMAT** (champ obligatoire, format e-mail, longueur
     minimale...) — utilise une dépendance Composer
     (`respect/validation`), dans
     `app/Clients/Application/Validation/ClientValidator.php`.
   - **Validation de RÈGLE MÉTIER** (ex : "un e-mail doit être valide
     selon RG1") — reste dans `app/Clients/Domain/Client.php`, sans
     aucune dépendance externe. Voir sa documentation (section 2.3.1).

2.12.2. **Où va le fichier de validation de format, et pourquoi :**
   - Toujours dans `Application/Validation/`, jamais dans `Domain/`
     (qui ne doit dépendre d'aucune bibliothèque externe) ni dans
     `Presentation/` (le contrôleur doit rester mince et réutilisable,
     par exemple si tu ajoutes une API plus tard).
   - Le détail de ce raisonnement est écrit dans
     `decisions/0002-validation-format-vs-metier.md` (ADR).

2.12.3. **Le circuit complet d'une donnée envoyée par formulaire :**
   ```
   Contrôleur (Presentation)
        → Validator (Application/Validation) : le FORMAT est-il correct ?
        → Service (Application) : orchestre le cas d'usage
        → Domain (Client.php) : les règles MÉTIER sont-elles respectées ?
        → Repository (Infrastructure) : sauvegarde en base
   ```
   Si le Validator trouve une erreur, on s'arrête tout de suite et on
   raffiche le formulaire avec les messages — inutile d'aller plus loin.

2.12.4. **Pour ajouter la validation d'un nouveau module :**
   crée `TonModule/Application/Validation/TonModuleValidator.php` sur le
   modèle de `ClientValidator.php`, injecte-le dans le contrôleur du
   module (comme fait pour `ClientController`), et appelle-le en tout
   début de la méthode qui traite un formulaire.

### 2.10. Fichiers à la racine
2.10.1. **`.env.example`** — le modèle de configuration à copier en
   `.env` (jamais versionné, voir `.gitignore`).
2.10.2. **`.gitignore`** — empêche d'envoyer par erreur sur Git des
   fichiers sensibles (`.env`) ou inutiles (`vendor/`).
2.10.3. **`composer.json`** — déclare l'autoload PSR-4 : grâce à lui,
   `use App\Clients\Domain\Client;` charge automatiquement le bon
   fichier, sans `require` manuel partout.

---

## 3. Comment créer ton prochain module (copier-coller le modèle Clients)

3.1. Dupliquer le dossier `Clients/` et le renommer (ex : `Commandes/`).
3.2. Dans chaque fichier copié, remplacer `Clients` par `Commandes` et
   `Client` par `Commande` (namespace, noms de classes).
3.3. Adapter les attributs de la classe Domain à ta vraie entité.
3.4. Créer la migration SQL correspondante dans `database/migrations/`.
3.5. Ajouter les routes du nouveau module dans `public/index.php`.
3.6. Adapter les vues copiées dans `Commandes/Presentation/views/`
   (`liste.php`, `afficher.php`, `formulaire.php`) — le layout commun
   (`Shared/views/layout.php`) n'a besoin d'aucune modification, il
   s'applique tel quel.
3.7. Adapter `Validation/ClientValidator.php` en `Validation/CommandeValidator.php`
   (règles de format propres au nouveau module) et l'injecter dans le
   contrôleur du module, comme fait pour `ClientController`.
3.8. Ajouter un lien vers le nouveau module dans le menu commun
   (`Shared/views/partials/header.php`).
3.9. Écrire le test du nouveau service, sur le modèle de `ClientServiceTest.php`.

---

## 4. Installation

```bash
composer install
cp .env.example .env
# Remplir .env avec tes vraies valeurs de connexion MySQL

mysql -u root -p ta_base < database/migrations/0001_create_clients_table.sql

php -S localhost:8000 -t public
```

Puis ouvrir `http://localhost:8000/clients` dans le navigateur.

## 5. Lancer les tests

```bash
composer require --dev phpunit/phpunit
vendor/bin/phpunit tests
```
