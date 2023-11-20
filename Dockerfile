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
    && mkdir -p /opt/oracle \
    && cd /opt/oracle \
    && curl https://download.oracle.com/otn_software/linux/instantclient/191000/instantclient-basic-linux.arm64-19.10.0.0.0dbru-2.zip > /opt/oracle/instantclient-basic.zip \
    && curl https://download.oracle.com/otn_software/linux/instantclient/191000/instantclient-sdk-linux.arm64-19.10.0.0.0dbru.zip > /opt/oracle/instantclient-sdk.zip \
    && unzip /opt/oracle/instantclient-basic.zip -d /opt/oracle \
    && unzip /opt/oracle/instantclient-sdk.zip -d /opt/oracle \
    && rm /opt/oracle/instantclient-basic.zip \
    && rm /opt/oracle/instantclient-sdk.zip \
    && echo /opt/oracle/instantclient_19_10 > /etc/ld.so.conf.d/oracle-instantclient.conf \
    && ldconfig -v \
    # Install libaio1
    && apt update \
    && apt install libaio1 \
    # Install and enable OCI8
    && echo "instantclient,/opt/oracle/instantclient_19_10" | pecl install oci8-3.2.1 \
    && docker-php-ext-enable oci8


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
