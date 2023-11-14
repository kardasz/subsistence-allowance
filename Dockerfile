# Dockerfile
FROM php:8.2-fpm-alpine as php

LABEL Maintainer="Krzysztof Kardasz <krzysztof@kardasz.eu>"

ENV TZ UTC

ENV GLOBAL_COMPOSER_HOME /root/.composer
ENV PATH $PATH:/root/.composer/vendor/bin
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apk --update add \
        autoconf \
        g++ \
        make \
        tzdata \
        icu-dev \
        postgresql14-dev \
        postgresql14-client \
        libzip-dev \
        unzip && \
    docker-php-ext-install bcmath pdo_pgsql opcache intl zip && \
    rm /var/cache/apk/*

# TimeZone
RUN cp /usr/share/zoneinfo/UTC /etc/localtime && echo "UTC" >  /etc/timezone

RUN printf "variables_order = EGPCS" > /usr/local/etc/php/conf.d/custom.ini && \
    printf "\nmemory_limit = 256M" >> /usr/local/etc/php/conf.d/custom.ini && \
    printf "\nmax_execution_time = 120" >> /usr/local/etc/php/conf.d/custom.ini && \
    printf "\ndisplay_errors = 1" >> /usr/local/etc/php/conf.d/custom.ini && \
    printf "\ndisplay_startup_errors = 1" >> /usr/local/etc/php/conf.d/custom.ini && \
    printf "\nmax_input_vars = 3000" >> /usr/local/etc/php/conf.d/custom.ini && \
    printf "\ndate.timezone = UTC" >> /usr/local/etc/php/conf.d/custom.ini && \
    printf "\nupload_max_filesize = 10M" >> /usr/local/etc/php/conf.d/custom.ini && \
    printf "\npost_max_size = 10M" >> /usr/local/etc/php/conf.d/custom.ini && \
    printf "\nerror_log = /proc/1/fd/2" >> /usr/local/etc/php/conf.d/custom.ini

RUN printf "[www]" > /usr/local/etc/php-fpm.d/zz-custom.conf && \
    printf "\npm = dynamic" >> /usr/local/etc/php-fpm.d/zz-custom.conf && \
    printf "\npm.max_children = 100" >> /usr/local/etc/php-fpm.d/zz-custom.conf && \
    printf "\npm.start_servers = 16" >> /usr/local/etc/php-fpm.d/zz-custom.conf && \
    printf "\npm.min_spare_servers = 8" >> /usr/local/etc/php-fpm.d/zz-custom.conf && \
    printf "\npm.max_spare_servers = 16" >> /usr/local/etc/php-fpm.d/zz-custom.conf && \
    printf "\npm.max_requests = 500" >> /usr/local/etc/php-fpm.d/zz-custom.conf && \
    printf "\npm.status_path = /_fpm-status" >> /usr/local/etc/php-fpm.d/zz-custom.conf

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /app

ADD . /app

RUN composer install --prefer-dist --no-scripts --no-progress --optimize-autoloader

EXPOSE 9000

FROM php AS dev

RUN apk add --update linux-headers \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /app

