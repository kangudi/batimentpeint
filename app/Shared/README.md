# Dossier Shared

À QUOI ÇA SERT :
Ce dossier contient le code réutilisable par PLUSIEURS modules (Clients, Commandes, etc.) :
gestion des fichiers uploadés, pagination, envoi d'e-mails, gestion des rôles/droits...

POURQUOI C'EST IMPORTANT :
Sans ce dossier, on recopie le même code de pagination ou d'upload dans chaque
module (violation du principe DRY - Don't Repeat Yourself). Avec Shared, on
écrit un composant une seule fois et tous les modules s'en servent.

RÈGLE : un composant ne va dans Shared QUE s'il est utilisé par au moins
deux modules différents. Sinon, il reste dans le module concerné.

C'est aussi le dossier que tu enrichis à la fin de chaque projet (étape 11.3
de ta méthode MCSIA) pour que le prochain projet démarre plus vite.
