FROM nginx

ADD docker/nginx_conf/custom_vhost.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/laravel-news
