FROM php:7.3.28-cli

RUN apt-get update -y && apt-get upgrade -y && apt-get install -y openssl zip unzip git libpq-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_pgsql
WORKDIR /app
COPY . /app
RUN composer install
CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181
