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

# compile phpiredis extension
RUN set -xe \
    && apk --no-cache --virtual add hiredis-dev \
    && curl -fsSL https://github.com/nrk/phpiredis/archive/v1.0.0.tar.gz -o phpiredis.tar.gz \
    && mkdir -p /tmp/phpiredis \
    && tar -xf phpiredis.tar.gz -C /tmp/phpiredis --strip-components=1 \
    && rm phpiredis.tar.gz \
    && docker-php-ext-configure /tmp/phpiredis --enable-phpiredis \
    && docker-php-ext-install /tmp/phpiredis \
    && rm -r /tmp/phpiredis

# install some extension
RUN docker-php-ext-install bcmath pdo_mysql

RUN set -xe && pecl install igbinary-2.0.1 && docker-php-ext-enable igbinary
RUN set -xe && pecl install mongodb-1.2.9 && docker-php-ext-enable mongodb
RUN set -xe && pecl install xdebug-2.5.5 && docker-php-ext-enable xdebug

# install nginx
RUN apk --no-cache add nginx

RUN mkdir -p /var/www/html
WORKDIR /var/www/html

EXPOSE 80 443

STOPSIGNAL SIGTERM

CMD ["nginx", "-g", "daemon off;"]