FROM php:5.5-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    zlib1g-dev \
    git \
    libxml2-dev \
    libpng12-dev \
    libmcrypt-dev \
    wget \
    xz-utils \
    libxrender1 \
    libfontconfig1 \
    && rm -rf /var/lib/apt/lists/*

RUN cd / && wget -q https://downloads.wkhtmltopdf.org/0.12/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz -O - | tar xvJ \
    && apt-get remove -y wget && cp -r /wkhtmltox/* /usr/ && rm -rf /wkhtmltox

RUN apt-get install -y libmcrypt-dev
RUN docker-php-ext-install intl mbstring zip mysql pdo_mysql json mcrypt gd

# Xdebug
RUN pecl install -o -f xdebug-2.4.0 \
    && rm -rf /tmp/pear

ADD config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY config/php.ini /usr/local/etc/php/php.ini
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
