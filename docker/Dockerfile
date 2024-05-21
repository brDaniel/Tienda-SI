FROM php:8.2-apache

ENV ACCEPT_EULA=Y

RUN apt-get update && apt-get install -y \
gnupg2 \
git \
zip \
unzip

RUN apt-get update && apt-get install -y gnupg2
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/ubuntu/22.04/prod.list > /etc/apt/sources.list.d/mssql-release.list 

RUN apt-get update
RUN ACCEPT_EULA=Y apt-get -y --no-install-recommends install msodbcsql17 unixodbc-dev

RUN pecl install sqlsrv 
RUN pecl install pdo_sqlsrv
RUN docker-php-ext-enable sqlsrv pdo_sqlsrv
RUN a2enmod rewrite
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/
# RUN composer global require leafs/cli
# RUN ln -s /root/.composer/vendor/bin/leaf /usr/local/bin/leaf
RUN composer install


CMD ["apache2-foreground"]
EXPOSE 80
