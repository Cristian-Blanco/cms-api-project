#!/bin/bash

# Enter html directory
cd /var/www/html/

# Permissions in directory
sudo chown -Rf www-data:www-data /var/www/html/
sudo chmod -Rf 777 /var/www/html/

# Create cache and chmod folders
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/public/files/

# Install dependencies
export COMPOSER_ALLOW_SUPERUSER=1
composer install -d /var/www/html/

# Copy configuration from /var/www/.env, see README.MD for more information
cp /var/www/html/.env.example /var/www/html/.env

php artisan key:generate

# Migrate all tables
php /var/www/html/artisan migrate

# Install passport keys
php /var/www/html/artisan passport:install

# Clear any previous cached views
php /var/www/html/artisan config:clear
php /var/www/html/artisan cache:clear
php /var/www/html/artisan view:clear

# Optimize the application
php /var/www/html/artisan config:cache
php /var/www/html/artisan optimize
#php /var/www/html/artisan route:cache

# Change rights
chmod 777 -R /var/www/html/bootstrap/cache
chmod 777 -R /var/www/html/storage
chmod 777 -R /var/www/html/public/files/

# Bring up application
php /var/www/html/artisan up