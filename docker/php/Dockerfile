FROM php:7.4-fpm-alpine

MAINTAINER Pavlov Vladimir p4vlow.vl4d@yandex.ru

ENV TZ=Europe/Moscow
RUN rm -rf /etc/localtime && \
    ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime

#install dependencies
RUN apk update && \
    apk upgrade && \
    apk add --no-cache bash git vim curl wget libzip libzip-dev && \
    set -ex \
    && apk --no-cache add --virtual .build-deps $PHPIZE_DEPS

RUN docker-php-ext-configure zip \
  && docker-php-ext-install pdo pdo_mysql bcmath sockets zip \
  opcache \
  && docker-php-source extract \
  && pecl install apcu \
  && docker-php-ext-enable \
    opcache

# install composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /tmp/* /var/tmp/* /usr/share/doc/*

RUN mkdir /home/app/ && \
    apk --no-cache add shadow && \
    groupadd -g 1000 app && \
    useradd -g 1000 -u 1000 -b /home/app app && \
    chown app:app -R /home/*

USER app

WORKDIR /var/www