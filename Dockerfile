FROM php:8.3.20-fpm

# Install system dependencies for PHP extensions and Composer
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    curl \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql curl

WORKDIR /var/www

COPY . /var/www

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
