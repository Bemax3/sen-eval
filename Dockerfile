FROM php:8.2-cli as php

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
ENV COMPOSER_VERSION 2.1.5
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash

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
    && apt-get clean \
    && pecl install redis \
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
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*;

#RUN apt-get update && \
#    apt-get install -y libaio1 unzip && \
#    mkdir /opt/oracle && \
#    cd /opt/oracle && \
#    curl -o https://download.oracle.com/otn_software/linux/instantclient/instantclient-basiclite-linuxx64.zip ; \
#    curl -o https://download.oracle.com/otn_software/linux/instantclient/instantclient-sdk-linuxx64.zip \ ;\
#      unzip instantclient-basiclite-linuxx64.zip ; \
#      unzip instantclient-sdk-linuxx64.zip ;\
#      rm -f instantclient-basiclite-linuxx64.zip; \
#      rm -f instantclient-sdk-linuxx64.zip; \
#      mv instantclient*/ /usr/lib/instantclient; \
#      cd /usr/lib/instantclient ; \
#      rm -f *jdbc* *occi* *mysql* *README *jar uidrvci genezi adrci; \
#      echo /usr/lib/instantclient > /etc/ld.so.conf.d/oracle-instantclient.conf ;\
#      ldconfig ;\
#    echo 'instantclient,/usr/lib/instantclient' | pecl install oci8; \
#    docker-php-ext-enable oci8;
#

#    curl -o instantclient-basic-linux.x64-19.8.0.0.0dbru.zip https://download.oracle.com/otn_software/linux/instantclient/19800/instantclient-basic-linux.x64-19.8.0.0.0dbru.zip && \
#    curl -o instantclient-sdk-linux.x64-19.8.0.0.0dbru.zip https://download.oracle.com/otn_software/linux/instantclient/19800/instantclient-sdk-linux.x64-19.8.0.0.0dbru.zip && \
#    unzip instantclient-basic-linux.x64-19.8.0.0.0dbru.zip && \
#    unzip instantclient-sdk-linux.x64-19.8.0.0.0dbru.zip && \
#    rm -f instantclient-basic-linux.x64-19.8.0.0.0dbru.zip instantclient-sdk-linux.x64-19.8.0.0.0dbru.zip && \
#    echo /opt/oracle/instantclient_19_8 > /etc/ld.so.conf.d/oracle-instantclient.conf

#ENV ORACLE_HOME /opt/oracle/
#ENV DYLD_LIBRARY_PATH /opt/oracle/instantclient_19_8
#ENV LD_LIBRARY_PATH /opt/oracle/instantclient_19_8
#RUN ldconfig
#
#RUN echo 'instantclient,/opt/oracle/instantclient_19_8' | pecl install oci8-2.2.0 && \
#    docker-php-ext-enable oci8



WORKDIR /var/www

COPY . .

ENV PORT=8000
RUN chmod +x Docker/entrypoint.sh
ENTRYPOINT [ "Docker/entrypoint.sh" ]
