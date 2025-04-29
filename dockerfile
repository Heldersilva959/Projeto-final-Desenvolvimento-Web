FROM php: 8.2-apache
COPY . /var/www/html/ 
RUN chowmd -R www-data:www-data /var/www/html/
EXPOSE 80
