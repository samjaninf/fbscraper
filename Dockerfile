FROM php:apache

MAINTAINER Tuvok <richard@pegas.io>

ENV DEBIAN_FRONTEND noninteractive

EXPOSE 80 443

RUN echo "force-unsafe-io" > /etc/dpkg/dpkg.cfg.d/02apt-speedup
RUN echo "Acquire::http {No-Cache=True;};" > /etc/apt/apt.conf.d/no-cache

RUN apt-get update -y && apt-get install -y --no-install-recommends libicu-dev libcurl4-gnutls-dev libssl-dev libxft-dev libfreetype6 libfreetype6-dev libfontconfig1 libfontconfig1-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN apt install -y 
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt pdo_mysql intl mysqli #\
#    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
#    && docker-php-ext-install -j$(nproc) gd

COPY scripts/docker-entrypoint.sh /docker-entrypoint.sh && chmod 777 /docker-entrypoint.sh
COPY conf/000-default.conf /etc/httpd/000-default.conf
COPY conf/php.ini /usr/local/etc/php/

WORKDIR /var/www/html

COPY app/. /var/www/html

RUN chmod 755 ./* && chown www-data:www-data -R ./*

RUN a2enmod rewrite

ENTRYPOINT ["/usr/sbin/apachectl", "-D", "FOREGROUND"]
#ENTRYPOINT ["/docker-entrypoint.sh"]
#CMD ["launch"]
