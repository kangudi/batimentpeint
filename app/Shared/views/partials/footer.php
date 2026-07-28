<!--
    footer.php
    ----------
    À QUOI ÇA SERT :
    Le bas de CHAQUE page du site : pied de page, scripts JavaScript
    (Bootstrap JS, jQuery), chargés une seule fois et disponibles partout.

    POURQUOI C'EST IMPORTANT :
    Les scripts JS sont chargés en BAS de la page (juste avant </body>)
    plutôt qu'en haut : la page s'affiche plus vite, sans attendre le
    téléchargement des scripts avant de montrer le contenu à l'utilisateur.
-->
</main>

<footer class="container text-center text-muted py-4 mt-5 border-top">
    <small>&copy; <?= date('Y') ?> Mon Projet</small>
</footer>

<!-- jQuery : nécessaire AVANT Bootstrap JS si tu utilises les deux. -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS : menus déroulants, modales, etc. -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Ton propre JS, pour les interactions spécifiques au projet (AJAX...). -->
<script src="/assets/js/app.js"></script>

</body>
</html>
