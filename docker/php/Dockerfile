
ARG php_version=7.4
FROM php:${php_version}-fpm-alpine
# remember to define again in new scope!
ARG php_version=7.4

#Install Composer
RUN set -x; \
    apk add --no-cache \
    wget \
    python3 \
    jq \
    coreutils \
    php7-pdo_mysql \
    zlib-dev libpng-dev

RUN docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install -j$(nproc) pdo_mysql

RUN apk add git bash ghostscript $PHPIZE_DEPS \
    && pecl install xdebug-2.9.2 \
    && docker-php-ext-enable xdebug

RUN apk update && apk add --no-cache supervisor
COPY supervisord.conf /etc/supervisord.conf
RUN mkdir -p /var/log/supervisor

# Installing Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN pecl install redis && docker-php-ext-enable redis

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]


# RUN adduser -S www-data -u 1000
