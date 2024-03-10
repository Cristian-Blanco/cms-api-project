#!/bin/bash

# Exit on error
set -o errexit -o pipefail

# Update sudo apt-get
sudo apt-get update -y

# Install packages
sudo apt-get install -y curl
sudo apt-get install -y git

# Remove current apache & php
sudo apt remove -y apache2 && sudo apt remove -y php* && sudo apt autoremove -y

# Install Apache 2.4
sudo apt-get -y install apache2

sudo ufw app list

sudo ufw allow 'Apache'

sudo ufw status

# Install PHP 
sudo apt-get install -y php php-cli php-common php-mysql php-zip php-gd php-mbstring php-curl php-xml php-bcmath

sudo apt install -y php-dom libapache2-mod-php

# Allow URL rewrites
sudo sed -i 's#AllowOverride None#AllowOverride All#' /etc/apache2/apache2.conf

# Change apache document root
mkdir -p /var/www/html/public
sudo sed -i 's#DocumentRoot /var/www/html#DocumentRoot "/var/www/html/public"#' /etc/apache2/sites-available/000-default.conf

# Change apache directory index
sudo sed -e 's/DirectoryIndex.*/DirectoryIndex index.html index.php/' -i /etc/apache2/apache2.conf

# Get Composer, and install to /usr/local/bin
if [ ! -f "/usr/local/bin/composer" ]; then
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir=/usr/bin --filename=composer
    php -r "unlink('composer-setup.php');"
else
    /usr/local/bin/composer self-update --stable --no-ansi --no-interaction
fi

# Restart apache
sudo service apache2 restart

# Ensure aws-cli is installed and configured
# if [ ! -f "/usr/bin/aws" ]; then
#     curl "https://s3.amazonaws.com/aws-cli/awscli-bundle.zip" -o "awscli-bundle.zip"
#     unzip awscli-bundle.zip
#     ./awscli-bundle/install -b /usr/bin/aws
# fi

# # Ensure AWS Variables are available
# if [[ -z "$AWS_ACCOUNT_ID" || -z "$AWS_DEFAULT_REGION " ]]; then
#     echo "AWS Variables Not Set.  Either AWS_ACCOUNT_ID or AWS_DEFAULT_REGION"
# fi
