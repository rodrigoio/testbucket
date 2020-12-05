FROM webdevops/php:7.2

RUN pecl install xdebug-2.8.1 && docker-php-ext-enable xdebug

WORKDIR /code

COPY . .

RUN rm -rf vendor
RUN composer1 install

# Create test bucket directory
RUN mkdir -p /code/tmp/bucket
