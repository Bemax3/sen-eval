FROM anhquang0611/php8.2-oci8:latest as php

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

#RUN apt update && apt install -y \
#    libaio1 \
#	libaio-dev \
#    libbz2-dev \
#    libcurl4-openssl-dev \
#    libffi-dev \
#    libldap2-dev \
#    libldb-dev \
#    libonig-dev \
#	libzip-dev \
#    libpng-dev \
#    libssl-dev \
#    unixodbc-dev \
#    unzip \
#    wget \
#    zlib1g-dev \
#	git \
#	vim \
#    && rm -rf /var/lib/apt/lists/*
#
#RUN docker-php-source extract \
#    && docker-php-ext-install \
#        bz2 \
#        curl \
#        ffi \
#        fileinfo \
#        gd \
#        gettext \
#        ldap \
#        mbstring \
#        exif \
#        mysqli \
#	zip \
#    && docker-php-source delete \
#
#RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

COPY . .

ENV PORT=8000
RUN chmod +x Docker/entrypoint.sh
ENTRYPOINT [ "Docker/entrypoint.sh" ]
