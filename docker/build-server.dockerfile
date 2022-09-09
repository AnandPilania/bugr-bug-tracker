FROM php:8.1

RUN mkdir /app

WORKDIR /app

ENTRYPOINT ["php", "-S", "0.0.0.0:80", "index.html"]
