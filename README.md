# Kaaÿ ñiaw lú

Plateforme sénégalaise de couture sur mesure — **Laravel** (API) + **Angular** (frontend CSS).

## Structure

```
Again/
├── backend/    # Laravel 12 — API REST
└── frontend/   # Angular 19 — Interface utilisateur
```

## Prérequis

- PHP 8.2+ et Composer
- Node.js 18+
- **MySQL 8+** (MariaDB compatible)

## Installation

### 1. Base de données MySQL

Créez la base de données :

```sql
CREATE DATABASE kaay_niaw_lu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Backend (Laravel)

```bash
cd backend
composer install
cp .env.example .env   # si nécessaire
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Configurez `backend/.env` si besoin :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kaay_niaw_lu
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

L'API est disponible sur **http://localhost:8000/api**

### 3. Frontend (Angular)

```bash
cd frontend
npm install
npm start
```

L'application est disponible sur **http://localhost:4200**

## Comptes de démonstration

| Rôle     | Téléphone  | Mot de passe |
|----------|------------|--------------|
| Tailleur | 777777777  | password     |
| Client   | 778888888  | password     |

## Fonctionnalités

**Public :** Accueil, À propos, Contact (enregistré en BDD), Connexion, Inscription

**Tailleur :** Tableau de bord, Commandes, Calendrier (livraisons), Atelier virtuel (CRUD modèles), Messagerie, Paramètres (profil, mot de passe, préférences)

**Client :** Tableau de bord, Carnet de mesures (MySQL), Historique commandes, Messagerie, Paramètres

**Pop-ups :** confirmations, changement de mot de passe, suppression de compte, ajout de modèle, commande artisan

## Design

Palette or (#C5A048), noir et blanc — polices Montserrat + Playfair Display, bordures arrondies dorées conformes aux maquettes.

© 2026 Kaaÿ ñiaw lú par NiawlouTech
