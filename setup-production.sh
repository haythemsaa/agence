#!/bin/bash

# VoyageLuxe - Production Setup Script
# This script sets up the application for production use

set -e

echo "🚀 VoyageLuxe Production Setup"
echo "================================"
echo ""

# Check if running as root
if [ "$EUID" -eq 0 ]; then
   echo "⚠️  Please do not run this script as root"
   exit 1
fi

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Step 1: Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev
echo -e "${GREEN}✓${NC} PHP dependencies installed"
echo ""

# Step 2: Install Node dependencies and build assets
echo "🎨 Building frontend assets..."
npm install
npm run build
echo -e "${GREEN}✓${NC} Frontend assets built"
echo ""

# Step 3: Environment setup
if [ ! -f .env ]; then
    echo "⚙️  Setting up environment file..."
    cp .env.production.example .env
    echo -e "${YELLOW}⚠${NC} Please edit .env file with your production credentials"
    echo ""
else
    echo -e "${GREEN}✓${NC} .env file already exists"
    echo ""
fi

# Step 4: Generate application key
echo "🔑 Generating application key..."
php artisan key:generate --force
echo -e "${GREEN}✓${NC} Application key generated"
echo ""

# Step 5: Run database migrations
read -p "🗄️  Run database migrations? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan migrate --force
    echo -e "${GREEN}✓${NC} Database migrations completed"
    echo ""
fi

# Step 6: Seed production data
read -p "🌱 Seed production data (hotels, packages, admin user)? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan db:seed --class=ProductionDataSeeder
    echo -e "${GREEN}✓${NC} Production data seeded"
    echo ""
    echo "📧 Admin credentials:"
    echo "   Email: admin@voyageluxe.tn"
    echo "   Password: VoyageLuxe2025!"
    echo -e "${YELLOW}   ⚠️  Please change the password after first login!${NC}"
    echo ""
fi

# Step 7: Clear and cache config
echo "🔄 Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✓${NC} Application optimized"
echo ""

# Step 8: Set permissions
echo "🔐 Setting file permissions..."
chmod -R 775 storage bootstrap/cache
echo -e "${GREEN}✓${NC} Permissions set"
echo ""

# Step 9: Create storage link
echo "🔗 Creating storage symlink..."
php artisan storage:link
echo -e "${GREEN}✓${NC} Storage link created"
echo ""

# Step 10: Setup supervisor for queues (optional)
read -p "⚙️  Setup queue worker with Supervisor? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    cat > /tmp/voyageluxe-worker.conf << 'EOF'
[program:voyageluxe-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/app/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=8
redirect_stderr=true
stdout_logfile=/path/to/your/app/storage/logs/worker.log
stopwaitsecs=3600
EOF
    echo ""
    echo "Supervisor config created at /tmp/voyageluxe-worker.conf"
    echo "Please move it to /etc/supervisor/conf.d/ and update paths"
    echo ""
fi

# Step 11: Setup cron jobs
read -p "⏰ Setup cron jobs for scheduled tasks? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    echo "Add this to your crontab (crontab -e):"
    echo "* * * * * cd $(pwd) && php artisan schedule:run >> /dev/null 2>&1"
    echo ""
fi

echo ""
echo "================================"
echo -e "${GREEN}✅ Production setup completed!${NC}"
echo "================================"
echo ""
echo "📋 Next steps:"
echo "   1. Edit .env file with production credentials"
echo "   2. Configure your web server (Nginx/Apache)"
echo "   3. Point document root to: $(pwd)/public"
echo "   4. Setup SSL certificate (Let's Encrypt recommended)"
echo "   5. Configure firewall rules"
echo "   6. Setup database backups"
echo "   7. Test the application"
echo ""
echo "🌐 Your application will be available at: $(grep APP_URL .env | cut -d '=' -f2)"
echo ""
echo -e "${YELLOW}⚠️  Important:${NC}"
echo "   - Change admin password immediately"
echo "   - Review all .env settings"
echo "   - Test payment integrations"
echo "   - Configure email settings"
echo ""
echo "📚 Documentation: README.md"
echo "💬 Support: contact@voyageluxe.tn"
echo ""
