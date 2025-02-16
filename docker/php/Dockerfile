# Use official PHP image with required extensions
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies + Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Increase PHP memory limit (to avoid Composer errors)
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Copy Laravel project files
COPY . .

# Ensure correct permissions
RUN chown -R www-data:www-data /var/www/html

RUN mkdir -p /var/www/html/storage /var/www/html/storage/logs /var/www/html/bootstrap/cache && \
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose PHP port
EXPOSE 9000

# Start the container and run Composer at runtime
CMD ["sh", "-c", "composer install --no-interaction --prefer-dist && php-fpm"]
