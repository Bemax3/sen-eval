FROM php:8.2-fpm

COPY composer.lock composer.json /var/www/

WORKDIR /var/www

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    libz-dev \
    wget \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libssl-dev \
    libzip-dev \
    unzip \
    zip \
    nodejs \
    libldb-dev \
    libldap2-dev \
    libaio-dev \
    mc \
    unzip \
    zlib1g-dev \
    libmemcached-dev\
    && apt-get clean \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure ldap \
    && docker-php-ext-install \
        gd \
        exif \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        pcntl \
        zip \
        ldap \
    && docker-php-ext-enable ldap \
    && rm -rf /var/lib/apt/lists/*;

ENV LD_LIBRARY_PATH /opt/oracle/instantclient_21_1:$LD_LIBRARY_PATH

RUN apt-get update && apt-get install -y libaio1 wget unzip \
    && mkdir /opt/oracle

# Install Oracle Instantclient
RUN wget https://download.oracle.com/otn_software/linux/instantclient/216000/instantclient-basic-linux.x64-21.6.0.0.0dbru.zip \
    && wget https://download.oracle.com/otn_software/linux/instantclient/216000/instantclient-sdk-linux.x64-21.6.0.0.0dbru.zip \
    && wget https://download.oracle.com/otn_software/linux/instantclient/216000/instantclient-sqlplus-linux.x64-21.6.0.0.0dbru.zip \
    && unzip instantclient-basic-linux.x64-21.6.0.0.0dbru.zip -d /opt/oracle \
    && unzip instantclient-sdk-linux.x64-21.6.0.0.0dbru.zip -d /opt/oracle \
    && unzip instantclient-sqlplus-linux.x64-21.6.0.0.0dbru.zip -d /opt/oracle \
    && rm -rf *.zip \
    && mv /opt/oracle/instantclient_21_6 /opt/oracle/instantclient

#add oracle instantclient path to environment
ENV LD_LIBRARY_PATH /opt/oracle/instantclient/
RUN ldconfig

# Install Oracle extensions
RUN docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/opt/oracle/instantclient,21.1 \
&& echo 'instantclient,/opt/oracle/instantclient/' | pecl install oci8 \
&& docker-php-ext-install \
        pdo_oci \
&& docker-php-ext-enable \
        oci8

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Install laravel app
RUN composer install

# Setup app
RUN cp .env.example .env

RUN php artisan key:generate

RUN php artisan route:cache

RUN php artisan optimize

RUN php artisan schedule:run

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
