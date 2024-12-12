FROM php:8.2-fpm

# Install system dependencies and netcat
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    libxml2-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libicu-dev \
    libonig-dev \
    netcat-openbsd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install gd zip pdo pdo_mysql mysqli opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# Copy the application code to the container
COPY . .

# Install PHP dependencies
RUN composer install

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www

CMD ["php-fpm"]
