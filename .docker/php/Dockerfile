FROM php:7.3-fpm

RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip libzip-dev

RUN docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN usermod -u 1000 www-data