FROM php:7.4.28-fpm-buster

RUN apt update -y \
    && apt upgrade -y \
    && apt install apt-transport-https lsb-release ca-certificates wget -y \
    && wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
    && apt-get update -y

RUN apt install -y libmcrypt-dev openssl curl git unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -

RUN apt install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /source/retroboard

RUN git clone https://github.com/gulyasgergely902/retroboard.git /source/retroboard

RUN rm -rf composer.lock vendor \
    && composer install --optimize-autoloader --no-dev \
    && php artisan config:cache \
    && npm install --global yarn \
    && yarn global add @vue/cli-service --save-dev \
    && npm install \
    && npm run build

COPY docker/.env /source/retroboard/
COPY docker/php.ini /usr/local/etc/php/conf.d

RUN php artisan key:generate
RUN php artisan config:clear
RUN php artisan cache:clear
COPY docker/start.sh /source/retroboard/
RUN chmod +x /source/retroboard/start.sh
CMD ["/source/retroboard/start.sh"]
EXPOSE 80