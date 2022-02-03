FROM php:7.4-alpine
RUN apk add nginx
RUN mkdir -p /run/nginx
COPY . /srv/
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
EXPOSE 80
STOPSIGNAL SIGTERM
CMD ["nginx", "-g", "daemon off;"]
