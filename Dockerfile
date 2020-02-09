FROM debian:10-slim
ARG COMPOSER_VERSION=1.9.3

# Installing composer and lumen's dependencies
RUN apt-get update -qm \
    && apt-get install -qy php7.3 php7.3-mbstring php7.3-zip php7.3-xml \
    php7.3-mysql apache2 libapache2-mod-php unzip tini \
    # Changing a couple default configurations for the apache server
    && perl -pi -e 's/DirectoryIndex ((index\.(?!php)\w+ )+)index\.php ((index.(?!php)\w+ ?)+)/DirectoryIndex index.php \1\3/' /etc/apache2/mods-enabled/dir.conf \
    && sed -Ei 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-enabled/000-default.conf \
    # Installing composer to /usr/bin/composer
    && cd /usr/bin \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'c5b9b6d368201a9db6f74e2611495f369991b72d9c8cbd3ffbc63edff210eb73d46ffbfce88669ad33695ef77dc76976') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --filename=composer --version=${COMPOSER_VERSION} \
    && php -r "unlink('composer-setup.php');"

WORKDIR /var/www/html
COPY . .
# Installing the project's dependencies
RUN php /usr/bin/composer install

EXPOSE 80

# Using tini as systemd is used to ensure proper SIGTERM handling
ENTRYPOINT [ "tini", "--" ]
CMD ["sh", "-c", "/var/www/html/entrypoint.sh"]
