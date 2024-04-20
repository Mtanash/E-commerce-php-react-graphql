FROM php:8.2-apache

WORKDIR /var/www/html

COPY . .

# Enable mod_rewrite
RUN a2enmod rewrite

# Modify Apache configuration
RUN sed -i '/<Directory \/var\/www\/html>/a \\tLogLevel debug\n\tLimitInternalRecursion 20' /etc/apache2/apache2.conf
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# install composer
RUN apt-get update && apt-get install -y git zip unzip curl bash
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

# Install PHP extensions (pdo_mysql)
RUN docker-php-ext-install pdo_mysql

EXPOSE 80

CMD ["apache2ctl", "-D", "FOREGROUND"]