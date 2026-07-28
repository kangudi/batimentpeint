<?php /** @var string $titre (fourni par View::renderAvecLayout) */ ?>
<!--
    header.php
    ----------
    À QUOI ÇA SERT :
    Le haut de CHAQUE page du site : balises <head>, liens Bootstrap,
    menu de navigation.

    POURQUOI C'EST IMPORTANT :
    C'est le SEUL endroit où se trouve le menu du site. Ajouter un lien
    de menu ici l'ajoute automatiquement sur toutes les pages qui passent
    par le layout commun (voir layout.php).
-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre !== '' ? $titre . ' — Mon Projet' : 'Mon Projet') ?></title>

    <!-- Bootstrap : sert à la mise en page (grille, boutons, formulaires). -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Ton propre CSS, pour les ajustements spécifiques au projet. -->
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">Mon Projet</a>
        <div class="navbar-nav">
            <a class="nav-link" href="/clients">Clients</a>
            <!-- Ajoute ici un lien par module (ex: Commandes, Produits...). -->
        </div>
    </div>
</nav>

<main class="container">
