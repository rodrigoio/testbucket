FROM php:7.1-fpm

RUN pecl install xdebug-2.8.1 \
    && docker-php-ext-enable xdebug

WORKDIR /code