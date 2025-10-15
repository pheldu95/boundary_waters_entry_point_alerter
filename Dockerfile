# syntax=docker/dockerfile:1

FROM composer:lts as deps

WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist

# Production stage
FROM php:8.3-apache as final

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    && docker-php-ext-install \
    pdo_mysql \
    intl \
    opcache \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for Symfony
RUN a2enmod rewrite

# Configure Apache for Symfony
COPY <<EOF /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    DocumentRoot /var/www/html/public
    
    <Directory /var/www/html/public>
        AllowOverride All
        Order Allow,Deny
        Allow from All
        
        # Use the front controller as index file
        FallbackResource /index.php
    </Directory>
    
    # Prevent access to files starting with .
    <FilesMatch "^\.">
        Require all denied
    </FilesMatch>
    
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Set recommended PHP.ini settings for Symfony
RUN { \
    echo 'memory_limit = 256M'; \
    echo 'upload_max_filesize = 50M'; \
    echo 'post_max_size = 50M'; \
    echo 'max_execution_time = 60'; \
    } > /usr/local/etc/php/conf.d/symfony-recommended.ini

# Copy composer dependencies from deps stage
COPY --from=deps /app/vendor /var/www/html/vendor

# Copy application code
COPY . /var/www/html

# Create var directory and set permissions
RUN mkdir -p /var/www/html/var \
    && chown -R www-data:www-data /var/www/html/var

# Switch to www-data user
USER www-data

WORKDIR /var/www/html