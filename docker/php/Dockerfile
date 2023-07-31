FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN apt update && apt-get upgrade -y \
    && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
&& mv composer.phar /usr/local/bin/composer \
&& composer self-update


# #Composer install
# RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN php composer-setup.php
# RUN php -r "unlink('composer-setup.php');"
# RUN mv composer.phar /usr/local/bin/composer

# ENV COMPOSER_ALLOW_SUPERUSER 1
# ENV COMPOSER_HOME /composer

# ENV PATH $PATH:/composer/vendor/bin


WORKDIR /var/www

# RUN composer global require "laravel/installer"
