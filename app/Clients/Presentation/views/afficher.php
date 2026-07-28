<?php
/**
 * views/afficher.php (module Clients)
 * --------------------------------------
 * Variable reçue :
 * @var \App\Clients\Domain\Client $client
 */
?>

<h1 class="mb-4">Fiche client</h1>

<dl class="row">
    <dt class="col-sm-2">Nom</dt>
    <dd class="col-sm-10"><?= htmlspecialchars($client->nom()) ?></dd>

    <dt class="col-sm-2">E-mail</dt>
    <dd class="col-sm-10"><?= htmlspecialchars($client->email()) ?></dd>
</dl>

<a href="/clients" class="btn btn-secondary">&larr; Retour à la liste</a>
