<?php
/**
 * views/erreur404.php (Shared)
 * -------------------------------
 * À QUOI ÇA SERT :
 * Page affichée quand une ressource demandée n'existe pas (ex: un client
 * dont l'id n'existe pas en base).
 *
 * POURQUOI ELLE EST DANS Shared/ ET PAS DANS Clients/ :
 * Une page "introuvable" n'est pas propre au module Clients : Commandes,
 * Produits, etc. en auront besoin aussi. La mettre dans Shared/ évite de
 * la recréer dans chaque module (principe DRY, voir Shared/README.md).
 *
 * Variable reçue (optionnelle) :
 * @var string|null $message
 */
?>

<h1 class="mb-4">Introuvable</h1>
<p class="text-muted"><?= htmlspecialchars($message ?? "Cette ressource n'existe pas.") ?></p>
<a href="/" class="btn btn-secondary">&larr; Retour à l'accueil</a>
