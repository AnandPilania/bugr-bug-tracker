FROM php:8.1

# Ensure container packages are up to date
RUN apt-get update

# Install dependencies of PHP packages
RUN apt-get install libzip-dev zip -y

# Install Git so Composer can download dependencies
RUN apt-get install git -y

# Install database dependencies
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install zip

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && cp composer.phar /usr/bin/composer \
    && rm composer-setup.php \
    && rm composer.phar

# Set working directory so when we connect via a shell we're in the right place
WORKDIR /var/www/tests

COPY test/composer.json composer.json
RUN composer install