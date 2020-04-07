FROM phpdockerio/php72-fpm:latest
RUN apt-get update \
	&& apt-get install -y curl zip nano unzip git software-properties-common \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get -y --no-install-recommends install  php7.2-mysql php-redis php7.2-sqlite php-igbinary php-imagick php7.2-mbstring php7.2-gd php7.2-zip \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* /var/www/api/temp/*

WORKDIR "/var/www"

RUN mkdir log

ENTRYPOINT composer install && php cli --no-interaction migrations:migrate