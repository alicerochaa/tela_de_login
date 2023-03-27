FROM php:8.1-apache-buster

WORKDIR /home/app

#COPY app/composer.json .

ENV APACHE_DOCUMENT_ROOT /home/app

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

RUN apt-get update && \
    apt-get install -y libxml2-dev libsodium-dev git unzip

RUN docker-php-ext-install soap sodium mysqli pdo pdo_mysql

# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# RUN composer install --no-dev

# RUN cp -a /home/app/vendor /usr/local/lib/php/

EXPOSE 80