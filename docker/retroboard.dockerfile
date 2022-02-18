FROM php:7.4-fpm-buster

RUN /bin/sh -c apt update -y \
    && apt upgrade -y \
    && apt install apt-transport-https lsb-release ca-certificates wget -y \
    && wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
    && apt-get update -y

RUN /bin/sh -c apt install -y libmcrypt-dev openssl curl git unzip php7.4-mysql

RUN /bin/sh -c docker-php-ext-install mysqli pdo pdo_mysql mbstring \
    && docker-php-ext-enable mysqli

RUN /bin/sh -c curl -sL https://deb.nodesource.com/setup_12.x | bash -

RUN /bin/sh -c apt install -y nodejs

RUN /bin/sh -c curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /source/retroboard

RUN /bin/sh -c git clone https://github.com/gulyasgergely902/retroboard.git /source/retroboard

RUN /bin/sh -c rm -rf composer.lock vendor \
    && composer install --optimize-autoloader --no-dev \
    && php artisan config:cache \
    && npm install --global yarn \
    && yarn global add @vue/cli-service --save-dev \
    && npm install \
    && npm run build

COPY <envfile> /source/retroboard/
COPY <phpconffile> /usr/local/etc/php/conf.d

RUN /bin/sh -c php artisan key:generate
RUN /bin/sh -c php artisan config:clear
RUN /bin/sh -c php artisan cache:clear
CMD ["/bin/sh" "-c" "php artisan serve --host=0.0.0.0 --port=80"]
EXPOSE 80