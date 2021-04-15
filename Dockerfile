FROM php:7.0-alpine
RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer && \
		composer self-update 1.10.16 && \
		composer --version && \
		composer global require hirak/prestissimo --no-plugins --no-scripts

RUN composer global require hirak/prestissimo

WORKDIR /usr/src/myapp
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer

COPY . .

RUN composer dump-autoload --no-scripts --no-dev --optimize

EXPOSE 80

CMD [ "php", "artisan", "serve", "--port=80", "--host=0.0.0.0"]
