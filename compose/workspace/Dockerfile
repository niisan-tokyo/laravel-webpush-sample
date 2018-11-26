FROM php:alpine
MAINTAINER Niikura Rtyota <ryota.niikura@nijibox.co.jp>

RUN apk add --update --no-cache --virtual .build_deps unzip bzip2-dev zlib-dev gmp-dev $PHPIZE_DEPS && \
    apk add libpng-dev gmp && \
    docker-php-ext-install mysqli pdo_mysql gd zip gmp && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    apk del .build_deps

RUN docker-php-ext-install bz2 && \
    curl -sS https://getcomposer.org/installer | php; mv composer.phar /usr/local/bin/composer ; mkdir /var/dev

RUN curl -L -o /usr/bin/phpmd http://static.phpmd.org/php/latest/phpmd.phar && chmod +x /usr/bin/phpmd
RUN mkdir /var/www

WORKDIR /var/www

CMD ["sh"]
