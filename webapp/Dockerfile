# Use official PHP Apache image as base
FROM php:7.4-apache

# Copy all your web app files into the container's web root
COPY . /var/www/html/

# Optional: Enable any PHP extensions if needed, e.g. mysqli for MySQL support
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Expose port 80
EXPOSE 80
