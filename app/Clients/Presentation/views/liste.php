<?php
/**
 * views/liste.php (module Clients)
 * -----------------------------------
 * À QUOI ÇA SERT :
 * Affiche UNIQUEMENT le contenu propre à cette page : le tableau des
 * clients. Rien d'autre (pas de <html>, pas de menu, pas de footer) :
 * tout ça est géré par le layout commun (voir Shared/views/layout.php).
 *
 * POURQUOI C'EST IMPORTANT :
 * Cette séparation permet de réutiliser EXACTEMENT le même layout pour
 * un module "Commandes" ou "Produits" : seule cette partie change d'un
 * module à l'autre.
 *
 * Variable reçue (donnée par le contrôleur, voir ClientController) :
 * @var \App\Clients\Domain\Client[] $clients
 */
?>

<h1 class="mb-4">Liste des clients</h1>

<a href="/clients/nouveau" class="btn btn-primary mb-3">+ Nouveau client</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom</th>
            <th>E-mail</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($clients === []): ?>
        <tr>
            <td colspan="2" class="text-muted">Aucun client pour l'instant.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($clients as $client): ?>
            <tr>
                <!-- htmlspecialchars() protège contre les failles XSS :
                     jamais afficher une donnée utilisateur sans l'échapper. -->
                <td>
                    <a href="/clients/<?= (int) $client->id() ?>">
                        <?= htmlspecialchars($client->nom()) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($client->email()) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
