# Use official PHP image with FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    git \
    curl \
    zip \
    unzip

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo pdo_sqlite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy the application into the container
COPY . /var/www/html

# Install PHP dependencies
RUN composer install

# Expose port for the Laravel development server
EXPOSE 8000

# Create a custom script to start both the Laravel server and the queue worker
COPY ./.docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Command to run the custom script
CMD ["start.sh"]