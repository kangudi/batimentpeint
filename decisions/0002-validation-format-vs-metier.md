# ADR 0002 — Où placer la validation de format (avec une dépendance Composer)

## Décision
La validation de FORMAT des données (champ obligatoire, format e-mail...)
utilise la dépendance Composer `respect/validation`, dans une classe
`Application/Validation/ClientValidator.php`. Elle est appelée par le
contrôleur, AVANT le Service. Les règles de GESTION métier (RG1, RG2...)
restent dans `Domain/Client.php`, sans aucune dépendance externe.

## Pourquoi
- `Domain/` ne doit dépendre d'aucune bibliothèque externe : si on change
  un jour de bibliothèque de validation, `Domain/` ne doit pas bouger.
- Le contrôleur (`Presentation/`) doit rester mince : il appelle le
  Validator, il ne sait pas comment la validation est faite en détail.
- `Application/` est la couche qui orchestre le cas d'usage complet
  ("créer un client") : c'est donc elle qui vérifie que les données sont
  exploitables avant de les transmettre plus loin.
- Les deux validations (format + métier) sont complémentaires, pas
  redondantes : le Validator filtre tôt les erreurs de saisie grossières
  avec des messages clairs ; `Domain/Client.php` reste la dernière ligne
  de défense, même si un autre code (une future API, par exemple) appelle
  le Service sans passer par ce Validator.
