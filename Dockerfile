FROM php:8.3-fpm-alpine3.17

ARG USER_ID=1000
ARG GROUP_ID=1000

WORKDIR /var/www

RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add --no-cache shadow

RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data

RUN chown -R www-data:www-data /var/www

EXPOSE 9000

USER www-data

CMD ["php-fpm"]
