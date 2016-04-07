FROM php:5.5-cli

RUN apt-get update && apt-get install -y \
    libicu-dev \
    git \
    zlib1g-dev \
    libxml2-dev \
    mysql-client \
    libpng12-dev \
    libmcrypt-dev \
    wkhtmltopdf \
    rubygems

RUN docker-php-ext-install intl mbstring zip mysql pdo_mysql json mcrypt gd

# Xdebug
RUN pecl install -o -f xdebug-2.4.0 \
    && rm -rf /tmp/pear

# Config files
ADD config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY config/php.ini /usr/local/etc/php/php.ini
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Access right
RUN mkdir -p /var/www/html && chown -R www-data:www-data /var/www

#RUN cp /usr/bin/nodejs /usr/bin/node

#RUN npm install less uglify-js2 uglifycss

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

RUN chsh -s /bin/bash www-data

WORKDIR /var/www/html/
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
