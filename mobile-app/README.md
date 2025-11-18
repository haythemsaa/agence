# 📱 VoyageLuxe Mobile App

Application mobile React Native pour l'agence de voyage VoyageLuxe - Tunisie

## 🚀 Technologies

- **React Native 0.73.2** - Framework mobile cross-platform
- **React Navigation 6** - Navigation (Stack, Tabs, Drawer)
- **Axios** - Client HTTP pour API REST
- **React Native Paper** - UI Components Material Design
- **React Native Vector Icons** - Icônes
- **React Native Linear Gradient** - Gradients
- **AsyncStorage** - Stockage local
- **Formik & Yup** - Gestion de formulaires
- **Zustand** - State management
- **Lottie** - Animations
- **React Native Maps** - Cartes interactives
- **React Native Calendars** - Sélection de dates

## 📋 Prérequis

### Environnement de développement

#### Pour Android:
- **Node.js** >= 18
- **JDK** 17 (Java Development Kit)
- **Android Studio** avec Android SDK
- **Android Emulator** ou device physique

#### Pour iOS (Mac uniquement):
- **Node.js** >= 18
- **Xcode** >= 14
- **CocoaPods** (`sudo gem install cocoapods`)
- **iOS Simulator** ou device physique

## ⚙️ Installation

### 1. Cloner et installer les dépendances

```bash
cd mobile-app
npm install
```

### 2. Configuration iOS (Mac uniquement)

```bash
cd ios
pod install
cd ..
```

### 3. Configuration du Backend

Modifier l'URL du backend dans `src/services/api.js`:

```javascript
const BASE_URL = __DEV__
  ? 'http://10.0.2.2:8000/api' // Android Emulator
  : 'https://votre-domaine.com/api'; // Production
```

**Note**: Pour iOS Simulator, utilisez `http://localhost:8000/api`

## 🏃 Lancement de l'application

### Démarrer Metro Bundler

```bash
npm start
```

### Android

```bash
npm run android
```

Ou depuis Android Studio:
1. Ouvrir `android/` dans Android Studio
2. Lancer l'émulateur
3. Cliquer sur "Run"

### iOS (Mac uniquement)

```bash
npm run ios
```

Ou depuis Xcode:
1. Ouvrir `ios/VoyageLuxeMobile.xcworkspace` dans Xcode
2. Sélectionner un simulateur
3. Appuyer sur "Play"

## 📂 Structure du Projet

```
mobile-app/
├── src/
│   ├── components/          # Composants réutilisables
│   │   ├── Cards/          # HotelCard, PackageCard, etc.
│   │   ├── Forms/          # Composants de formulaire
│   │   ├── Home/           # Composants page d'accueil
│   │   └── Search/         # Composants de recherche
│   ├── screens/            # Écrans de l'application
│   │   ├── Home/           # Page d'accueil
│   │   ├── Hotels/         # Liste et détails hôtels
│   │   ├── Packages/       # Liste et détails voyages
│   │   ├── Bookings/       # Réservations
│   │   ├── Profile/        # Profil utilisateur
│   │   └── Auth/           # Authentification
│   ├── navigation/         # Configuration navigation
│   │   ├── RootNavigator.js
│   │   ├── TabNavigator.js
│   │   └── AuthNavigator.js
│   ├── services/           # Services API
│   │   └── api.js          # Client API REST
│   ├── hooks/              # Custom hooks
│   │   └── useAuth.js      # Hook d'authentification
│   ├── store/              # State management (Zustand)
│   ├── theme/              # Thème et styles
│   │   ├── colors.js       # Palette de couleurs
│   │   ├── styles.js       # Styles communs
│   │   └── ThemeContext.js # Context du thème
│   ├── utils/              # Utilitaires
│   └── assets/             # Images, fonts, etc.
├── android/                # Code natif Android
├── ios/                    # Code natif iOS
├── App.js                  # Point d'entrée
├── package.json
└── README.md
```

## 🎨 Fonctionnalités

### ✅ Implémentées

- **Authentification**
  - Inscription / Connexion
  - Écran de bienvenue
  - Récupération de mot de passe
  - Gestion de session avec AsyncStorage

- **Navigation**
  - Bottom Tabs (Accueil, Hôtels, Voyages, Réservations, Profil)
  - Stack Navigation pour les écrans secondaires
  - Deep linking ready

- **Écrans Principaux**
  - Home avec carousel hero
  - Liste des hôtels avec filtres
  - Liste des voyages organisés
  - Détails hôtel/voyage
  - Recherche avancée
  - Profil utilisateur
  - Réservations

- **Design**
  - Theme moderne avec gradients
  - Animations fluides
  - Cards élégantes avec ombres
  - Responsive design
  - Support mode sombre (préparé)

- **API Integration**
  - Client Axios configuré
  - Gestion des tokens JWT
  - Intercepteurs pour auth
  - Gestion d'erreurs

### 🚧 À développer

- Détails complets des écrans
- Système de paiement mobile
- Notifications push
- Mode hors-ligne
- Partage social
- Chat en direct
- Scanner QR code pour vouchers
- Géolocalisation et cartes

## 🔐 Configuration Backend Laravel

### 1. Ajouter les routes API

Dans `routes/api.php`:

```php
Route::get('/hotels/featured', [HotelController::class, 'featured']);
Route::get('/packages/featured', [PackageController::class, 'featured']);
// Autres routes...
```

### 2. Activer CORS

Dans `config/cors.php`:

```php
'paths' => ['api/*'],
'allowed_origins' => ['*'], // En production, spécifier le domaine
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### 3. Configuration Laravel Sanctum (Recommandé)

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

Dans `config/sanctum.php`:

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost')),
```

## 📱 Build de Production

### Android APK

```bash
cd android
./gradlew assembleRelease
```

APK généré dans: `android/app/build/outputs/apk/release/`

### Android App Bundle (Google Play)

```bash
cd android
./gradlew bundleRelease
```

Bundle généré dans: `android/app/build/outputs/bundle/release/`

### iOS IPA (Mac uniquement)

1. Ouvrir Xcode
2. Product → Archive
3. Distribute App → App Store Connect

## 🐛 Debug

### Activer Remote Debugging

1. Shake le device (⌘+D sur iOS, ⌘+M sur Android)
2. Sélectionner "Debug"

### React Native Debugger

```bash
npm install -g react-native-debugger
```

### Logs

```bash
# Android
npx react-native log-android

# iOS
npx react-native log-ios
```

## 🧪 Tests

```bash
# Tests unitaires
npm test

# Tests E2E (à configurer)
npm run e2e
```

## 📦 Librairies Principales

| Librairie | Version | Usage |
|-----------|---------|-------|
| react-navigation | ^6.x | Navigation |
| axios | ^1.6.x | HTTP Client |
| react-native-paper | ^5.x | UI Components |
| react-native-vector-icons | ^10.x | Icônes |
| @react-native-async-storage/async-storage | ^1.x | Stockage local |
| formik | ^2.x | Formulaires |
| zustand | ^4.x | State Management |

## 🎨 Design System

### Couleurs Principales

```javascript
primary: '#667eea'      // Violet
secondary: '#f093fb'    // Rose
accent: '#f39c12'       // Orange
success: '#27ae60'      // Vert
error: '#e74c3c'        // Rouge
```

### Gradients

- **Primary**: Violet → Purple
- **Secondary**: Pink → Red
- **Luxury**: Gold → Blue
- **Omra**: Green → Light Green

## 🌍 Internationalisation (i18n)

Prêt pour l'intégration de `react-native-i18n`:
- Français (FR) - Principal
- Anglais (EN)
- Arabe (AR)

## 📄 Licence

Propriétaire - VoyageLuxe © 2025

## 👥 Support

Pour toute question technique:
- Email: dev@voyageluxe.tn
- Documentation Laravel: `/docs`

## 🚀 Prochaines Étapes

1. ✅ Configuration du backend API
2. ✅ Compléter tous les écrans
3. ✅ Implémenter le système de paiement
4. ✅ Ajouter les notifications push (FCM)
5. ✅ Tests et optimisation
6. ✅ Déploiement sur stores

---

**Développé avec ❤️ pour CHOKRI - Agence de Voyage Tunisie**
