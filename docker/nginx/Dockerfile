FROM alpine:latest

RUN apk add --update nginx
RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*

ADD nginx.conf /etc/nginx/
ADD tournaments.conf /etc/nginx/conf.d/

RUN echo "upstream php-upstream { server php:9001; }" > /etc/nginx/conf.d/upstream.conf

RUN adduser -D -g '' -G www-data www-data

RUN chown -R root:www-data /var/www
RUN chmod g+w -R /var/www

CMD ["nginx"]

EXPOSE 88