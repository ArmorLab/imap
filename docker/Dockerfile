FROM php:apache
RUN apt-get update -y && \
    apt-get install -y libpng-dev libfreetype6-dev libjpeg62-turbo-dev nano acl && \
    docker-php-ext-install pdo pdo_mysql mysqli && \
    usermod -u 1000 www-data
