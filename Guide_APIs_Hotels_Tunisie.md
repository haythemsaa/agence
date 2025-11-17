# 🏨 GUIDE COMPLET DES APIs HÔTELIÈRES POUR LA TUNISIE

## 📌 Document de Référence Rapide

**Date:** 17 Novembre 2025  
**Pour:** Agence de Voyage - Tunisie

---

## 🎯 RECOMMANDATION PRINCIPALE

### ⭐⭐⭐ HOTELBEDS API - CHOIX N°1

**Pourquoi Hotelbeds est le meilleur choix pour commencer:**

✅ **Couverture Tunisie Excellente**
- Tous les grands hôtels tunisiens
- Hammamet, Sousse, Djerba, Tunis, Mahdia...
- Plus de 180,000 hôtels mondialement

✅ **API Moderne et Bien Documentée**
- REST API avec JSON
- Documentation complète en anglais
- Exemples de code
- Sandbox de test gratuit

✅ **Modèle Commercial Avantageux**
- Pas de frais d'inscription
- Pas d'abonnement mensuel
- Commission uniquement sur réservations réussies (8-12%)
- Prix B2B compétitifs

✅ **Support Technique**
- Équipe support dédiée
- Documentation interactive
- Forum développeurs
- Certification disponible

---

## 📝 COMMENT S'INSCRIRE SUR HOTELBEDS

### Étape 1: Création Compte Développeur

1. Allez sur: **https://developer.hotelbeds.com**
2. Cliquez sur "Register" en haut à droite
3. Remplissez le formulaire:
   - Nom de l'entreprise
   - Email professionnel
   - Téléphone
   - Pays (Tunisie)
   - Type d'entreprise (Travel Agency)

### Étape 2: Soumission Demande

Vous devrez fournir:
- **Licence touristique** (obligatoire)
- **Registre de commerce**
- **Informations bancaires** (pour recevoir commissions)
- **Description de votre business**
- **Volume de réservations estimé**

### Étape 3: Validation Commerciale

- Hotelbeds contactera votre entreprise (2-5 jours)
- Discussion des termes commerciaux
- Négociation taux de commission
- Signature contrat partenaire

### Étape 4: Accès API

Une fois approuvé:
- **Clés Test** (sandbox) - immédiat
- **Clés Production** - après validation
- Accès documentation complète
- Support technique

**Délai Total: 1-3 semaines**

---

## 🔑 UTILISATION DE L'API HOTELBEDS

### Configuration Laravel

```php
// .env
HOTELBEDS_API_KEY=your_api_key_here
HOTELBEDS_SECRET=your_secret_here
HOTELBEDS_BASE_URL=https://api.hotelbeds.com

// config/services.php
'hotelbeds' => [
    'api_key' => env('HOTELBEDS_API_KEY'),
    'secret' => env('HOTELBEDS_SECRET'),
    'base_url' => env('HOTELBEDS_BASE_URL'),
],
```

### Service Hotelbeds

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class HotelbedsService
{
    protected $apiKey;
    protected $secret;
    protected $baseUrl;
    
    public function __construct()
    {
        $this->apiKey = config('services.hotelbeds.api_key');
        $this->secret = config('services.hotelbeds.secret');
        $this->baseUrl = config('services.hotelbeds.base_url');
    }
    
    /**
     * Génère la signature requise pour l'authentification
     */
    protected function getSignature()
    {
        return hash('sha256', $this->apiKey . $this->secret . time());
    }
    
    /**
     * Recherche d'hôtels disponibles
     */
    public function searchHotels($destination, $checkIn, $checkOut, $adults, $children = 0, $rooms = 1)
    {
        $cacheKey = "hotels_search_" . md5(json_encode(func_get_args()));
        
        return Cache::remember($cacheKey, 900, function() use ($destination, $checkIn, $checkOut, $adults, $children, $rooms) {
            
            $response = Http::withHeaders([
                'Api-key' => $this->apiKey,
                'X-Signature' => $this->getSignature(),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/hotel-api/1.0/hotels', [
                'stay' => [
                    'checkIn' => $checkIn, // Format: YYYY-MM-DD
                    'checkOut' => $checkOut,
                ],
                'occupancies' => [
                    [
                        'rooms' => $rooms,
                        'adults' => $adults,
                        'children' => $children,
                    ]
                ],
                'destination' => [
                    'code' => $destination, // Ex: "TUN" pour Tunisie
                ],
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            throw new \Exception('Hotelbeds API Error: ' . $response->body());
        });
    }
    
    /**
     * Vérification des tarifs avant réservation
     */
    public function checkRates($rateKey)
    {
        $response = Http::withHeaders([
            'Api-key' => $this->apiKey,
            'X-Signature' => $this->getSignature(),
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/hotel-api/1.0/checkrates', [
            'rooms' => [
                [
                    'rateKey' => $rateKey,
                ]
            ]
        ]);
        
        return $response->json();
    }
    
    /**
     * Création de réservation
     */
    public function createBooking($rateKey, $holder, $rooms)
    {
        $response = Http::withHeaders([
            'Api-key' => $this->apiKey,
            'X-Signature' => $this->getSignature(),
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/hotel-api/1.0/bookings', [
            'holder' => [
                'name' => $holder['first_name'],
                'surname' => $holder['last_name'],
            ],
            'rooms' => $rooms,
            'clientReference' => 'BOOKING-' . uniqid(),
        ]);
        
        return $response->json();
    }
    
    /**
     * Récupération détails réservation
     */
    public function getBooking($bookingId)
    {
        $response = Http::withHeaders([
            'Api-key' => $this->apiKey,
            'X-Signature' => $this->getSignature(),
        ])->get($this->baseUrl . '/hotel-api/1.0/bookings/' . $bookingId);
        
        return $response->json();
    }
    
    /**
     * Annulation réservation
     */
    public function cancelBooking($bookingId)
    {
        $response = Http::withHeaders([
            'Api-key' => $this->apiKey,
            'X-Signature' => $this->getSignature(),
        ])->delete($this->baseUrl . '/hotel-api/1.0/bookings/' . $bookingId);
        
        return $response->json();
    }
}
```

### Exemple d'Utilisation (Controller)

```php
<?php

namespace App\Http\Controllers;

use App\Services\HotelbedsService;
use Illuminate\Http\Request;

class HotelSearchController extends Controller
{
    protected $hotelbeds;
    
    public function __construct(HotelbedsService $hotelbeds)
    {
        $this->hotelbeds = $hotelbeds;
    }
    
    public function search(Request $request)
    {
        $validated = $request->validate([
            'destination' => 'required|string',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1|max:9',
            'children' => 'integer|min:0|max:9',
            'rooms' => 'integer|min:1|max:5',
        ]);
        
        try {
            $results = $this->hotelbeds->searchHotels(
                $validated['destination'],
                $validated['check_in'],
                $validated['check_out'],
                $validated['adults'],
                $validated['children'] ?? 0,
                $validated['rooms'] ?? 1
            );
            
            return view('hotels.results', [
                'hotels' => $results['hotels']['hotels'] ?? [],
                'total' => $results['hotels']['total'] ?? 0,
            ]);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la recherche: ' . $e->getMessage());
        }
    }
}
```

---

## 🔄 ALTERNATIVES À HOTELBEDS

### Option 2: Amadeus Hotel API

**Avantages:**
- Self-service (inscription immédiate)
- 2000-3000 requêtes gratuites/mois (test)
- GDS réputé

**Inconvénients:**
- Payant en production (€0.015-0.03/requête)
- Moins d'hôtels que Hotelbeds

**Inscription:**
1. https://developers.amadeus.com
2. Créer compte (gratuit)
3. Obtenir API key (immédiat)
4. Utiliser sandbox gratuitement

**Quand l'utiliser:**
- Comme API secondaire (Phase 2)
- Pour comparer les prix
- Pour élargir l'inventaire

---

### Option 3: Expedia Rapid API

**Avantages:**
- Inventaire global massif
- API moderne

**Inconvénients:**
- Approbation peut prendre 2-4 semaines
- Process plus long

**Inscription:**
1. https://developers.expediagroup.com
2. Créer compte développeur
3. Soumettre demande approbation
4. Attendre validation

**Quand l'utiliser:**
- Phase 3 (après 6-12 mois)
- Pour maximiser inventaire
- Pour destinations hors Tunisie

---

## ❌ CE QU'IL NE FAUT PAS FAIRE

### Booking.com - Ne PAS Utiliser Directement

**Pourquoi?**
- ❌ Pas d'API publique pour agences
- ❌ Réservée aux hôteliers partenaires
- ❌ Programme affiliation seulement (liens trackés, pas de réservation API)

**Alternative:**
Hotelbeds inclut déjà l'inventaire Booking.com dans ses résultats.

### Web Scraping - INTERDIT

**Pourquoi?**
- ❌ Illégal (violation CGU)
- ❌ Instable (changes fréquents)
- ❌ Peut mener à ban IP
- ❌ Pas de support

---

## 💰 COMPARATIF COÛTS

| API | Inscription | Abonnement | Commission |
|-----|-------------|------------|------------|
| **Hotelbeds** | Gratuit | 0 | 8-12% par résa |
| **Amadeus** | Gratuit | 0 | €0.015-0.03/req |
| **Expedia** | Gratuit | 0 | Variable |
| **Booking.com** | ❌ Non disponible | - | - |

---

## 🚀 ROADMAP D'INTÉGRATION

### Phase 1 (Mois 1-3): MVP
```
✅ Intégrer Hotelbeds uniquement
✅ Focus hôtels Tunisie
✅ Mise en cache 15 minutes
✅ Processus réservation complet
```

### Phase 2 (Mois 4-6): Expansion
```
✅ Ajouter Amadeus (API secondaire)
✅ Comparateur de prix automatique
✅ Élargir destinations internationales
```

### Phase 3 (Mois 7-12): Optimisation
```
✅ Ajouter Expedia (optionnel)
✅ Meta-search intelligent
✅ Machine learning pour meilleur prix
✅ 3-4 APIs simultanées
```

---

## 📊 CODES DESTINATIONS TUNISIE

Pour Hotelbeds, voici les codes destinations:

| Destination | Code | Nb Hôtels Approx |
|-------------|------|------------------|
| Hammamet | HAM | 150+ |
| Sousse | SOU | 100+ |
| Djerba | DJE | 120+ |
| Tunis | TUN | 80+ |
| Mahdia | MAH | 60+ |
| Monastir | MON | 50+ |
| Tozeur | TOZ | 30+ |
| Tabarka | TAB | 25+ |

---

## 🛠️ OUTILS DE DÉVELOPPEMENT

### Postman Collection

Télécharger collection Postman officielle:
- https://developer.hotelbeds.com/documentation/getting-started/

### Swagger UI

Tester l'API en ligne:
- https://developer.hotelbeds.com/api-console/

### Documentation

Référence complète:
- https://developer.hotelbeds.com/documentation/

---

## 📞 CONTACTS SUPPORT

### Hotelbeds
- **Email Support:** developer@hotelbeds.com
- **Documentation:** https://developer.hotelbeds.com
- **Forum:** https://developer.hotelbeds.com/forum
- **Slack Community:** (demander accès)

### Amadeus
- **Support Portal:** https://developers.amadeus.com/support
- **Email:** developers@amadeus.com

### Expedia
- **Support:** Via portail développeur
- **Documentation:** https://developers.expediagroup.com/docs

---

## ✅ CHECKLIST INTÉGRATION

Avant de commencer le développement:

- [ ] Compte Hotelbeds créé
- [ ] Licence touristique obtenue
- [ ] Contrat partenaire signé
- [ ] Clés API Test reçues
- [ ] Documentation lue
- [ ] Service Laravel créé
- [ ] Tests unitaires écrits
- [ ] Cache Redis configuré
- [ ] Logs configurés
- [ ] Monitoring en place

En production:

- [ ] Clés API Production reçues
- [ ] Tests charge effectués
- [ ] Gestion erreurs robuste
- [ ] Backups configurés
- [ ] Webhooks configurés (si dispo)
- [ ] Rate limiting en place
- [ ] Alertes configurées

---

## 🎓 RESSOURCES D'APPRENTISSAGE

### Tutoriels Vidéo
- YouTube: "Hotelbeds API Tutorial"
- YouTube: "Laravel Hotel Booking System"

### Articles de Blog
- "Building a Hotel Booking API with Laravel"
- "Integrating Hotelbeds into your Travel App"

### Cours en Ligne
- Udemy: "Laravel Travel Booking System"
- Pluralsight: "Building APIs in Laravel"

---

## 💡 CONSEILS D'EXPERT

### 1. Toujours Cacher les Résultats
```php
// Mauvais
$hotels = $hotelbeds->search(...);

// Bon
$hotels = Cache::remember('search_key', 900, function() {
    return $hotelbeds->search(...);
});
```

### 2. Gérer les Erreurs Proprement
```php
try {
    $result = $hotelbeds->search(...);
} catch (ConnectionException $e) {
    Log::error('Hotelbeds connection failed: ' . $e->getMessage());
    return back()->with('error', 'Service temporairement indisponible');
} catch (\Exception $e) {
    Log::error('Unexpected error: ' . $e->getMessage());
    return back()->with('error', 'Une erreur est survenue');
}
```

### 3. Utiliser les Jobs pour Réservations
```php
// Meilleur performance
dispatch(new CreateHotelBookingJob($bookingData));
```

### 4. Logger Toutes les Requêtes API
```php
Log::channel('api')->info('Hotelbeds Search', [
    'destination' => $dest,
    'dates' => [$checkIn, $checkOut],
    'response_time' => $responseTime,
]);
```

---

## 🔐 SÉCURITÉ

### Protéger les Clés API

```php
// .env (JAMAIS dans Git)
HOTELBEDS_API_KEY=xxxxx
HOTELBEDS_SECRET=xxxxx

// .gitignore
.env
.env.backup
```

### Rate Limiting

```php
// Limiter requêtes par IP
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/hotels/search', [HotelController::class, 'search']);
});
```

---

## 📈 MONITORING

### Métriques à Suivre

1. **Temps de Réponse API**
   - Cible: < 2 secondes
   
2. **Taux de Succès**
   - Cible: > 99%
   
3. **Taux de Cache Hit**
   - Cible: > 80%
   
4. **Erreurs API**
   - Alertes si > 5% échecs

### Outils Recommandés

- Laravel Telescope (dev)
- New Relic ou Datadog (production)
- Sentry (error tracking)
- Logs centralisés (ELK Stack)

---

## 🎯 CONCLUSION

**Pour Démarrer Votre Projet:**

1. **Aujourd'hui:** Créer compte Hotelbeds
2. **Semaine 1:** Obtenir clés API test
3. **Semaine 2:** Développer service Laravel
4. **Semaine 3:** Tester en sandbox
5. **Semaine 4:** Demander clés production
6. **Semaine 5-6:** Tests et optimisations
7. **Semaine 7:** Lancement !

**Questions?** Consultez la documentation Hotelbeds ou contactez leur support.

---

**Créé le:** 17 Novembre 2025  
**Pour:** CHOKRI - Agence de Voyage Tunisie  
**Par:** Claude AI Assistant

**Bon développement ! 🚀**
