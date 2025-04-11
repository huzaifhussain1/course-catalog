# Dockerfile for api service

FROM php:8.3-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Allow .htaccess overrides in Apache config
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Optional: Install useful PHP extensions
RUN docker-php-ext-install pdo pdo_mysql
