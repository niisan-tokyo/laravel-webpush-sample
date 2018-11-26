FROM php:fpm-alpine

RUN apk add --update --no-cache --virtual .build_deps unzip bzip2-dev zlib-dev gmp-dev && \
    apk add libpng-dev gmp && \
    docker-php-ext-install mysqli pdo_mysql bz2 gd zip gmp && \
    apk del .build_deps

RUN set -x \
  && deluser www-data \
	&& addgroup -g 50 -S www-data \
	&& adduser -u 1000 -D -S -G www-data www-data \
  && docker-php-ext-install opcache \
  && docker-php-ext-enable opcache

COPY ./laravel.ini /usr/local/etc/php/conf.d/
COPY ./laravel.conf /usr/local/etc/php-fpm.d/

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
