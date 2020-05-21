FROM php:7.2-fpm

RUN pecl install xdebug-2.8.1 && docker-php-ext-enable xdebug
RUN pecl install ds && docker-php-ext-enable ds

WORKDIR /code