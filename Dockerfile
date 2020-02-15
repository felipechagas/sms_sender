FROM node:12-slim AS VUE-BUILD

WORKDIR /app
COPY ./view/package.json ./view/yarn.lock ./
RUN yarn install

COPY ./view/ .
RUN yarn build

EXPOSE 8080
CMD ["yarn", "serve"]

FROM debian:10-slim
ARG COMPOSER_VERSION=1.9.3

# Installing composer and lumen's dependencies and tini to ensure proper SIGTERM handling
RUN apt-get update -qm \
    && apt-get install -qy php7.3 php7.3-mbstring php7.3-zip php7.3-xml \
    php7.3-mysql php7.3-curl apache2 libapache2-mod-php unzip tini
# Installing composer to /usr/bin/composer
RUN cd /usr/bin \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --filename=composer --version=${COMPOSER_VERSION} \
    && rm composer-setup.php \
    # Changing a couple default configurations for the apache server
    && perl -pi \
    -e 's/DirectoryIndex ((index\.(?!php)\w+ )+)index\.php ((index.(?!php)\w+ ?)+)/DirectoryIndex index.php \1\3/' \
    /etc/apache2/mods-enabled/dir.conf \
    && sed -Ei 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' \
    /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/html

COPY . .
# Removing raw view files
RUN rm -rf ./view/ \
    # Installing project's dependencies
    && php /usr/bin/composer install
COPY --from=VUE-BUILD /public/view/ ./public/view/

EXPOSE 80
ENTRYPOINT [ "tini", "--" ]
CMD ["sh", "-c", "/var/www/html/entrypoint.sh"]
