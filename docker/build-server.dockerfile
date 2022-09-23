FROM node:18
RUN apt-get update && apt-get upgrade -y
RUN npm install -g serve

RUN mkdir -p /app/build

WORKDIR /app

ENTRYPOINT npm install && serve -s build