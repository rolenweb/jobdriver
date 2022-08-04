FROM php:8.1-fpm-alpine

COPY ./etc/php-dev.ini /usr/local/etc/php/php.ini

ENV DEPS \
    autoconf \
    g++ \
    libtool \
    pcre-dev

RUN set -xe \
    && mkdir storage \
    && chmod 644 /usr/local/etc/php/php.ini \
    && chown -R 82:82 /var/www/html \
    && apk update \
    && apk add --no-cache ca-certificates bash make git\
    && apk add --update --no-cache $DEPS \
    # postgresql
    && apk add --update --no-cache postgresql-dev fcgi \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql \
    # zip
    && apk add --no-cache libzip-dev \
    && docker-php-ext-configure zip --with-zip=/usr/include \
    && docker-php-ext-install zip \
    # gd
    && apk add --update --no-cache freetype-dev libjpeg-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd \
    # redis \
    && apk add --no-cache pcre-dev \
    && pecl install redis \
    && docker-php-ext-enable redis.so\
    # xdebug
    && pecl install xdebug-3.1.3 \
    && docker-php-ext-enable xdebug \
    # clearing
    && apk del $DEPS \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/* \
    # composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
