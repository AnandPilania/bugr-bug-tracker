FROM node:18
RUN apt-get update && apt-get upgrade -y

COPY --from=composer /usr/bin/composer /usr/bin/

WORKDIR /app

ENTRYPOINT npm start