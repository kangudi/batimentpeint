<?php
/**
 * layout.php — Layout commun
 * -----------------------------
 * À QUOI ÇA SERT :
 * Assemble une page complète : header (menu) + contenu propre à la page
 * + footer (scripts). C'est le SEUL fichier qui connaît cet ordre.
 *
 * POURQUOI C'EST IMPORTANT :
 * C'est ce fichier qui garantit que TOUTES les pages du site ont le même
 * menu et le même pied de page, sans jamais les recopier. Une page
 * (ex: liste.php d'un module) ne s'occupe QUE de son propre contenu :
 * elle ne sait même pas qu'un header ou un footer existe.
 *
 * Variables reçues (données par View::renderAvecLayout) :
 * @var string $contenu Le HTML déjà généré de la page (ex: la liste des clients).
 * @var string $titre   Le titre de la page, affiché dans l'onglet du navigateur.
 */

require __DIR__ . '/partials/header.php';

// C'est ICI que le contenu de la page (ex: liste.php) est injecté au
// milieu du header et du footer.
echo $contenu;

require __DIR__ . '/partials/footer.php';
