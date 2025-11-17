# 🚀 Guide de Déploiement - Agence de Voyage Tunisie

Ce guide détaille les étapes pour déployer l'application en production.

## 📋 Prérequis Serveur

### Configuration Minimale Recommandée
- **Serveur**: VPS ou serveur dédié
- **OS**: Ubuntu 22.04 LTS ou similaire
- **RAM**: 2 GB minimum (4 GB recommandé)
- **Stockage**: 20 GB SSD minimum
- **CPU**: 2 cores minimum

### Logiciels Requis
```bash
- PHP 8.3+
- Nginx ou Apache
- MySQL 8.0+
- Redis 6.0+
- Node.js 18+
- Composer 2.0+
- Git
- Certbot (SSL)
```

## 🔧 Installation Serveur

### 1. Mise à jour du système
```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Installation PHP 8.3
```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install -y php8.3 php8.3-fpm php8.3-mysql php8.3-mbstring \
  php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath php8.3-redis \
  php8.3-gd php8.3-intl
```

### 3. Installation MySQL
```bash
sudo apt install mysql-server -y
sudo mysql_secure_installation
```

Créer la base de données:
```sql
CREATE DATABASE agence_voyage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'agence_user'@'localhost' IDENTIFIED BY 'VotreMotDePasseSecurise';
GRANT ALL PRIVILEGES ON agence_voyage.* TO 'agence_user'@'localhost';
FLUSH PRIVILEGES;
```

### 4. Installation Redis
```bash
sudo apt install redis-server -y
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

### 5. Installation Node.js
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

### 6. Installation Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 7. Installation Nginx
```bash
sudo apt install nginx -y
sudo systemctl enable nginx
sudo systemctl start nginx
```

## 📦 Déploiement de l'Application

### 1. Cloner le projet
```bash
cd /var/www
sudo git clone https://github.com/haythemsaa/agence.git
sudo chown -R www-data:www-data /var/www/agence
cd /var/www/agence
```

### 2. Installer les dépendances
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Configuration de l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

Éditer `.env` avec vos valeurs de production:
```env
APP_NAME="Agence de Voyage Tunisie"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.tn

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agence_voyage
DB_USERNAME=agence_user
DB_PASSWORD=VotreMotDePasseSecurise

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Hotelbeds API
HOTELBEDS_API_KEY=votre_api_key
HOTELBEDS_SECRET=votre_secret
HOTELBEDS_BASE_URL=https://api.hotelbeds.com

# Stripe
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...

# PayPal
PAYPAL_MODE=live
PAYPAL_CLIENT_ID=...
PAYPAL_SECRET=...

# Flouci
FLOUCI_APP_TOKEN=...
FLOUCI_APP_SECRET=...

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io # Ou votre SMTP
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contact@votre-domaine.tn
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Exécuter les migrations
```bash
php artisan migrate --force
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=HotelSeeder
php artisan db:seed --class=TravelPackageSeeder
```

### 5. Optimisation pour la production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 6. Permissions
```bash
sudo chown -R www-data:www-data /var/www/agence
sudo chmod -R 755 /var/www/agence
sudo chmod -R 775 /var/www/agence/storage
sudo chmod -R 775 /var/www/agence/bootstrap/cache
```

## 🌐 Configuration Nginx

Créer le fichier de configuration:
```bash
sudo nano /etc/nginx/sites-available/agence
```

Contenu:
```nginx
server {
    listen 80;
    server_name votre-domaine.tn www.votre-domaine.tn;
    root /var/www/agence/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Activer le site:
```bash
sudo ln -s /etc/nginx/sites-available/agence /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 🔒 SSL avec Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d votre-domaine.tn -d www.votre-domaine.tn
```

Renouvellement automatique:
```bash
sudo certbot renew --dry-run
```

## 🔄 Configuration du Scheduler Laravel

Ajouter au crontab:
```bash
sudo crontab -e -u www-data
```

Ajouter:
```
* * * * * cd /var/www/agence && php artisan schedule:run >> /dev/null 2>&1
```

## 📊 Configuration des Queues (Optionnel)

Créer le service Supervisor:
```bash
sudo apt install supervisor -y
sudo nano /etc/supervisor/conf.d/agence-worker.conf
```

Contenu:
```ini
[program:agence-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/agence/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/agence/storage/logs/worker.log
stopwaitsecs=3600
```

Démarrer:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start agence-worker:*
```

## 🔐 Sécurité

### Firewall
```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### Fail2Ban
```bash
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### Désactiver les fonctions PHP dangereuses
Éditer `/etc/php/8.3/fpm/php.ini`:
```ini
disable_functions = exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source
```

## 📈 Monitoring

### Installation des logs
```bash
sudo apt install logrotate -y
```

Configuration `/etc/logrotate.d/agence`:
```
/var/www/agence/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

## 🔄 Mises à jour

Pour déployer les mises à jour:
```bash
cd /var/www/agence
git pull origin main
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload php8.3-fpm
sudo systemctl reload nginx
```

## ✅ Vérifications Post-Déploiement

1. ✅ Vérifier que le site est accessible via HTTPS
2. ✅ Tester la création d'un compte utilisateur
3. ✅ Tester une réservation d'hôtel
4. ✅ Tester une réservation de package
5. ✅ Vérifier l'envoi des emails
6. ✅ Tester le paiement Stripe en mode test
7. ✅ Vérifier l'accès admin
8. ✅ Tester la génération de PDF
9. ✅ Vérifier les logs d'erreurs
10. ✅ Tester les performances avec GTmetrix

## 🆘 Dépannage

### Logs à consulter
```bash
# Logs Laravel
tail -f /var/www/agence/storage/logs/laravel.log

# Logs Nginx
tail -f /var/log/nginx/error.log

# Logs PHP-FPM
tail -f /var/log/php8.3-fpm.log
```

### Commandes utiles
```bash
# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Redémarrer les services
sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx
sudo systemctl restart redis-server
```

## 📞 Support

Pour toute question ou problème:
- Email: support@votre-domaine.tn
- Documentation: https://laravel.com/docs

---

**Développé pour CHOKRI - Novembre 2025**
