FROM nginx:1.21-alpine

# Установка envsubst
RUN apk add --no-cache gettext

# Копируем конфигурацию Nginx
COPY /docker/nginx/conf.d /etc/nginx/conf.d