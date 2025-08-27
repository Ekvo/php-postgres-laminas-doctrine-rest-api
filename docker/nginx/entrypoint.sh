#!/bin/sh
set -e

# Подставляем переменные из .env в шаблон
envsubst '${NGINX_PORT} ${NGINX_HOST}' \
  < /etc/nginx/conf.d/app.conf.template \
  > /etc/nginx/conf.d/app.conf

# Запускаем Nginx
exec "$@"