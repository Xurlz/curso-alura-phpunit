FROM php:8.1.33-cli-alpine

WORKDIR /src/github.com/xurlz/curso-alura-phpunit

COPY . .

RUN apk update && apk add composer

RUN composer install

ENTRYPOINT ["/bin/sh"]

