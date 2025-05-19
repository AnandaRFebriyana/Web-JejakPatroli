FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG user=www-data
ARG uid=1000

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Set permissions
RUN chown -R $user:$user /var/www
RUN chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Switch to non-root user
USER $user

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]