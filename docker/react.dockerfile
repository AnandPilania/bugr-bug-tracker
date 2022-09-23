FROM node:18
RUN apt-get update && apt-get upgrade -y

RUN mkdir /app

WORKDIR /app

ENTRYPOINT npm install && npm start