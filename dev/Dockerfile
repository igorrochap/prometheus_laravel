FROM php:8.1-fpm

# Copy composer.lock and composer.json
#COPY composer.lock /var/www/
#COPY composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl xml pdo_sqlite bcmath gd

RUN pecl install redis && docker-php-ext-enable redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

RUN (crontab -l ; echo "* * * * * php /app/sas-api/artisan schedule:run >> /app/sas-api/storage/logs/laravel.log 2>&1") | crontab

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
