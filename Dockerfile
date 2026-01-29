FROM php:8.3-apache

RUN apt-get update \
  && apt-get install -y --no-install-recommends unzip zlib1g-dev \
  && docker-php-ext-install pdo_mysql mysqli \
  && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html

COPY app/ /var/www/html/
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
EXPOSE 80
CMD ["apache2ctl", "-D", "FOREGROUND"]
