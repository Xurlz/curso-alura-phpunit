FROM php:8.1.33-cli-alpine

WORKDIR /src/github.com/xurlz/curso-alura-phpunit

COPY . .

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions @composer && \
  /usr/local/bin/composer install

CMD ["composer","exec", "--", "phpunit"]

