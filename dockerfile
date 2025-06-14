FROM php:8.2-apache

# Install PostgreSQL development library
RUN apt-get update && apt-get install -y libpq-dev

# Copy custom php.ini
COPY php.ini /usr/local/etc/php/conf.d/

# Install PDO_PGSQL extension
RUN docker-php-ext-install pdo_pgsql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy your application code
COPY . /var/www/html

EXPOSE 80
