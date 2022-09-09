FROM nginx:1.22
ADD nginx/prod.conf /etc/nginx/conf.d/default.conf
