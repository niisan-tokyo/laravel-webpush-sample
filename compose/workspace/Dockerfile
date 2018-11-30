FROM php:alpine
MAINTAINER Niikura Rtyota <ryota.niikura@nijibox.co.jp>

RUN apk add --update --no-cache --virtual .build_deps unzip zlib-dev gmp-dev $PHPIZE_DEPS && \
    apk add libpng-dev gmp bzip2-dev && \
    docker-php-ext-install mysqli pdo_mysql gd bz2 zip gmp && \
    apk del .build_deps

RUN curl -sS https://getcomposer.org/installer | php; mv composer.phar /usr/local/bin/composer ; mkdir /var/dev

RUN curl -L -o /usr/bin/phpmd http://static.phpmd.org/php/latest/phpmd.phar && chmod +x /usr/bin/phpmd
RUN composer global require hirak/prestissimo
RUN mkdir /var/www

WORKDIR /var/www

CMD ["sh"]
