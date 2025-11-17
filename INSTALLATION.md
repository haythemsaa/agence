# 🚀 Guide d'Installation Rapide

## Installation en 5 Minutes

### 1. Prérequis
- PHP 8.3+
- Composer
- MySQL 8.0+
- Node.js 18+
- Redis (optionnel pour cache)

### 2. Installation

```bash
# Cloner le projet
git clone https://github.com/haythemsaa/agence.git
cd agence

# Installer les dépendances
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données (créer d'abord la BDD dans MySQL)
php artisan migrate
php artisan db:seed

# Compiler les assets
npm run build

# Lancer le serveur
php artisan serve
```

Accédez à : **http://localhost:8000**

### 3. Comptes de Test

**Admin :**
- Email : admin@agence-voyage.tn
- Password : password
- URL : http://localhost:8000/admin

**Client :**
- Email : mohamed@example.tn
- Password : password

### 4. Configuration API Hotelbeds (Optionnel pour développement)

Dans `.env` :
```env
HOTELBEDS_API_KEY=your_key_here
HOTELBEDS_SECRET=your_secret_here
```

Pour obtenir vos clés : https://developer.hotelbeds.com

### 5. Développement

```bash
# Terminal 1 : Laravel
php artisan serve

# Terminal 2 : Vite (watch mode)
npm run dev
```

### 6. Commandes Utiles

```bash
# Réinitialiser la BDD
php artisan migrate:fresh --seed

# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Lancer les tests
php artisan test

# Voir les routes
php artisan route:list

# Voir les routes admin uniquement
php artisan route:list --path=admin
```

## Problèmes Courants

### Erreur "No application encryption key"
```bash
php artisan key:generate
```

### Erreur connexion base de données
Vérifiez `.env` et créez la base :
```sql
CREATE DATABASE agence_voyage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Assets non compilés
```bash
npm install
npm run build
```

### Permission denied sur storage/
```bash
chmod -R 775 storage bootstrap/cache
```

## Structure Rapide

```
Controllers:
- app/Http/Controllers/           # Frontend
- app/Http/Controllers/Admin/     # Back-office
- app/Http/Controllers/Auth/      # Authentification

Models:
- app/Models/User.php             # Utilisateurs + fidélité
- app/Models/Hotel.php            # Hôtels
- app/Models/HotelBooking.php     # Réservations hôtels
- app/Models/TravelPackage.php    # Packages/circuits
- app/Models/PackageBooking.php   # Réservations packages
- app/Models/Payment.php          # Paiements
- app/Models/Review.php           # Avis

Services:
- app/Services/HotelbedsService.php # API Hotelbeds

Seeders:
- database/seeders/UserSeeder.php        # Admin + clients
- database/seeders/HotelSeeder.php       # 5 hôtels
- database/seeders/TravelPackageSeeder.php # 4 packages
```

## Données de Test Créées

### Utilisateurs
- 1 Admin (niveau platinum)
- 3 Clients (bronze, silver, gold)
- 10 Utilisateurs aléatoires

### Hôtels
- Hotel Golden Yasmin Hammamet (4★)
- Vincci Djerba Resort (5★)
- Mövenpick Sousse (5★)
- La Badira Hammamet (5★)
- Ksar Djerba (4★)

### Packages
- Circuit Grand Sud (7j/6n - 899 TND)
- Omra Économique (10j - 2999 TND)
- Istanbul City Break (4j - 1299 TND)
- Séjour Djerba All Inclusive (7j - 799 TND)

## Support

- Documentation : [README.md](README.md)
- Cahier des charges : [Cahier_Charges_Agence_Voyage_Tunisie.md](Cahier_Charges_Agence_Voyage_Tunisie.md)
- Guide API : [Guide_APIs_Hotels_Tunisie.md](Guide_APIs_Hotels_Tunisie.md)

---

**Développé pour CHOKRI - Novembre 2025**
