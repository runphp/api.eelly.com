FROM php:7.1-fpm-alpine

LABEL maintainer="runphp <runphp@qq.com>"

ENV PHALCON_VERSION=3.2.2

# compile phalcon extension
RUN set -xe \
    && apk add --no-cache --virtual .build-deps autoconf g++ make pcre-dev re2c \
    && curl -fsSL https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz -o cphalcon.tar.gz \
    && mkdir -p cphalcon \
    && tar -xf cphalcon.tar.gz -C cphalcon --strip-components=1 \
    && rm cphalcon.tar.gz \
    && cd cphalcon/build \
    && sh install \
    && rm -rf cphalcon \
    && docker-php-ext-enable phalcon

# install some extension
RUN docker-php-ext-install pdo_mysql bcmath

RUN pecl install igbinary-2.0.1 \
    && pecl install mongodb-1.2.9 \
    && pecl install redis-3.1.0 \
    && pecl install xdebug-2.5.0 \
    && docker-php-ext-enable igbinary mongodb redis xdebug