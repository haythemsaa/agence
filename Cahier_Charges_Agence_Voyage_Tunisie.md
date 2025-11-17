# CAHIER DES SPÉCIFICATIONS FONCTIONNELLES DÉTAILLÉES
## Plateforme d'Agence de Voyage - Tunisie

---

**Version:** 1.0  
**Date:** 17 Novembre 2025  
**Client:** CHOKRI  
**Projet:** Système de Réservation Hôtelière et Organisation de Voyages

---

## 📋 RÉSUMÉ EXÉCUTIF

### Vision du Projet
Développement d'une plateforme web complète permettant la réservation d'hôtels en Tunisie et à l'international, ainsi que l'organisation de voyages organisés (circuits, séjours, Omra).

### Objectifs Principaux
- ✅ Réservation hôtels temps réel via APIs internationales
- ✅ Gestion complète des voyages organisés
- ✅ Espace client avec programme de fidélité
- ✅ Back-office administrateur complet
- ✅ Multi-paiement sécurisé

### Budget & Durée
- **Durée:** 6 mois de développement
- **Budget:** ~96,000 TND (année 1)
- **Équipe:** 6-7 personnes

---

## 📑 TABLE DES MATIÈRES

1. [SOURCES D'APIs HÔTELIÈRES](#1-sources-dapis-hôtelières)
2. [PRÉSENTATION GÉNÉRALE](#2-présentation-générale)
3. [ARCHITECTURE TECHNIQUE](#3-architecture-technique)
4. [SPÉCIFICATIONS FONCTIONNELLES](#4-spécifications-fonctionnelles)
5. [SYSTÈME DE PAIEMENT](#5-système-de-paiement)
6. [SÉCURITÉ ET RGPD](#6-sécurité-et-rgpd)
7. [PLAN DE DÉVELOPPEMENT](#7-plan-de-développement)
8. [BUDGET ET ROI](#8-budget-et-roi)

---

## 1. SOURCES D'APIs HÔTELIÈRES

### 🎯 APIs Recommandées pour la Tunisie

#### ⭐ OPTION 1 : Hotelbeds API (RECOMMANDÉ)

**Pourquoi Hotelbeds?**
- ✅ Plus de 180,000 hôtels mondialement
- ✅ Excellente couverture Tunisie
- ✅ API REST moderne et bien documentée
- ✅ Prix B2B compétitifs
- ✅ Support technique réactif

**Comment Accéder:**
1. Site: https://developer.hotelbeds.com
2. Créer un compte développeur
3. Contacter le service commercial
4. Signer un contrat partenaire
5. Recevoir vos clés API (test + production)

**Coût:**
- Gratuit à l'intégration
- Commission par réservation (8-12%)
- Pas de frais mensuels fixes

**Endpoints Principaux:**
```
POST /hotel-api/1.0/hotels - Recherche disponibilité
POST /hotel-api/1.0/checkrates - Vérification tarifs
POST /hotel-api/1.0/bookings - Création réservation
GET /hotel-api/1.0/bookings/{id} - Détails réservation
DELETE /hotel-api/1.0/bookings/{id} - Annulation
```

**Exemple d'Intégration Laravel:**
```php
// Service Hotelbeds
class HotelbedsService
{
    public function searchHotels($destination, $checkIn, $checkOut, $adults)
    {
        $response = Http::withHeaders([
            'Api-key' => config('services.hotelbeds.key'),
            'X-Signature' => $this->generateSignature(),
        ])->post('https://api.hotelbeds.com/hotel-api/1.0/hotels', [
            'stay' => [
                'checkIn' => $checkIn,
                'checkOut' => $checkOut,
            ],
            'occupancies' => [
                ['rooms' => 1, 'adults' => $adults]
            ],
            'destination' => ['code' => $destination],
        ]);
        
        return $response->json();
    }
}
```

---

#### ⭐ OPTION 2 : Amadeus Hotel API

**Avantages:**
- ✅ GDS réputé mondialement
- ✅ Self-service API
- ✅ 2000-3000 requêtes gratuites/mois (test)
- ✅ Documentation excellente

**Comment Accéder:**
1. Site: https://developers.amadeus.com
2. Créer un compte (inscription gratuite)
3. Obtenir API key immédiatement
4. Utiliser sandbox gratuitement
5. Passer en production (payant)

**Coût:**
- Test: Gratuit (limite requêtes)
- Production: €0.015-0.03 par requête
- Pas d'abonnement mensuel

---

#### ⭐ OPTION 3 : Expedia Rapid API

**Avantages:**
- ✅ Inventaire global massif
- ✅ Bonne couverture Tunisie
- ✅ API moderne REST/JSON

**Comment Accéder:**
1. Site: https://developers.expediagroup.com
2. Inscription compte développeur
3. Soumission demande d'approbation
4. Validation (peut prendre 2-4 semaines)

**Coût:**
- Gratuit
- Commission par réservation

---

#### ❌ BOOKING.COM - À ÉVITER

**Pourquoi NE PAS utiliser Booking.com directement:**
- ❌ API réservée aux hôteliers partenaires
- ❌ Pas d'accès public pour agences
- ❌ Programme affiliation seulement (liens trackés)
- ❌ Pas de réservation directe via API

**Alternative:**
Utiliser un agrégateur comme Hotelbeds qui inclut déjà l'inventaire Booking.com.

---

### 🏆 STRATÉGIE RECOMMANDÉE

**Phase 1 (MVP - 3 mois):**
- Intégrer uniquement **Hotelbeds**
- Focus sur hôtels Tunisie
- Mise en cache intelligente

**Phase 2 (6 mois):**
- Ajouter **Amadeus** ou **Expedia**
- Comparateur multi-sources
- Optimisation commissions

**Phase 3 (12 mois):**
- Meta-search complet
- 3-4 APIs simultanément
- Machine learning pour meilleur prix

---

## 2. PRÉSENTATION GÉNÉRALE

### 2.1 Contexte

Développement d'une plateforme moderne pour agence de voyage tunisienne permettant:
- 🏨 Réservation d'hôtels en Tunisie et international
- ✈️ Organisation de circuits touristiques en Tunisie
- 🕌 Voyages religieux (Omra, Hajj)
- 🌍 Voyages organisés à l'étranger (Turquie, Europe, Égypte)

### 2.2 Public Cible

**B2C (Particuliers):**
- Tunisiens voyageant localement ou à l'étranger
- Touristes étrangers visitant la Tunisie
- Familles et groupes
- Voyageurs d'affaires

**B2B (Professionnels):**
- Agences de voyage partenaires
- Tour-opérateurs
- Comités d'entreprises

### 2.3 Fonctionnalités Clés

✅ **Recherche et Réservation Hôtels**
- Recherche multicritères
- Comparaison temps réel
- Réservation instantanée
- Confirmation immédiate

✅ **Voyages Organisés**
- Circuits Sud tunisien
- Séjours balnéaires
- Omra et Hajj
- Voyages internationaux

✅ **Espace Client**
- Gestion réservations
- Programme fidélité
- Favoris et alertes
- Historique et factures

✅ **Back-Office**
- Gestion réservations
- Gestion contenus
- Rapports financiers
- CRM clients

---

## 3. ARCHITECTURE TECHNIQUE

### 3.1 Stack Technologique

**Backend:**
- **Laravel 11** (PHP 8.3+)
- Architecture MVC + Services
- Queue System (Redis + Supervisor)
- API RESTful

**Frontend:**
- **Blade Templates**
- **Vue.js 3** (réactivité)
- **Tailwind CSS** (design)
- **Alpine.js** (interactions)

**Base de Données:**
- **MySQL 8.0** (données principales)
- **Redis** (cache + sessions + queues)
- **Elasticsearch** (recherche avancée - optionnel)

**Infrastructure:**
- Linux Ubuntu 22.04 LTS
- Nginx (serveur web)
- SSL/TLS (Let's Encrypt)
- CDN Cloudflare

### 3.2 Architecture Système

```
UTILISATEURS WEB
      ↓
  CLOUDFLARE CDN
      ↓
  NGINX (SSL/TLS)
      ↓
LARAVEL APPLICATION
  ├── Controllers
  ├── Services
  ├── Repositories
  ├── Jobs/Queues
  └── Events
      ↓
  ┌───┴───┐
  ↓       ↓
MYSQL   REDIS
      ↓
APIS EXTERNES
├── Hotelbeds
├── Amadeus
├── Stripe
└── PayPal
```

### 3.3 Base de Données Principale

**Tables Essentielles:**

```sql
-- Utilisateurs
users (id, email, password, role, points_fidelite...)

-- Hôtels (cache local)
hotels (id, api_provider, api_hotel_id, name, city, country...)

-- Réservations Hôtels
hotel_bookings (id, booking_reference, user_id, hotel_id, 
                check_in, check_out, total_price, status...)

-- Packages/Circuits
travel_packages (id, title, type, duration_days, price_adult, 
                 destinations, itinerary, available_dates...)

-- Réservations Packages
package_bookings (id, booking_reference, package_id, 
                  departure_date, nb_adults, total_price...)

-- Paiements
payments (id, booking_type, booking_id, amount, 
          payment_method, transaction_id, status...)

-- Avis
reviews (id, user_id, reviewable_type, reviewable_id, 
         rating, comment, is_published...)
```

---

## 4. SPÉCIFICATIONS FONCTIONNELLES

### 4.1 Page d'Accueil

**Hero Section:**
```
┌─────────────────────────────────────────┐
│   🌴 Découvrez la Tunisie,              │
│      Explorez le Monde                  │
│                                         │
│  [Hôtels] [Circuits] [Voyages Organisés]│
│                                         │
│  Destination: [________]  Date: [____]  │
│  Voyageurs: [2 ▼]  [🔍 RECHERCHER]      │
└─────────────────────────────────────────┘
```

**Sections:**
1. **Destinations Populaires** (8 cards)
   - Hammamet, Sousse, Djerba, Tunis...
   
2. **Offres Spéciales** (carrousel)
   - Promos -25%, Early booking, Last minute
   
3. **Circuits Coups de Cœur** (6 cards)
   - Grand Sud, Omra, Turquie...
   
4. **Témoignages Clients** (carrousel)
   - Avis vérifiés avec photos
   
5. **Pourquoi Nous Choisir** (4 blocs)
   - Prix garantis, Paiement sécurisé, Support 24/7

### 4.2 Recherche et Résultats Hôtels

**Formulaire de Recherche:**
- Destination (autocomplete)
- Dates (check-in / check-out)
- Voyageurs (adultes, enfants, chambres)

**Filtres Avancés:**
- Budget (range slider)
- Étoiles (2★ à 5★)
- Formule (RO, BB, HB, FB, AI)
- Équipements (WiFi, Piscine, Spa...)
- Note clients (6+ à 9+)
- Distance (centre, plage, aéroport)

**Tri:**
- Recommandés
- Prix croissant/décroissant
- Étoiles
- Note clients
- Distance

**Carte Hôtel (résultats):**
```
┌────────────────────────────────────────┐
│ [Photo] Hotel Golden Yasmin ⭐⭐⭐⭐    │
│         Hammamet, Tunisie              │
│         📍 Plage: 150m • Centre: 2km   │
│         🌟 8.7/10 (1,234 avis)         │
│         ✓ WiFi ✓ Piscine ✓ All Incl.  │
│                                        │
│         450 TND/nuit                   │
│         [Voir détails] [Réserver]      │
└────────────────────────────────────────┘
```

### 4.3 Page Détail Hôtel

**Sections:**

1. **Galerie Photos** (lightbox)
   - Photo principale + 4 thumbnails
   - "Voir toutes les photos" (30+)

2. **Informations Principales**
   - Nom, étoiles, note, localisation
   - Description complète

3. **Chambres & Tarifs**
   - Liste types de chambres
   - Prix par formule (RO/BB/HB/FB/AI)
   - Disponibilité temps réel
   - Politique annulation

4. **Équipements** (catégorisés)
   - Général, Piscine, Restauration, Spa, Activités

5. **Localisation**
   - Carte interactive
   - Points d'intérêt à proximité

6. **Avis Clients**
   - Note détaillée par critère
   - Liste avis avec filtres
   - Possibilité de répondre (hôtel)

### 4.4 Processus de Réservation Hôtel

**4 Étapes:**

**Étape 1: Sélection Chambre**
- Choix type chambre
- Choix formule
- Options (transfert, assurance)

**Étape 2: Informations Voyageurs**
- Civilité, Nom, Prénom
- Email, Téléphone
- Demandes spéciales

**Étape 3: Paiement**
- Choix mode paiement
  - Carte bancaire (Stripe)
  - PayPal
  - Flouci (mobile TN)
  - Virement bancaire
- Saisie informations paiement
- Acceptation CGV

**Étape 4: Confirmation**
- Numéro réservation
- Email confirmation
- Voucher téléchargeable
- Informations pratiques

### 4.5 Voyages Organisés

**Types de Packages:**

**Circuits Tunisie:**
- Grand Sud (7j/6n) - 899 TND
- Perles du Nord (5j/4n) - 649 TND
- Circuit Berbère (4j/3n) - 549 TND

**Séjours Balnéaires:**
- Djerba All Inclusive (7j) - 799 TND
- Hammamet Thalasso (7j) - 849 TND

**Voyages Religieux:**
- Omra Économique (10j) - 2,999 TND
- Omra Confort (12j) - 3,999 TND
- Hajj (selon calendrier) - 8,999 TND

**Voyages International:**
- Istanbul City Break (4j) - 1,299 TND
- Turquie Impériale (8j) - 2,499 TND
- Croisière Nil + Caire (8j) - 2,799 TND

**Page Détail Circuit:**
- Programme jour par jour
- Hébergements
- Inclus / Non inclus
- Dates de départ
- Tarifs et suppléments
- Avis clients

### 4.6 Espace Client

**Dashboard:**
- Prochains voyages (avec countdown)
- Historique réservations
- Points fidélité
- Offres personnalisées

**Sections:**
- Mes Réservations (à venir, passées, annulées)
- Mes Informations
- Programme Fidélité
- Mes Favoris
- Mes Avis
- Mes Documents (factures, vouchers)

**Programme Fidélité:**
```
Niveau: ARGENT (1,250 pts)
━━━━━━━━░░░░ 71% vers OR

Avantages:
✓ -5% sur réservations
✓ Upgrade chambre
✓ Late check-out gratuit

1 TND = 1 point
```

---

## 5. SYSTÈME DE PAIEMENT

### 5.1 Gateways de Paiement

**Stripe (International):**
- Cartes bancaires
- 3D Secure intégré
- Multi-devises
- Commission: 2.9% + 0.30€

**PayPal:**
- Compte PayPal ou carte
- Protection acheteur
- Commission: 3.4% + frais fixe

**Flouci (Tunisie):**
- Paiement mobile local
- Populaire en Tunisie
- Commission: ~2%

**Virement Bancaire:**
- RIB affiché
- Validation manuelle
- Délai 48h

### 5.2 Paiement en Plusieurs Fois

**Conditions:**
- Montant > 500 TND
- Options: 2x, 3x, 4x
- 1ère échéance à la réservation
- Rappels automatiques

### 5.3 Sécurité

- ✅ SSL/TLS obligatoire
- ✅ PCI DSS compliance
- ✅ 3D Secure
- ✅ Tokens (pas de stockage carte)
- ✅ Détection fraude

---

## 6. SÉCURITÉ ET RGPD

### 6.1 Authentification

**Laravel Sanctum:**
- Tokens API sécurisés
- Sessions persistantes
- Rate limiting

**2FA (Two-Factor):**
- Activation optionnelle
- QR code Google Authenticator
- Codes de secours

### 6.2 Protection RGPD

**Consentements:**
- CGV (obligatoire)
- Politique confidentialité (obligatoire)
- Newsletter (optionnel)
- Tracking stocké en DB

**Droits Utilisateurs:**
- ✅ Droit à l'information
- ✅ Droit d'accès (export données)
- ✅ Droit de rectification
- ✅ Droit à l'oubli (suppression compte)
- ✅ Droit à la portabilité

### 6.3 Sécurité Applicative

- ✅ Protection CSRF (Laravel)
- ✅ Protection XSS (échappement Blade)
- ✅ Protection SQL Injection (Eloquent ORM)
- ✅ Rate limiting (anti-DDoS)
- ✅ Headers sécurité (X-Frame-Options, CSP...)

### 6.4 Backups

**Automatisés Quotidiens:**
- Base de données (MySQL dump)
- Fichiers uploads
- Stockage: Local + S3
- Rétention: 30 jours

**Plan de Récupération:**
- RTO (Recovery Time Objective): 4h
- RPO (Recovery Point Objective): 24h

---

## 7. PLAN DE DÉVELOPPEMENT

### 7.1 Méthodologie Agile

**Sprints de 2 semaines:**
- Planning sprint
- Daily standup (15 min)
- Sprint review
- Retrospective

### 7.2 Phases du Projet (6 mois)

**PHASE 1: Fondations (3 semaines)**
- Setup environnements
- Architecture Laravel
- Base de données
- Design system
- Authentification

**PHASE 2: Module Hôtels (6 semaines)**
- Intégration API Hotelbeds
- Recherche et filtres
- Page détail hôtel
- Processus réservation
- Intégration Stripe
- Emails confirmation

**PHASE 3: Module Circuits (5 semaines)**
- CRUD packages
- Programme jour/jour
- Réservation circuits
- Gestion participants
- Documents (convocations)
- Paiement échelonné

**PHASE 4: Espace Client (3 semaines)**
- Dashboard
- Gestion réservations
- Programme fidélité
- Favoris et avis
- Documents

**PHASE 5: Marketing & SEO (2 semaines)**
- Codes promo
- Campagnes email
- SEO on-page
- Analytics
- Optimisation performance

**PHASE 6: Tests & Lancement (3 semaines)**
- Tests fonctionnels
- Tests charge
- Tests sécurité
- Corrections bugs
- Déploiement production
- Formation équipe

### 7.3 Équipe Projet

**Ressources:**
- 1 Chef de projet / PO
- 2 Développeurs Backend Laravel
- 1 Développeur Frontend
- 1 Designer UI/UX
- 1 QA Tester
- 1 DevOps (partiel)

---

## 8. BUDGET ET ROI

### 8.1 Budget Développement

**Année 1:**

**Développement (6 mois):**
- Chef de projet: 18,000 TND
- 2 Dev Backend: 36,000 TND
- Dev Frontend: 15,000 TND
- Designer: 6,000 TND
- QA Tester: 6,000 TND
- DevOps: 5,000 TND
**Sous-total: 86,000 TND**

**Services & Infrastructure:**
- APIs (Hotelbeds, Stripe): Gratuit (commissions)
- Hébergement VPS: 1,500 TND/an
- Google Maps API: 1,000 TND/an
- Emails (SendGrid): 500 TND/an
- CDN: 200 TND/an
- Monitoring: 400 TND/an
**Sous-total: 3,600 TND**

**Divers:**
- Stock photos: 500 TND
- Outils dev: 1,000 TND
- Formation: 1,000 TND
**Sous-total: 2,500 TND**

**TOTAL ANNÉE 1: 92,100 TND**

**Coûts Récurrents Annuels: ~7,000 TND**
(hébergement + services)

### 8.2 Projections Financières

**Année 1:**
- Réservations: 1,500
- CA: 500,000 TND
- Marge nette: ~15% = 75,000 TND

**Année 2:**
- Réservations: 4,000
- CA: 1,400,000 TND
- Marge nette: ~20% = 280,000 TND

**Année 3:**
- Réservations: 8,000
- CA: 3,000,000 TND
- Marge nette: ~25% = 750,000 TND

**ROI: 10-14 mois**

### 8.3 KPIs de Succès

**Objectifs Année 1:**
- 50,000 visiteurs uniques
- Taux de conversion: 3%
- 1,500 réservations
- Panier moyen: 350 TND
- Satisfaction: 4.5/5
- NPS: >50

---

## 9. BACK-OFFICE ADMIN

### 9.1 Dashboard

**KPIs Temps Réel:**
- CA jour/mois/année
- Nombre réservations
- Taux de conversion
- Panier moyen
- Nouvelles inscriptions

**Widgets:**
- Réservations récentes
- Paiements en attente
- Alertes système
- Tâches à faire

### 9.2 Gestion Réservations

**Fonctionnalités:**
- Liste toutes réservations
- Filtres avancés
- Détail réservation
- Modifier/Annuler
- Rembourser
- Exporter rapports
- Envoyer emails clients

### 9.3 Gestion Contenus

**Hôtels:**
- Modifier descriptions locales
- Ajouter photos
- Mise en avant (featured)
- Activer/désactiver

**Packages/Circuits:**
- CRUD complet
- Calendrier départs
- Gestion places
- Tarification dynamique

**Pages Statiques:**
- À propos
- CGV
- FAQ
- Blog (optionnel)

### 9.4 Gestion Clients

- Liste clients
- Profil détaillé
- Historique
- Points fidélité
- Notes internes
- Actions (email, bannir...)

### 9.5 Rapports Financiers

**Disponibles:**
- CA par période
- CA par type produit
- CA par destination
- Commissions APIs
- Remboursements
- Prévisions

**Exports:** PDF, Excel, CSV

### 9.6 Paramètres

**Généraux:**
- Infos agence
- Logo, favicon
- Réseaux sociaux
- Devise, langue

**Paiement:**
- Config gateways
- Clés API
- Modes test/prod

**APIs:**
- Config Hotelbeds
- Config Amadeus
- Test connexions
- Gestion cache

**Marketing:**
- Codes promo
- Campagnes email
- Bannières
- SEO

---

## 10. CHECKLIST LANCEMENT

### Technique
- [ ] Tests passent (100%)
- [ ] Performance >85 (PageSpeed)
- [ ] SSL activé
- [ ] Backups configurés
- [ ] Monitoring actif
- [ ] CDN configuré
- [ ] Cache optimisé

### Contenu
- [ ] Textes finalisés
- [ ] Images optimisées
- [ ] CGV rédigées
- [ ] FAQ complète
- [ ] Pages erreur

### Marketing
- [ ] Analytics configuré
- [ ] Search Console
- [ ] Sitemap soumis
- [ ] Réseaux sociaux
- [ ] Newsletter prête

### Business
- [ ] APIs en production
- [ ] Paiements testés
- [ ] Support formé
- [ ] Contrats signés
- [ ] Licences obtenues

### Juridique
- [ ] Entreprise enregistrée
- [ ] Licence touristique
- [ ] Assurances
- [ ] RGPD compliant
- [ ] Contrats partenaires

---

## 11. RECOMMANDATIONS FINALES

### APIs à Utiliser

**✅ RECOMMANDÉ:**
1. **Hotelbeds** - API principale (Start dès maintenant)
2. **Amadeus** - API secondaire (Ajouter Phase 2)
3. **Expedia Rapid** - API tertiaire (Optionnel Phase 3)

**❌ À ÉVITER:**
- Booking.com en direct (pas d'API publique)
- APIs obscures ou non documentées
- Solutions "faites maison" scraping

### Priorisation Fonctionnalités

**Must Have (MVP):**
- ✅ Recherche et réservation hôtels
- ✅ Processus paiement sécurisé
- ✅ Espace client basique
- ✅ Back-office gestion

**Should Have (Phase 2):**
- ✅ Voyages organisés complets
- ✅ Programme fidélité
- ✅ Système avis clients
- ✅ Multi-paiement

**Could Have (Phase 3):**
- Application mobile
- Chatbot IA
- Réalité augmentée
- API publique partenaires

### Conseils Clés

1. **Commencer Simple:** MVP avec Hotelbeds uniquement
2. **Itérer Rapidement:** Sprints courts, feedback continu
3. **Focus UX:** Mobile-first, performance, simplicité
4. **Sécurité Dès le Début:** HTTPS, RGPD, backups
5. **Tester Continuellement:** QA à chaque sprint
6. **Former l'Équipe:** Documentation, formation continue

---

## 12. CONTACTS ET RESSOURCES

### Documentation APIs

**Hotelbeds:**
- Docs: https://developer.hotelbeds.com
- Support: developer@hotelbeds.com

**Amadeus:**
- Docs: https://developers.amadeus.com
- Support: https://developers.amadeus.com/support

**Expedia:**
- Docs: https://developers.expediagroup.com
- Support: Via portail développeur

### Laravel

- Docs: https://laravel.com/docs
- Community: https://laracasts.com
- Forum: https://laracasts.com/discuss

### Paiements

**Stripe:**
- Docs: https://stripe.com/docs
- Support: support@stripe.com

**PayPal:**
- Docs: https://developer.paypal.com
- Support: Via portail

---

## CONCLUSION

Ce cahier des charges détaille l'ensemble des spécifications pour développer une plateforme complète d'agence de voyage.

**Points Clés:**
- ✅ Utiliser **Hotelbeds** comme API principale
- ✅ Stack **Laravel + Vue.js + Tailwind**
- ✅ Durée **6 mois** de développement
- ✅ Budget **~92,000 TND** année 1
- ✅ ROI attendu sous **12-14 mois**

**Prochaines Étapes:**
1. Valider ce cahier des charges
2. S'inscrire sur Hotelbeds
3. Constituer l'équipe
4. Démarrer Phase 1

---

**Document créé le:** 17 Novembre 2025  
**Version:** 1.0 Complète  
**Pour:** CHOKRI  
**Par:** Claude AI Assistant

📧 **Contact:** chokri@exemple.tn  
🌐 **Site:** (à définir)

---

**FIN DU DOCUMENT**

*Ce cahier des charges est un document de travail évolutif. Les spécifications peuvent être ajustées selon les besoins du projet.*
