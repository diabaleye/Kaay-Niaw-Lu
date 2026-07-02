# NiawalmaTech API — Phase 1 : modèle de données

Migrations, modèles Eloquent, enums, factories et seeder pour le backend
Laravel 12 de NiawalmaTech. Ce code est prêt à être copié dans un projet
Laravel fraîchement créé.

## Installation dans un projet neuf

```bash
composer create-project laravel/laravel niawalmatech-api
cd niawalmatech-api

# Copier le contenu de cette archive en écrasant les fichiers
# database/migrations/0001_01_01_000000_create_users_table.php
# et database/seeders/DatabaseSeeder.php déjà présents par défaut.

composer require laravel/sanctum
php artisan install:api
# Laravel 12 ne fournit pas routes/api.php par défaut : cette commande
# le crée et installe Sanctum (config + migration personal_access_tokens).

# .env : configurer la base MySQL, puis
SANCTUM_STATEFUL_DOMAINS=localhost:4200
SESSION_DRIVER=database

php artisan migrate
php artisan db:seed
```

## Compte de démo

- Admin : `admin@niawalmatech.test` / mot de passe `password`
- Tous les comptes générés par les factories utilisent le mot de passe `password`.

## Notes de conception

- `tailleur_profiles` est séparé de `users` : les FK de `modeles`, `commandes`,
  `conversations` et `avis` pointent vers `tailleur_profiles.id`, pas vers
  `users.id` directement.
- `avis.commande_id` est unique : un avis par commande, pour éviter les avis
  non liés à un achat réel.
- `commandes.modele_id` est nullable : une commande peut être une création
  sur-mesure sans modèle de catalogue associé.
- Les champs de `mensurations` sont génériques (tour de poitrine, taille,
  hanches, longueur de manche, tour de cou, largeur d'épaule, hauteur totale)
  et n'ont pas été validés avec un tailleur — à ajuster selon le vrai
  formulaire prévu dans la maquette Figma.

## Prochaine étape (Phase 2)

Authentification Sanctum SPA (cookies) : `AuthController`, middleware de
rôle, et configuration CORS + `withCredentials` côté Angular.
