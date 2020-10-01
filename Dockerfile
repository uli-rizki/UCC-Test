FROM php:7.0.8-apache

RUN apt-get -y clean && \
    apt-get -y update && \
    apt-get -y install git curl zlib1g-dev libcurl4-gnutls-dev && \
    pecl install mongodb && \
    docker-php-ext-install -j$(nproc) bcmath zip pdo_mysql mysqli curl pcntl && \
    sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#' /etc/apache2/sites-enabled/000-default.conf && \
    a2enmod rewrite

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 80
