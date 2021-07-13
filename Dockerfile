FROM php:7.4-apache
COPY ./.docker/vhost.conf /etc/apache2/sites-available/000-default.conf
WORKDIR /var/www/html
RUN apt update && apt install -y libpq-dev \
  && a2enmod rewrite
#   && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql \
#   && docker-php-ext-install pdo pdo_pgsql pgsql \