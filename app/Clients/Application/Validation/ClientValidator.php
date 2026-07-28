<?php

declare(strict_types=1);

namespace App\Clients\Application\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

/**
 * ClientValidator (Application/Validation)
 * -------------------------------------------
 * À QUOI ÇA SERT :
 * Vérifie que les données brutes reçues du formulaire (nom, email) ont
 * un FORMAT correct, AVANT qu'elles n'aillent plus loin dans le projet.
 *
 * POURQUOI CETTE CLASSE EST DANS Application/ ET PAS AILLEURS :
 * - Pas dans Domain/ : Domain/Client.php ne doit dépendre d'AUCUNE
 *   bibliothèque externe (voir sa documentation). Si demain tu changes
 *   de bibliothèque de validation (respect/validation -> autre chose),
 *   Domain/ ne doit pas bouger d'un seul caractère.
 * - Pas dans Presentation/ (le contrôleur) : le contrôleur doit rester
 *   mince, et cette validation doit pouvoir être réutilisée telle
 *   quelle si tu ajoutes un jour une API en plus du site web.
 * - Application/ est la couche qui orchestre un cas d'usage complet
 *   ("créer un client") : c'est donc elle, logiquement, qui vérifie que
 *   les données sont exploitables avant d'aller plus loin.
 *
 * DIFFÉRENCE AVEC LES RÈGLES DE Domain/Client.php :
 * - Ici (ClientValidator) : validation de FORMAT ("l'email ressemble-t-il
 *   à un email ?", "le nom fait-il au moins 2 caractères ?").
 * - Dans Domain/Client.php : règles de GESTION métier ("un email doit
 *   être valide selon les critères RG1 du cahier des charges").
 * Les deux se complètent, elles ne font pas doublon : le Validator
 * filtre les erreurs de saisie grossières tôt et donne des messages
 * clairs à l'utilisateur ; Domain/Client.php reste la dernière ligne de
 * défense, même si un jour un autre code appelle le Service sans passer
 * par ce Validator.
 */
final class ClientValidator
{
    /**
     * @param array<string, mixed> $donnees
     * @return string[] Liste des messages d'erreur, vide si tout est valide.
     */
    public function valider(array $donnees): array
    {
        $regles = v::key('nom', v::stringType()->notEmpty()->length(2, 150))
                   ->key('email', v::email());

        try {
            $regles->assert($donnees);
            return [];
        } catch (NestedValidationException $e) {
            // getMessages() renvoie un tableau de messages déjà lisibles,
            // un par champ en erreur (ex: "email must be valid email").
            return $e->getMessages();
        }
    }
}
