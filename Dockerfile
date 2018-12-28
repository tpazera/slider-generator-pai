FROM php:7.2.11-apache
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite