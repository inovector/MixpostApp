FROM ubuntu:22.04

LABEL maintainer="Dima Botezatu [dima@inovector.com]"

WORKDIR /var/www/html

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}
ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install softwares (nginx, supervisord, ffmpeg, php-fpm...etc.)
RUN apt update --fix-missing
RUN apt install -y curl nginx supervisor zip unzip git vim mysql-client htop cron
RUN apt install -y ffmpeg
RUN apt install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-mysql php8.2-gd php8.2-curl php8.2-bcmath php8.2-mbstring php8.2-mysqli php8.2-redis php8.2-xml php8.2-zip php8.2-intl

#Clean
RUN apt-get -y autoremove
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN apt clean

# Enable PHP-fpm on nginx virtualhost configuration
COPY nginx/default.conf /etc/nginx/sites-available/default
RUN echo "\ndaemon off;" >> /etc/nginx/nginx.conf

COPY php.ini /etc/php/8.2/fpm/conf.d/99-app.ini
RUN mkdir -p /var/run/php

# Copy supervisor configuration
COPY supervisord.conf /etc/supervisor/supervisord.conf

# Add cron job
ADD crontab /etc/cron.d/mixpost_crontab
RUN chmod 0644 /etc/cron.d/mixpost_crontab
RUN crontab /etc/cron.d/mixpost_crontab
RUN touch /var/log/cron.log

# Copy start.sh script and define default command for the container
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# MacOS staff group's gid is 20, it is already exists in ubuntu. Let's just remove it.
RUN delgroup dialout

# Add user for mixpost application
RUN groupadd -g ${GID} --system mixpost
RUN useradd -g mixpost --system -N -ms /bin/bash -u ${UID} mixpost

# Tell php8.2-fpm to use mixpost user instead of www-data user
RUN sed -i "s/user = www-data/user = mixpost/g" /etc/php/8.2/fpm/pool.d/www.conf
RUN sed -i "s/group = www-data/group = mixpost/g" /etc/php/8.2/fpm/pool.d/www.conf

EXPOSE 80

ENTRYPOINT ["start.sh"]