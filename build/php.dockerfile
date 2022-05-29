FROM php:8.1-fpm

RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install opcache

COPY php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini