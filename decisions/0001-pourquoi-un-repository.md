# ADR 0001 — Pourquoi utiliser un Repository plutôt que du SQL direct dans le service

**À QUOI SERT UN ADR (Architecture Decision Record) :**
Une décision technique importante = un petit fichier qui explique ce qui a
été décidé et pourquoi. Ça prend 5 minutes à écrire et ça évite de se
reposer la même question (ou de la reposer à un futur développeur) dans
6 mois.

## Décision
Le module Clients passe toujours par une interface `ClientRepositoryInterface`
et une implémentation MySQL séparée (`ClientRepository`), plutôt que
d'écrire du SQL directement dans `ClientService`.

## Pourquoi
- On peut tester le Service sans base de données réelle.
- Si on change de moteur de base de données plus tard, on ne touche qu'à
  un seul fichier (Infrastructure), jamais à la logique métier.
- Toutes les requêtes SQL d'un module sont regroupées à un seul endroit,
  faciles à retrouver en cas de bug.

## Modèle à copier pour ta prochaine décision
```
# ADR 000X — [titre court de la décision]
## Décision
[ce qui a été décidé]
## Pourquoi
[la ou les raisons, en 2-3 lignes]
```
