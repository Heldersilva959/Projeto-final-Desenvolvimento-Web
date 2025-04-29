FROM php:8.2-cli
WORKDIR /var/www/html
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY . .
EXPOSE 3000
CMD ["php", "-S", "0.0.0.0:3000"]