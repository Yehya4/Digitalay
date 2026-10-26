# 🌐 DIGITALAY — Plateforme E-Commerce de Produits Numériques & Abonnements

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-^8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/TailwindCSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Vite-^7.0-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/Statut-En%20Production-success?style=for-the-badge" alt="Status">
</p>

---

## 📖 Présentation du Projet

**DIGITALAY** est une solution e-commerce moderne, rapide et responsive conçue pour la vente et la gestion de **produits numériques**, **abonnements de streaming**, **services gaming**, **licences logicielles** et **accès IPTV**.

Développée avec **Laravel 12** et **Tailwind CSS v4**, la plateforme offre un tunnel d'achat optimisé sans friction, intégrant la commande directe par **WhatsApp** et **Virement Bancaire**, ainsi qu'un tableau de bord administratif complet pour piloter l'activité.

---

## ✨ Fonctionnalités Principales

### 🛍️ Espace Client (Frontend)
- **Catalogue Dynamique & Recherche Instantanée** : Navigation fluide avec filtrage par catégories (Streaming, Musique, Jeux Vidéo, Logiciels, etc.) et barre de recherche temps-réel.
- **Fiches Produits Riches** :
  - Sélection de durées d'abonnement modulables (1 mois, 3 mois, 6 mois, 12 mois...).
  - Calcul automatique des remises et badges promotionnels personnalisés (Populaire, Offre Spéciale, Top Vente...).
  - Suggestions de ventes croisées (Upsell & Produits similaires).
- **Panier Interactif** : Sauvegarde des articles et gestion des quantités.
- **Tunnel de Caisse (Checkout)** :
  - Commande sans inscription obligatoire pour maximiser le taux de conversion.
  - Modes de paiement adaptés : **WhatsApp direct** et **Virement bancaire**.
- **Page de Confirmation de Commande** : Récapitulatif instantané avec génération d'identifiant unique et bouton de finalisation WhatsApp prérempli.
- **Espace Blog & SEO** : Articles optimisés pour le référencement naturel avec système de slugs dynamiques.
- **Pages Légales & Support** : FAQ interactive, Contact avec protection anti-spam (Rate Limiting), Qui sommes-nous, CGV, Mentions Légales et Politique de Confidentialité.

### ⚡ Panneau d'Administration (Backoffice)
- **Authentification Sécurisée** : Protection contre les attaques par force brute (limite de tentatives par minute).
- **Tableau de Bord Analytique** : Vue d'ensemble sur le chiffre d'affaires, volume de commandes et statistiques clés.
- **Gestion des Commandes** :
  - Suivi des statuts en direct (`En attente`, `Confirmée`, `Livrée`, `Annulée`).
  - Consultation détaillée des coordonnées clients et articles commandés.
- **Gestion du Catalogue (CRUD)** :
  - Ajout et modification des produits avec images, prix barrés, listes de fonctionnalités et durées personnalisées.
  - Activation / désactivation rapide des produits en vitrine.
- **Gestion des Catégories** : Organisation des rayons, icônes FontAwesome et couleurs thématiques.
- **Boîte de Réception & Messages** : Suivi des messages envoyés via le formulaire de contact avec indicateur de lecture.
- **Gestion de Blog (CMS)** : Création, modification et publication d'articles.
- **Paramètres de Sécurité** : Modification du mot de passe administrateur.

---

## 🛠️ Stack Technique

| Composant | Technologie |
|---|---|
| **Backend** | [Laravel 12](https://laravel.com/) (PHP 8.2+) |
| **Frontend** | Blade Templates, [Tailwind CSS v4](https://tailwindcss.com/) |
| **Bundler / Asset Compiler** | [Vite 7](https://vitejs.dev/) |
| **Base de Données** | MySQL / SQLite (compatible MariaDB & PostgreSQL) |
| **Icons & UI** | Font Awesome 6, Heroicons |
| **Sécurité** | Rate-limiting (Throttle), CSRF Protection, Data Sanitization |

---

## 🚀 Installation & Démarrage Rapide

### Prérequis
- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x & **NPM**
- **MySQL** ou **SQLite**

### 1. Cloner le dépôt
```bash
git clone https://github.com/Yehya4/Digitalay.git
cd Digitalay
```

### 2. Installer les dépendances PHP & JS
```bash
composer install
npm install
```

### 3. Configurer l'environnement
Copiez le fichier `.env.example` vers `.env` :
```bash
cp .env.example .env
```
Générez la clé d'application Laravel :
```bash
php artisan key:generate
```

Configurez vos identifiants de base de données dans le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digitalay
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Exécuter les migrations et seeders
Cette commande configure les tables de la base de données, crée l'accès administrateur et insère les catégories et produits de démonstration :
```bash
php artisan migrate --seed
```

*(Optionnel) Pour charger l'ensemble complet de données de test :*
```bash
php artisan db:seed --class=TestDataSeeder
```

### 5. Compiler les assets et lancer le serveur
Dans un terminal, démarrez la compilation Vite :
```bash
npm run dev
```

Dans un second terminal, démarrez le serveur Laravel :
```bash
php artisan serve
```

L'application est accessible sur : `http://127.0.0.1:8000`

---

## 🔐 Accès Espace Administration

- **URL d'accès** : `http://127.0.0.1:8000/admin/login`
- **Mot de passe par défaut** : `admin123` *(configurable dans les paramètres du dashboard)*

---

## 📁 Structure du Projet

```text
digitalay/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php      # Gestion du backoffice
│   │   │   └── FrontendController.php   # Boutique, panier, checkout & pages
│   │   └── Middleware/
│   │       └── AdminAuth.php            # Contrôle d'accès admin
│   └── Models/                          # Modèles Eloquent (Product, Order, Category...)
├── database/
│   ├── migrations/                      # Schémas de base de données
│   └── seeders/                         # Données initiales & démonstration
├── resources/
│   ├── css/                             # Styles Tailwind CSS
│   ├── js/                              # Scripts frontend
│   └── views/                           # Vues Blade (layouts, admin, components...)
├── routes/
│   ├── web.php                          # Routes web (client & administration)
│   └── console.php                      # Commandes console
├── public/                              # Point d'entrée public et assets statiques
└── vite.config.js                       # Configuration Vite & Tailwind
```

---

## 🛡️ Sécurité & Bonnes Pratiques

- **Protection Anti-Spam** : Throttling appliqué aux soumissions de contact et de paiement.
- **Sanitisation des données** : Échappement systématique des entrées utilisateurs contre les failles XSS.
- **Isolation des transactions** : Intégrité relationnelle entre commandes et articles commandés.
- **Variables sensibles** : Aucune donnée confidentielle dans le suivi de version (`.env` exclu du dépôt git).

---

## 👤 Auteur & Réalisation

Projet conçu et développé dans le cadre de prestations freelance :
- **Auteur** : [Yehya](https://github.com/Yehya4)
- **Dépôt GitHub** : [Yehya4/Digitalay](https://github.com/Yehya4/Digitalay)

---

## 📄 Licence

Ce projet est sous licence [MIT](LICENSE). Vous êtes libre de l'utiliser et de l'adapter selon vos besoins.
