FROM php:8.3-apache

# Install required PHP extensions and system packages
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libicu-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    bcmath \
    intl \
    zip

# Enable Apache rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set Laravel working directory
WORKDIR /var/www/html

# Copy project
COPY . .

COPY ca.pem /etc/ssl/certs/ca.pem

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Apache to serve Laravel public directory
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s|AllowOverride None|AllowOverride All|' /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]