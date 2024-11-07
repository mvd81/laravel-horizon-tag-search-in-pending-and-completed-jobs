FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    curl \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

# Install Redis Extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy supervisor conf files
COPY supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Set working directory
WORKDIR /app

# Copy composer files and install dependencies
#COPY composer.json composer.lock ./
#RUN composer install --no-scripts --no-interaction --prefer-dist

# Copy the rest of the project files
COPY . .

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
