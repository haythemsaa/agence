# 🏨 Plateforme d'Agence de Voyage - Tunisie

Une plateforme web complète pour agence de voyage développée avec **Laravel 11**, permettant la réservation d'hôtels en temps réel via l'API Hotelbeds et la gestion de voyages organisés.

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-blue)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

## 📋 Table des Matières

- [Fonctionnalités](#-fonctionnalités)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Structure du Projet](#-structure-du-projet)
- [APIs Intégrées](#-apis-intégrées)
- [Base de Données](#-base-de-données)
- [Utilisation](#-utilisation)
- [Documentation](#-documentation)

## ✨ Fonctionnalités

### 🏨 Module Hôtels
- ✅ Recherche d'hôtels en temps réel via API Hotelbeds
- ✅ Filtres avancés (prix, étoiles, équipements, note)
- ✅ Réservation instantanée avec confirmation
- ✅ Système de cache intelligent (15 min)
- ✅ Gestion des annulations

### ✈️ Voyages Organisés
- ✅ Circuits touristiques en Tunisie
- ✅ Voyages religieux (Omra, Hajj)
- ✅ Séjours balnéaires
- ✅ Voyages internationaux
- ✅ Programme jour par jour détaillé
- ✅ Gestion des participants

### 👤 Espace Client
- ✅ Dashboard personnalisé
- ✅ Historique des réservations
- ✅ Programme de fidélité (Bronze → Argent → Or → Platine)
- ✅ Gestion des favoris
- ✅ Système d'avis et notes

### 💳 Paiement Sécurisé
- ✅ Stripe (cartes bancaires internationales)
- ✅ PayPal
- ✅ Flouci (paiement mobile Tunisie)
- ✅ Virement bancaire
- ✅ Paiement en plusieurs fois

### 🛠️ Back-Office Admin
- ✅ Dashboard avec KPIs temps réel
- ✅ Gestion complète des réservations
- ✅ CRUD des packages/circuits
- ✅ Gestion des clients et CRM
- ✅ Rapports financiers détaillés
- ✅ Système de modération des avis

## 🔧 Prérequis

- PHP >= 8.3
- Composer >= 2.0
- MySQL >= 8.0
- Redis >= 6.0
- Node.js >= 18.x & NPM
- Extension PHP : BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## 📦 Installation

### 1. Cloner le Projet

```bash
git clone https://github.com/haythemsaa/agence.git
cd agence
```

### 2. Installer les Dépendances

```bash
# Dépendances PHP
composer install

# Dépendances NPM
npm install
```

### 3. Configuration de l'Environnement

```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4. Configuration Base de Données

Éditez le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agence_voyage
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

Créez la base de données :

```bash
mysql -u root -p
CREATE DATABASE agence_voyage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 5. Exécuter les Migrations et Seeders

```bash
# Exécuter les migrations
php artisan migrate

# Peupler la base avec des données de test
php artisan db:seed
```

Les seeders créeront automatiquement :
- **1 administrateur** : admin@agence-voyage.tn / password
- **3 clients test** avec différents niveaux de fidélité
- **10 utilisateurs aléatoires**
- **5 hôtels** en Tunisie (Hammamet, Djerba, Sousse)
- **4 packages/circuits** :
  - Circuit Grand Sud (7j/6n - 899 TND)
  - Omra Économique (10j - 2999 TND)
  - Istanbul City Break (4j - 1299 TND)
  - Séjour Djerba All Inclusive (7j - 799 TND)

### 6. Compiler les Assets

```bash
# Développement
npm run dev

# Production
npm run build
```

### 7. Lancer le Serveur

```bash
# Terminal 1 : Laravel
php artisan serve

# Terminal 2 : Vite (assets) - seulement en développement
npm run dev
```

Le site sera accessible sur : **http://localhost:8000**

### 8. Accéder à l'Application

**Espace Client :**
- URL : http://localhost:8000
- Créer un compte via `/register`
- Ou utiliser : mohamed@example.tn / password

**Back-Office Admin :**
- URL : http://localhost:8000/admin
- Identifiants : admin@agence-voyage.tn / password

## ⚙️ Configuration

### API Hotelbeds

1. Créez un compte développeur : https://developer.hotelbeds.com
2. Obtenez vos clés API (test et production)
3. Configurez dans `.env` :

```env
HOTELBEDS_API_KEY=votre_api_key
HOTELBEDS_SECRET=votre_secret
HOTELBEDS_BASE_URL=https://api.hotelbeds.com
```

### Stripe Payment

```env
STRIPE_KEY=pk_test_your_key
STRIPE_SECRET=sk_test_your_secret
STRIPE_WEBHOOK_SECRET=whsec_your_webhook
```

### PayPal Payment

```env
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=your_client_id
PAYPAL_SANDBOX_CLIENT_SECRET=your_client_secret
```

### Redis Cache

```env
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

## 🏗️ Structure du Projet

```
agence/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php              # Page d'accueil
│   │   │   ├── HotelController.php             # Recherche et réservation hôtels
│   │   │   ├── TravelPackageController.php     # Liste et réservation packages
│   │   │   ├── BookingController.php           # Gestion réservations
│   │   │   ├── ReviewController.php            # Avis clients
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php     # Dashboard admin
│   │   │   │   ├── HotelBookingController.php  # CRUD réservations hôtels
│   │   │   │   ├── PackageBookingController.php # CRUD réservations packages
│   │   │   │   ├── TravelPackageController.php # CRUD packages
│   │   │   │   ├── UserController.php          # Gestion utilisateurs
│   │   │   │   └── ReviewController.php        # Modération avis
│   │   │   └── Auth/                           # Authentification (Breeze)
│   │   └── Middleware/
│   │       └── AdminMiddleware.php             # Protection routes admin
│   │
│   ├── Models/                 # Eloquent Models
│   │   ├── User.php            # Utilisateurs + fidélité
│   │   ├── Hotel.php           # Hôtels (cache API)
│   │   ├── HotelBooking.php    # Réservations hôtels
│   │   ├── TravelPackage.php   # Circuits/packages
│   │   ├── PackageBooking.php  # Réservations packages
│   │   ├── Payment.php         # Paiements (polymorphic)
│   │   └── Review.php          # Avis (polymorphic)
│   │
│   └── Services/               # Services métier
│       └── HotelbedsService.php # Intégration API Hotelbeds
│
├── database/
│   ├── migrations/             # Structure base de données
│   │   ├── create_hotels_table.php
│   │   ├── create_hotel_bookings_table.php
│   │   ├── create_travel_packages_table.php
│   │   ├── create_package_bookings_table.php
│   │   ├── create_payments_table.php
│   │   ├── create_reviews_table.php
│   │   └── add_fields_to_users_table.php
│   │
│   └── seeders/                # Données de test
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php      # Admin + clients
│       ├── HotelSeeder.php     # 5 hôtels
│       └── TravelPackageSeeder.php # 4 packages
│
├── resources/
│   ├── views/                  # Templates Blade
│   │   ├── auth/               # Authentification (Breeze)
│   │   ├── layouts/            # Layouts (app, guest, navigation)
│   │   ├── profile/            # Gestion profil
│   │   └── dashboard.blade.php # Dashboard client
│   └── js/                     # Alpine.js + Tailwind
│
├── routes/
│   ├── web.php                 # Routes publiques + auth + admin
│   ├── auth.php                # Routes authentification (Breeze)
│   └── api.php                 # Routes API
│
├── config/
│   └── services.php            # Config APIs (Hotelbeds, Stripe, PayPal, Flouci)
│
├── .env.example                # Template environnement
├── README.md
├── Cahier_Charges_Agence_Voyage_Tunisie.md
└── Guide_APIs_Hotels_Tunisie.md
```

## 🛣️ Routes Principales

### Routes Publiques
```
GET  /                      Page d'accueil
GET  /hotels               Liste hôtels
GET  /hotels/search        Recherche hôtels (API Hotelbeds)
GET  /hotels/{id}          Détails hôtel
GET  /packages             Liste packages
GET  /packages/{slug}      Détails package
```

### Routes Authentifiées (Clients)
```
GET  /dashboard            Dashboard client
GET  /profile              Gestion profil
GET  /hotels/{id}/book     Formulaire réservation hôtel
POST /hotels/{id}/book     Créer réservation hôtel
GET  /packages/{slug}/book Formulaire réservation package
POST /packages/{slug}/book Créer réservation package
POST /reviews              Créer avis
```

### Routes Admin (protégées par middleware)
```
GET  /admin                      Dashboard admin
Resource /admin/hotel-bookings   Gestion réservations hôtels
Resource /admin/package-bookings Gestion réservations packages
Resource /admin/packages         CRUD packages/circuits
Resource /admin/users            Gestion utilisateurs
GET  /admin/reviews              Liste avis
POST /admin/reviews/{id}/publish Publier avis
POST /admin/reviews/{id}/respond Répondre à avis
```

## 🌐 APIs Intégrées

### Hotelbeds API

Service principal pour la réservation d'hôtels :
- **Recherche** : 180,000+ hôtels mondialement
- **Disponibilité** : Temps réel
- **Tarifs** : Compétitifs B2B
- **Commission** : 8-12% par réservation

**Méthodes disponibles :**
```php
// Recherche d'hôtels
$hotelbeds = new HotelbedsService();
$results = $hotelbeds->searchHotels('HAM', '2025-06-01', '2025-06-05', 2);

// Vérification tarifs
$rates = $hotelbeds->checkRates($rateKey);

// Création réservation
$booking = $hotelbeds->createBooking($rateKey, $holder, $rooms, $reference);

// Annulation
$cancel = $hotelbeds->cancelBooking($bookingId);
```

**Codes Destinations Tunisie :**
- HAM : Hammamet
- SOU : Sousse
- DJE : Djerba
- TUN : Tunis
- MAH : Mahdia
- MON : Monastir
- TOZ : Tozeur
- TAB : Tabarka

## 🗄️ Base de Données

### Tables Principales

#### `users`
Utilisateurs avec programme de fidélité

#### `hotels`
Cache local des hôtels (API Hotelbeds)

#### `hotel_bookings`
Réservations d'hôtels

#### `travel_packages`
Circuits et voyages organisés

#### `package_bookings`
Réservations de packages avec paiement échelonné

#### `payments`
Tous les paiements (polymorphic)

#### `reviews`
Avis clients (polymorphic : hôtels et packages)

### Relations Clés

- User → HotelBookings (1:N)
- User → PackageBookings (1:N)
- User → Reviews (1:N)
- Hotel → HotelBookings (1:N)
- Hotel → Reviews (polymorphic)
- TravelPackage → PackageBookings (1:N)
- TravelPackage → Reviews (polymorphic)

## 📱 Utilisation

### Recherche d'Hôtels

```php
use App\Services\HotelbedsService;

$hotelbeds = new HotelbedsService();

// Recherche hôtels à Hammamet
$results = $hotelbeds->searchHotels(
    destination: 'HAM',
    checkIn: '2025-07-01',
    checkOut: '2025-07-08',
    adults: 2,
    children: 1,
    rooms: 1
);
```

### Gestion des Réservations

```php
use App\Models\HotelBooking;

// Créer une réservation
$booking = HotelBooking::create([
    'booking_reference' => HotelBooking::generateReference(),
    'user_id' => auth()->id(),
    // ... autres données
]);

// Annuler une réservation
$booking->cancel('Client a demandé annulation');
```

### Programme de Fidélité

```php
use App\Models\User;

$user = auth()->user();

// Ajouter des points
$user->addLoyaltyPoints(100); // 1 TND = 1 point

// Vérifier le niveau
echo $user->loyalty_level; // bronze, silver, gold, platinum
```

## 📚 Documentation Complète

Pour plus de détails, consultez :

1. **[Cahier des Charges Complet](Cahier_Charges_Agence_Voyage_Tunisie.md)** - Spécifications fonctionnelles détaillées
2. **[Guide APIs Hôtelières](Guide_APIs_Hotels_Tunisie.md)** - Documentation API Hotelbeds
3. **[API Hotelbeds](https://developer.hotelbeds.com)** - Documentation officielle

## 🚀 Roadmap

### Phase 1 (MVP - 3 mois) ✅ 100% TERMINÉE
- [x] Architecture Laravel + Base de données
- [x] Intégration Hotelbeds API
- [x] Models et Migrations complets
- [x] **Authentification Laravel Breeze**
- [x] **Controllers Frontend (Home, Hotels, Packages)**
- [x] **Controllers Admin (Dashboard, CRUD complets)**
- [x] **Routes organisées (publiques, auth, admin)**
- [x] **Middleware Admin**
- [x] **Seeders avec données de test**
- [x] **Service Hotelbeds fonctionnel**
- [x] **Vues Blade frontend complètes (home, hotels, packages)**
- [x] **Layout public responsive avec navigation et badge fidélité**
- [x] **Dashboard client avec carte de fidélité et onglets**
- [x] **Vues admin dashboard avec KPIs et graphiques**
- [x] **Vues admin gestion réservations (hôtels & packages)**
- [x] **Intégration Stripe Payment complète** ✨ NOUVEAU
- [x] **Support PayPal, Flouci, virement bancaire** ✨ NOUVEAU
- [x] **Système de notifications email avec templates** ✨ NOUVEAU
- [x] **Génération vouchers PDF professionnels** ✨ NOUVEAU
- [x] **Webhooks Stripe pour confirmations automatiques** ✨ NOUVEAU
- [x] **Guide de déploiement production complet (DEPLOYMENT.md)** ✨ NOUVEAU

### Phase 2 (6 mois)
- [x] Intégration PayPal et Flouci ✅ Déjà fait
- [x] Module emails (confirmations, notifications) ✅ Déjà fait
- [x] Système de vouchers PDF ✅ Déjà fait
- [x] Programme fidélité UI (badges, points) ✅ Déjà fait
- [ ] Dashboard analytics avancés avec graphiques interactifs
- [ ] Export rapports Excel/PDF pour admin
- [ ] Multi-langue (FR/EN/AR)
- [ ] Système de reviews UI complet avec modération
- [ ] Notifications push (navigateur)
- [ ] Intégration SMS (Twilio)

### Phase 3 (12 mois)
- [ ] Application mobile (Flutter)
- [ ] API publique pour partenaires
- [ ] Chatbot IA support client
- [ ] Analytics avancés (Google Analytics)
- [ ] Système de recommandations ML
- [ ] Intégration réseaux sociaux

## 🤝 Contribution

Ce projet a été développé pour le client **CHOKRI** selon le cahier des charges détaillé.

## 📄 Licence

Ce projet est sous licence MIT.

## 👥 Support

Pour toute question :
- 📧 Email : support@agence-voyage-tn.com
- 📱 Téléphone : +216 XX XXX XXX
- 🌐 Site : (à définir)

## 🙏 Remerciements

- Laravel Framework
- Hotelbeds API
- Stripe & PayPal
- Communauté Laravel Tunisie

---

**Développé avec ❤️ en Tunisie**

*Version 1.0 - Novembre 2025*
