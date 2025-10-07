FROM php:8.1-fpm

ARG UID

# Create user and some useful stuff
RUN adduser -u ${UID} --disabled-password --gecos "" appuser
RUN mkdir /home/appuser/.ssh
RUN chown -R appuser:appuser /home/appuser/

# Copy PHP config file
COPY ./php.ini /usr/local/etc/php/php.ini

# Install PHP extensions
RUN apt-get update && apt-get install -y \
        git \
        wget \
        unzip \
        libaio-dev \
        libpq-dev \
        libssh-dev \
        libonig-dev \
    && docker-php-ext-install \
        pcntl \
        mbstring
RUN pecl install xdebug

# Install and update composer
RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update

## Install Symfony binary
USER appuser
RUN wget https://get.symfony.com/cli/installer -O - | bash
USER root
RUN mv /home/appuser/.symfony5/bin/symfony /usr/local/bin/symfony

# Copy XDEBUG config file
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Create working directory
RUN mkdir -p /appdata/www
WORKDIR /appdata/www