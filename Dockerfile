# Base image
FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Disable proxy settings explicitly
ENV http_proxy=""
ENV https_proxy=""
ENV no_proxy="localhost,127.0.0.1"

# Update and install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libxslt1-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    zlib1g-dev \
    libbz2-dev \
    libsqlite3-dev \
    libgmp-dev \
    libmagickwand-dev \
    build-essential \
    nano \
    --no-install-recommends

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm \
    && docker-php-ext-install -j$(nproc) gd intl opcache pdo_mysql mysqli xsl zip bcmath mbstring soap sockets

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Create system user
RUN useradd -G www-data,root -u ${uid} -d /home/${user} ${user} \
    && mkdir -p /home/${user}/.composer \
    && chown -R ${user}:${user} /home/${user}

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Copy Nginx configuration files
COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/magento.conf /etc/nginx/conf.d/magento.conf

# Expose port 9003 for Xdebug
EXPOSE 9003

# Switch to root user to add Xdebug configuration
USER root

# Additional PHP configuration for Xdebug
RUN echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Add the Composer proxy configuration if needed
RUN echo 'export COMPOSER_ALLOW_SUPERUSER=1' >> /etc/profile.d/composer.sh \
    && echo 'export COMPOSER_HOME=/tmp/composer' >> /etc/profile.d/composer.sh \
    && mkdir -p /tmp/composer \
    && chown -R ${user}:${user} /tmp/composer

# Ensure the script runs as the specified user
USER ${user}

