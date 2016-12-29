FROM php:5.5-cli

RUN apt-get update && apt-get install -y \
    libicu-dev \
    git \
    zlib1g-dev \
    libxml2-dev \
    mysql-client \
    libpng12-dev \
    libmcrypt-dev \
    wget \
    xz-utils \
    libxrender1 \
    libfontconfig1 \
    rubygems \
    && rm -rf /var/lib/apt/lists/*

RUN cd / && wget -q http://download.gna.org/wkhtmltopdf/0.12/0.12.3/wkhtmltox-0.12.3_linux-generic-amd64.tar.xz -O - | tar xvJ \
    && apt-get remove -y wget && cp -r /wkhtmltox/* /usr/ && rm -rf /wkhtmltox

RUN docker-php-ext-install intl mbstring zip mysql pdo_mysql json mcrypt gd

# Xdebug
RUN pecl install -o -f xdebug-2.4.0 \
    && rm -rf /tmp/pear

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

# Capifony
RUN gem install -N net-ssh:3.1.1 capifony:2.8.3 capistrano_colors slack-notifier

# Assign a shell to user www-data
RUN chsh -s /bin/bash www-data

# Access right
RUN mkdir -p /var/www/html && chown -R www-data:www-data /var/www

# Copy configuration files
ADD config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY config/php.ini /usr/local/etc/php/php.ini
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
COPY .bashrc /var/www/.bashrc

WORKDIR /var/www/html/
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
