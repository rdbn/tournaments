FROM alpine:3.17

RUN apk update && apk upgrade
RUN apk add php-fpm php-curl php-json php-intl php-mbstring php-opcache php-openssl php-pdo \
    php-pdo_mysql php-mysqli php-dom php-xml php-xmlwriter php-zlib php-phar php-ctype php-iconv php-pear gcc musl-dev \
    php-tokenizer php-session php-simplexml php-pcntl php-zip php-bcmath php-sockets make autoconf curl git openssh libmcrypt-dev libmcrypt php81-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add --update linux-headers
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug-3.2.2 \
    && apk del -f .build-deps

COPY php.ini /etc/php81/php.ini
COPY php-fpm.conf /etc/php81/php-fpm.conf
COPY www.conf /etc/php81/php-fpm.d/www.conf
COPY xdebug.ini /etc/php81/conf.d/xdebug.ini

WORKDIR /var/www/tournaments
EXPOSE 9001

CMD ["php-fpm81", "-F", "-R"]