# ./docker/php/Dockerfile
FROM php:7.2-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu

RUN apt-get update && \
apt-get install -y \
zlib1g-dev

RUN docker-php-ext-install zip
RUN docker-php-ext-enable apcu

# Install composer dependencies
RUN  exec php composer install

#RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
#    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '%SHA_384%') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
#    && php composer-setup.php --filename=composer \
#    && php -r "unlink('composer-setup.php');" \
#    && mv composer /usr/local/bin/composer

WORKDIR /usr/src/app

#COPY apps/my-symfony-app /usr/src/app

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
RUN bin/console doctrine:schema:create

#command: ["--default-authentication-plugin=mysql_native_password"]
